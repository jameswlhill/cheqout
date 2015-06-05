<?php
require_once("../lib/utilities.php");
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// go into the database and grab their email object
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
if(@isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
}
if(@isset($_SESSION["account"])) {
	$account = $_SESSION["account"];
}
//grab the salt to hash new password and old password to check there's an actual change
if(isset($_POST['newpassword'])) {
	$emailAddress = $email->getEmailAddress();
	$loginData = Email::getLoginDataByEmailAddress($pdo, $emailAddress);
	$password = $loginData[1];
}
// get their new password POST and hash it to check against the old password (so it can't be used again)
$newPassword = hash_pbkdf2("sha512", $_POST["newpassword"], $loginData[2], 2048, 128);
$checkNewPassword = hash_pbkdf2("sha512", $_POST["passwordcheck"], $loginData[2], 2048, 128);

try {
	if($newPassword !== $checkNewPassword) {
		throw(new InvalidArgumentException('Your passwords do not match.'));
	}
	if(@isset($_POST["newpassword"]) === false ||
		(@isset($_POST["passwordcheck"]) === false) ||
		($password === $newPassword)) {
		throw(new InvalidArgumentException('Password fields must match, and must not be the same as your last password.'));
	}
	$testActivation = Account::getAccountByEmailId($pdo, $email->getEmailId());
	$testActivation = $testActivation->getActivation();
	if($testActivation === null) {
		throw(new InvalidArgumentException("You do not have a password change pending"));
	}
	if($testActivation !== $_POST["passwordchange"]) {
		throw(new InvalidArgumentException("Activation does not match, check that you are logged in, then try again."));
	}

	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
	$account->setAccountPassword($newPassword);
	$account->update($pdo);
	$account->setActivation(null);
	$account->update($pdo);
	$_SESSION["notification"] = "Password for " . $email->getEmailAddress() . ") changed!";
}	catch(Exception $exception) {
	$_SESSION["notification"] =  "Exception: " . $exception->getMessage();
}
header('Location: ../account/index.php');
?>