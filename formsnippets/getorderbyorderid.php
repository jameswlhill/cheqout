<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/cheqoutorder.php";
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

//   ******** FOR TESTING ONLY 1844 EMAIL ID **************
$_SESSION["emailId"] = 1844;

try {
	if(@isset($_POST["attention"]) 	=== false  ||
		(@isset($_POST["street1"]) 	=== false) ||
		(@isset($_POST["city"]) 		=== false) ||
		(@isset($_POST["state"]) 		=== false) ||
		(@isset($_POST["zip"]) 			=== false)) {
		throw(new InvalidArgumentException("Please fill in all required fields."));
	}
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
	$address = new Address(null, $_SESSION["emailId"], $_POST["attention"], $_POST["street1"],
		$_POST["city"], $_POST["state"], $_POST["zip"], $_POST["street2"],
		$_POST["label"]);
	$address->insert($pdo);
	echo "<p class=\"alert alert-success\">Address (id = " . $address->getAddressId() . ") posted!</p>";
}catch(Exception $exception) {
	echo "<p class=\"alert alert-danger\">Exception: " . $exception->getMessage() . "</p>";
}
?>