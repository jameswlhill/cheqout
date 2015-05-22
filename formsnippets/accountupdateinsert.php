<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/account.php";
require_once(dirname(__DIR__)) . "/php/class/address.php";
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

//   ******** FOR TESTING ONLY ACCOUNT/ADDRESS/EMAIL ENTRIES **************
//    IN REAL LIFE I WANT TO MAKE SURE IT PULLS FROM THE DATABASE
$emailId = $_POST["emailid"];
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
$_SESSION["email"] = Email::getEmailByEmailId($pdo, $emailId);
$account = Account::getAccountByEmailId($pdo, $emailId);


try {
	if($account->getActivation() !== $_POST["activation-code"]) {
		throw(new InvalidArgumentException('Please enter the activation code as it was sent in the email.'));
	}
	if($_POST["new-email"] !== $_POST["email"]) {
		throw(new InvalidArgumentException('Please ensure both E-Mail entries match each other.'));
	}
	 if(@isset($_POST["activation-code"]) 	=== false  ||
		 @isset($_POST["new-email"]) 	=== false  ||
		(@isset($_POST["email"]) 	=== false)) {
		throw(new InvalidArgumentException("Please fill out all E-Mail fields."));
	}
	$email = $_SESSION["currentemail"];
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
	$address->insert($pdo);
	echo "<p class=\"alert alert-success\">Address (id = " . $address->getAddressId() . ") posted!</p>";
}catch(Exception $exception) {
	echo "<p class=\"alert alert-danger\">Exception: " . $exception->getMessage() . "</p>";
}
?>