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
		(@isset($_POST["addressId"]) === false)  ||
		(@isset($_POST["street1"]) 	=== false) ||
		(@isset($_POST["city"]) 		=== false) ||
		(@isset($_POST["state"]) 		=== false) ||
		(@isset($_POST["zip"]) 			=== false)) {
		throw(new InvalidArgumentException("Please fill in all required fields."));
	}

	if(@isset($_POST["addressupdate"]) === true) {
		$address = Address::getAddressByAddressId($pdo, $_POST["addressId"]);
		// just made an object of the posted values -- we make the object
		// so that the userDelete function can identify it and "delete" it
		$address->userDelete($pdo);
		// we're making a NEW address because all we did was destroy
		// the one that was just posted
		$address = new Address(null, $email->getEmailId(),
			$_POST["attention"],
			$_POST["street1"],
			$_POST["city"],
			$_POST["state"],
			$_POST["zip"],
			$_POST["street2"],
			$_POST["label"]);
		$address->insert($pdo);
	}

	if(@isset($_POST["addressdelete"]) === true) {
		$address = Address::getAddressByAddressId($pdo, $_POST["addressId"]);
		$address->userDelete($pdo);
	}

	$_SESSION["notification"] = 'Address for <span class="text-info">' . $email->getEmailAddress() . '</span> changed/deleted.';
} catch(Exception $exception) {
	echo 'Exception: ' . $exception->getMessage();
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>