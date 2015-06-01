<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once(dirname(__DIR__)) . "/php/class/account.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once("Mail.php");
// go into the database and grab their email object
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
$emailAddress = $_SESSION["emailAddress"];
$account = $_SESSION["account"];

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
	$headers["Subject"] = "Cheqout Account Update Form";
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


	echo '<p class=\"alert alert-success\">E-Mail sent to ' . $emailAddress . '!</p>';
}	catch(Exception $exception) {
	echo "<p class=\"alert alert-danger\">Exception: " . $exception->getMessage() . "</p>";
}
?>