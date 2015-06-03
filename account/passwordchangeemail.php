<?php
require_once (dirname(__DIR__)) . "/php/class/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once("Mail.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
session_start();

// go into the database and grab their email object
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
if(@isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
}
if(@isset($_SESSION["account"])) {
	$account = $_SESSION["account"];
}

if(isset($_POST['password]'])) {
	$emailAddress = $email->getEmailAddress();
	$loginData = Email::getLoginDataByEmailAddress($pdo, $emailAddress);
	$password = hash_pbkdf2("sha512", $_POST["password"], $loginData[2], 2048, 128);
}
if($vPassword === $loginData[1]) {
	try {
		$activation = bin2hex(openssl_random_pseudo_bytes(16));
	//	$newAccountId, $newAccountPassword, $newAccountPasswordSalt, $newActivation, $newAccountCreateDateTime, $newEmailId
		$account = new Account($_SESSION["account"]->getAccountId(),
			$_SESSION["account"]->getAccountPassword(),
			$_SESSION["account"]->getAccountPasswordSalt(),
			$activation,
			$_SESSION["account"]->getAccountCreateDateTime(),
			$_SESSION["account"]->getEmailId());
		$account->update($pdo, $account);
		// email the user with an activation message
		$to = $emailAddress;
		$from = "twiegand@cnm.edu";

		// build headers
		$headers = array();
		$headers["To"] = $to;
		$headers["From"] = $from;
		$headers["Reply-To"] = $from;
		$headers["Subject"] = "Change Your Cheqout Email";
		$headers["MIME-Version"] = "1.0";
		$headers["Content-Type"] = "text/html; charset=UTF-8";

		// build message
		$serverself = explode("/", $_SERVER["PHP_SELF"]);
		$pageName = end($serverself);
		$url = "https://" . $_SERVER["SERVER_NAME"] . $_SERVER["PHP_SELF"];
		$url = str_replace($pageName, "passwordchangeform.php", $url);
		$url = "$url?activation=$activation";
		$message = <<< EOF
<html>
	<body>
		<h1>Thank you for using the Cheqout Secure Password Change Form</h1>
		<hr />
		<p>Click the following link to change your password: <a href="$url">$url</a>.</p>
	</body>
</html>
EOF;

		// send the email
		error_reporting(E_ALL & ~E_STRICT & ~E_DEPRECATED);
		$mailer =& Mail::factory("sendmail");
		$status = $mailer->send($to, $headers, $message);
		if(PEAR::isError($status) === true) {
			echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong> Unable to send mail message:" . $status->getMessage() . "</div>";
		} else {
			echo "<div class=\"alert alert-success\" role=\"alert\"><strong>Sign up successful!</strong> Please check your Email to complete the signup process.</div>";
		}

	} catch(Exception $exception) {
		echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong> Unable to sign up: " . $exception->getMessage() . "</div>";
	}
}
	else {
		echo '<p>Your password is incorrect</p>';
	}
}
?>