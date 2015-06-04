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
			$serverself = explode("/", $_SERVER["PHP_SELF"]);
			$pageName = end($serverself);
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
				echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong> Unable to send mail message:" . $status->getMessage() . "</div>";
			} else {
				echo "<div class=\"alert alert-success\" role=\"alert\"><strong>Email Sent!</strong> Please check your Email to complete the change process.</div>";
			}

		} catch(Exception $exception) {
			echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong> Unable to change email: " . $exception->getMessage() . "</div>";
		}
	}
	else {
		echo '<p>Your password is incorrect</p>';
}
?>