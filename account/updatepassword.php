<?php
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
	$password = hash_pbkdf2("sha512", $loginData[1], $loginData[2], 2048, 128);
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
		($password === $newPassword) ||
		($newPassword !== $checkNewPassword)) {
		throw(new InvalidArgumentException('Password fields must match, and must not be the same as your last password.'));
	}
	$account->setAccountPassword($newPassword);
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
	$account->update($pdo);
	echo "<p class=\"alert alert-success\">Password for " . $email->getEmailAddress() . ") changed!</p>";
}	catch(Exception $exception) {
	echo "<p class=\"alert alert-danger\">Exception: " . $exception->getMessage() . "</p>";
}
?>