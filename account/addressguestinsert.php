<?php
require_once (dirname(__DIR__)) . "/php/class/autoload.php";
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
if(@isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
}
if(@isset($_SESSION["account"])) {
	$account = $_SESSION["account"];
}

try {
	 if(@isset($_POST["attention"]) 	=== false  ||
		(@isset($_POST["street1"]) 	=== false) ||
		(@isset($_POST["city"]) 		=== false) ||
		(@isset($_POST["state"]) 		=== false) ||
		(@isset($_POST["zip"]) 			=== false)) {
		throw(new InvalidArgumentException("Please fill in all required fields."));
	}

	if(@isset($_SESSION["emailAddress"]) === true) {
		$email = new Email(null, $_SESSION["emailAddress"], "stripeid");
		$email->insert($pdo);
		$address = new Address(null, $email->getEmailId(),
			$_POST["attention"],
			$_POST["street1"],
			$_POST["city"],
			$_POST["state"],
			$_POST["zip"],
			$_POST["street2"],
			$_POST["label"]);
	} else {
		$_SESSION["notification"] = "Please set your email address so we can send you a receipt =)";
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		return;
	}


	if(@isset($_POST['guestshipping']) === true) {
		$_SESSION["shipping"] = $address;
	}

	if(@isset($_POST['guestbilling']) === true) {
		$_SESSION["billing"] = $address;
	}

	$address->insert($pdo);

} catch(Exception $exception) {
	echo 'Exception: ' . $exception->getMessage();
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>