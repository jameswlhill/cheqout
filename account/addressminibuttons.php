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
	 if(@isset($_POST["addressId"]) === false) {
		 throw(new InvalidArgumentException("Your Address ID was not recognized."));
	 }

	if(@isset($_POST["addressbilling"]) === true) {
		$address = Address::getAddressByAddressId($pdo, $_POST["addressId"]);
		$_SESSION["billing"] = $address;
	}

	if(@isset($_POST["addressshipping"]) === true) {
		$address = Address::getAddressByAddressId($pdo, $_POST["addressId"]);
		// just made an object of the posted values -- we make the object
		// so that the userDelete function can identify it and "delete" it
		// we're making a NEW address because all we did was destroy
		// the one that was just posted
		$_SESSION["shipping"] = $address;
	}

	//now refresh the page so it shows up
	header('Location: ' . $_SERVER['HTTP_REFERER']);
} catch(Exception $exception) {
	echo 'Exception: ' . $exception->getMessage();
}

?>