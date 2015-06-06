<?php
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
require_once("Mail.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

try {
	// verify the form was submitted OK
	if (@isset($_POST["email"]) === false    ||
		 @isset($_POST["password"]) === false ||
		 @isset($_POST["password2"]) === false) {
		throw(new RuntimeException("form variables incomplete or missing"));
	}

	// verify the passwords match
	if($_POST["password"] !== $_POST["password2"]) {
		throw(new RuntimeException("passwords do not match"));
	}
	// create a new hashed password, salt, and activation
	$salt = bin2hex(openssl_random_pseudo_bytes(32));
	$hash = hash_pbkdf2("sha512", $_POST["password"], $salt, 2048, 128);
	$activation = bin2hex(openssl_random_pseudo_bytes(16));

	//validate email before using with db to protect against injections
	$newEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	if($_POST['email'] !== $newEmail) {
		throw(new InvalidArgumentException('email contains disallowed characters'));
	}


	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
	//check to see if the email already exists
	$result = Email::getEmailIdByEmailAddress($pdo, $newEmail);
	//if we get a result, the email has made a purchase
	if($result !== null) {
	//so check the account table if they have an account already
		$account = Account::getAccountByEmailId($pdo, $result);
		if($account !== null) {
			throw(new InvalidArgumentException('Account already exists!'));
			}
		$oldEmailId = Email::getEmailIdByEmailAddress($pdo, $email);
		$oldEmailId = $oldEmailId->getEmailId();
		//if no account, update it with the password
		if($account === null) {
			$newAccount = new Account (null, $hash, $salt, $activation, null, $oldEmailId);
			$newAccount->insert($pdo);
			echo 'Account successfully created, welcome back!';
			}
	}

	// if you DONT get a result, that means there are no emails by that emailAddress so
	// create a User and Profile object and insert them into mySQL
	// finally, we should log them in so their session is open when they go
	// to activate! HANDY!
	if($result === null) {
		$email = new Email(null, $newEmail, null);
		$email->insert($pdo);
		$account = new Account(null, $hash, $salt, $activation, null, $email->getEmailId());
		$account->insert($pdo);
	}

	// email the user with an activation message
	$to = $email->getEmailAddress();
	$from = "cheqoutinfo@gmail.com";

	//build headers
	$headers = array();
	$headers["To"] = $to;
	$headers["From"] = $from;
	$headers["Reply-To"] = $from;
	$headers["Subject"] = "Activation for your new Cheqout account";
	$headers["MIME-Version"] = "1.0";
	$headers["Content-Type"] = "text/html; charset=UTF-8";

	// build message
	$array = explode("/", $_SERVER["PHP_SELF"]);
	$pageName = end($array);
	$url = "https://" . $_SERVER["SERVER_NAME"] . $_SERVER["PHP_SELF"];
	$url = str_replace($pageName, "activate.php", $url);
	$url = "$url?activation=$activation";
	$message = <<< EOF
<html>
	<body>
		<h3>Welcome to Cheqout</h3>
		<p>Thank you for signing up with us. <br />Visit the following URL to complete your registration process: <br /><a href="$url">Verify my email.</p>
	</body>
</html>
EOF;

	// send the email
	error_reporting(E_ALL & ~E_STRICT & ~E_DEPRECATED);
	$mailer =& Mail::factory("sendmail");
	$status = $mailer->send($to, $headers, $message);
	if(PEAR::isError($status) === true) {
		echo "<strong>Uh oh!</strong> Unable to send mail message:" . $status->getMessage();
} else {

		// i think the way that this whole process happens is a bit sloppy.
		// the email sending isnt in an if block, just after a bunch of them. it should
		// directly be tied to one imo...
		if($email !== null && $account !== null) {
			$_SESSION["email"] = $email;
			$_SESSION["account"] = $account;
		}
		$_SESSION['notification'] = "<strong>Registration sent!</strong> Please verify your email by clicking on the link we sent you.";
		header('Location: ' . $_SERVER['HTTP_REFERER']);
}
		} catch(Exception $exception) {
	echo "<strong>Uh oh!</strong> Unable to sign up: " . $exception->getMessage();
}
?>

