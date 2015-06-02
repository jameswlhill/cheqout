<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once(dirname(__DIR__)) . "/php/class/account.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");

// check that both the username and password have been submitted
if(!isset($_POST['email'], $_POST['password'])) {
	throw(new RuntimeException("Please enter a valid username and password."));
}
// check the username is the correct length
if(strlen($_POST['email']) > 128 || strlen($_POST['email']) < 5) {
	throw(new RuntimeException("Incorrect Length for Email"));
}
// check the password is the correct length
if(strlen($_POST['password']) > 128 || strlen($_POST['password']) < 4) {
	throw(new RuntimeException("Incorrect Length for Password"));
} else {
		//sanitize the email to ensure no unwanted characters
		$vEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		//get the login data via sanitized email
		$loginData = Email::getLoginDataByEmailAddress($pdo, $vEmail);
		//hash the input password
		$vPassword = hash_pbkdf2("sha512", $_POST["password"], $loginData[2], 2048, 128);
		//match the hashed password in db to input hashed password

		if($vPassword === $loginData[1]) {
			$_SESSION["email"] = Email::getEmailByEmailId($pdo, $loginData[3]);
			$_SESSION["account"] = Account::getAccountByEmailId($pdo, $loginData[3]);
			echo '<p class="label label-success col-md-12"> Login Successful!</p>';
		} else {
			echo '<p class="label label-danger col-md-12"> Login Unsuccessful!</p>';
		}
}
?>

