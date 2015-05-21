<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

//   ******** FOR TESTING ONLY 1844 EMAIL ID **************
$_SESSION["email"] = new Email(1844, "emailaddy@email.email", "stripeidiswhat");

try {
	if(@isset($_POST["new-email"]) 	=== false  ||
		(@isset($_POST["emailcheck"]) === false) ||
		$_POST["new-email"] !== $_POST["emailcheck"]) {
		throw(new InvalidArgumentException("Please fill in all required fields."));
	}
	$email = new Email($_SESSION["email"]->getEmailId(),$_POST["emailcheck"] ,$_SESSION["email"]->getStripeId());
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
	$email->update($pdo);
	echo "<p class=\"alert alert-success\">E-Mail (id = " . $email->getEmailId() . ") posted!</p>";
}	catch(Exception $exception) {
	echo "<p class=\"alert alert-danger\">Exception: " . $exception->getMessage() . "</p>";
}
?>