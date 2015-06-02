<?php
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
require_once("Mail.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

try {
	// verify the form was submitted OK
	if (@isset($_POST["email"]) === false || @isset($_POST["password"]) === false || @isset($_POST["password2"]) === false) {
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

	// create a User and Profile object and insert them into mySQL
	if($result=== null) {
		$email = new Email(null, $newEmail, null);
		$email->insert($pdo);
		$account = new Account(null, $hash, $salt, $activation, null, $email->getEmailId());
		$account->insert($pdo);
	}

	// email the user with an activation message
	$to = $email->getEmailAddress();
	$from = "ouremail@gmail.com";

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
		<h1>Welcome to Cheqout</h1>
		<hr />
		<p>Thank you for signing up with us. Visit the following URL to complete your registration process: <a href="$url">$url</a>.</p>
	</body>
</html>
EOF;

	// send the email
	error_reporting(E_ALL & ~E_STRICT & ~E_DEPRECATED);
	$mailer =& Mail::factory("sendmail");
	$status = $mailer->send($to, $headers, $message);
	if(PEAR::isError($status) === true)
	{
		echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong> Unable to send mail message:" . $status->getMessage() . "</div>";
	}
	else
	{
		echo "<div class=\"alert alert-success\" role=\"alert\"><strong>Sign up successful!</strong> Please check your Email to complete the signup process.</div>";
	}

} catch(Exception $exception) {
	echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong> Unable to sign up: " . $exception->getMessage() . "</div>";
}
?>

