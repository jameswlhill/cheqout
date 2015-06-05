<?php
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once("Mail.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// go into the database and grab their email object
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
	if(@isset($_SESSION["email"])) {
		$email = $_SESSION["email"];
	}
	if(@isset($_SESSION["account"])) {
		$account = $_SESSION["account"];
	}
	if(isset($_POST['password'])) {
		$emailAddress = $email->getEmailAddress();
		$loginData = Email::getLoginDataByEmailAddress($pdo, $emailAddress);
		$password = hash_pbkdf2("sha512", $_POST["password"], $loginData[2], 2048, 128);
	}
	if($password === $loginData[1]) {
		try {
			$activation = bin2hex(openssl_random_pseudo_bytes(16));
			$testActivation = $account->getActivation();
				if($testActivation !== null) {
					throw(new InvalidArgumentException("You must first activate your account or complete your password change before you can change your email."));
				}
			$account->setActivation($activation);
			$account->update($pdo);

			// email the user with an activation message
			$to = $emailAddress;
			$from = "cheqoutinfo@gmail.com";

			// build headers
			$headers = array();
			$headers["To"] = $to;
			$headers["From"] = $from;
			$headers["Reply-To"] = $from;
			$headers["Subject"] = "Change Your Cheqout Email";
			$headers["MIME-Version"] = "1.0";
			$headers["Content-Type"] = "text/html; charset=UTF-8";

			// build message
			$array = explode("/", $_SERVER["PHP_SELF"]);
			$pageName = end($array);
			$url = "https://" . $_SERVER["SERVER_NAME"] . $_SERVER["PHP_SELF"];
			$url = str_replace($pageName, "emailchange.php", $url);
			$url = "$url?emailchange=$activation";
			$message = <<< EOF
<html>
	<body>
		<p>Someone requested an email change for your Cheqout account. <br />Please reply to this message if you did not initiate this change.<br /></p>
		<h3>To select your new email</h3>
		<p>Click the following link: <br /><a href="$url">Here</a>.</p>
	</body>
</html>
EOF;

			// send the email
			error_reporting(E_ALL & ~E_STRICT & ~E_DEPRECATED);
			$mailer =& Mail::factory("sendmail");
			$status = $mailer->send($to, $headers, $message);
			if(PEAR::isError($status) === true) {
				$_SESSION['notification'] = "<strong>Oh snap!</strong> Unable to send mail message:" . $status->getMessage();
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			} else {
				$_SESSION['notification'] = "<strong>Email sent!</strong> Please check your email to complete the change.";
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			}
		} catch(Exception $exception) {
			$_SESSION['notification'] = "<strong>Oh snap!</strong> Unable to help you: " . $exception->getMessage();
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
	}
	else {
		$_SESSION['notification'] = "Your password is incorrect";
		header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>