<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once(dirname(__DIR__)) . "/php/class/account.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");

try {
	// verify the form was submitted OK
	if (@isset($_POST["email"]) === false || @isset($_POST["password"]) === false || @isset($_POST["passwordcheck"]) === false) {
		throw(new RuntimeException("form variables incomplete or missing"));
	}

	// verify the passwords match
	if($_POST["password"] !== $_POST["passwordcheck"]) {
		throw(new RuntimeException("Please ensure both passwords are typed correctly and identically."));
	}
	
	//validate email before using with db to protect against injections
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	if($_POST['email'] !== $email) {
		throw(new InvalidArgumentException("E-Mail must be formatted as an email, with no special characters."));
	}
	
	//check to see if the email already exists
	$result = Email::getEmailIdByEmailAddress($pdo, $email);
	if($result !== null) {
		$account = Account::getAccountByEmailId($pdo, $result);
		if($account !== null) {
			throw(new InvalidArgumentException("This email has already been registered on this site. Please try again."));
		}
	}

	$insertEmail = new Email(null, $email, "thisismystripe");
	$insertEmail->insert($pdo);
	$emailId = Email::getEmailIdByEmailAddress($pdo, $email);
	$emailId = $emailId->getEmailId();
	// create a salt for the account
	$salt = bin2hex(openssl_random_pseudo_bytes(32));
	// create a hash for the password
	$hash = hash_pbkdf2("sha512", $_POST["password"], $salt, 2048, 128);
	// create an activation code for the account
	$activation = bin2hex(openssl_random_pseudo_bytes(16));
	// finally, make the object
	// $newAccountId, $newAccountPassword, $newAccountPasswordSalt, $newActivation, $newAccountCreateDateTime, $newEmailId
	$newAccount = new Account(null, $hash, $salt, $activation, null, $emailId);
	// and insert it
	$newAccount->insert($pdo);

	echo 'Account successfully created, welcome to the Cheqout family!';
} catch(Exception $exception) {
	echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong> Unable to sign up: " . $exception->getMessage() . "</div>";
}
?>

