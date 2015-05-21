<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/account.php";
require_once(dirname(__DIR__)) . "/php/class/address.php";
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

//   ******** FOR TESTING ONLY ACCOUNT/ADDRESS/EMAIL ENTRIES **************
//    IN REAL LIFE I WANT TO MAKE SURE IT PULLS FROM THE DATABASE
if(@isset($_SESSION["currentemail"]) !== true) {
	$email = new Email(null, "emailadddyhere@wsup.com", "stripeidgoeshere");
	$_SESSION["currentemail"] = $email;
}

if(@isset($_SESSION["currentaddress"]) !== true) {
	$address = new Address(null, "addressaddy", "123 first street", "lost begaz", "New Vada", "State Variable", "45879");
	$_SESSION["currentaddress"] = $address;
}

try {
	 if(@isset($_POST["new-email"]) 	=== false  ||
		(@isset($_POST["email"]) 	=== false) ||
		$_POST["new-email"] !== $_POST["email"]) {
		throw(new InvalidArgumentException("Please ensure the new and old e-mails do not match."));
	}
	$email = $_SESSION["currentemail"];
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
	$address->insert($pdo);
	echo "<p class=\"alert alert-success\">Address (id = " . $address->getAddressId() . ") posted!</p>";
}catch(Exception $exception) {
	echo "<p class=\"alert alert-danger\">Exception: " . $exception->getMessage() . "</p>";
}
?>