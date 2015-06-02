<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once(dirname(__DIR__)) . "/php/class/account.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");

// check that both the username and password have been submitted
if(!isset($_POST['email'], $_POST['password'])) {
	$message = 'Please enter a valid username and password';
}
// check the username is the correct length
if(strlen($_POST['email']) > 256 || strlen($_POST['email']) < 5) {
	$message = 'Incorrect Length for Email';
}
// check the password is the correct length
if(strlen($_POST['password']) > 128 || strlen($_POST['password']) < 4) {
	$message = 'Incorrect Length for Password';
}

else {
		//sanitize the email to ensure no unwanted characters
		$vEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		//get the login data via sanitized email
		$loginData = Email::getLoginDataByEmailAddress($pdo, $vEmail);
		//hash the input password
		$vPassword = hash_pbkdf2("sha512", $_POST['password'], $loginData[2], 128, 2048);
		//match the hashed password in db to input hashed password
	var_dump($loginData);
		if($vPassword === $loginData[1]) {
			$_SESSION["email"] = Email::getEmailIdByEmailAddress($pdo, $vEmail);
			var_dump($_SESSION["email"]);
			$_SESSION["account"] = Account::getAccountByEmailId($pdo, $_SESSION["email"]->getEmailId);
			var_dump($_SESSION["account"]);
			header('Location:../account/index.php');
			echo "Login Successful!";
		}
}
?>

