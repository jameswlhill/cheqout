<?php
session_start();
require_once (dirname(__DIR__)) . "/php/class/email.php";
require_once (dirname(__DIR__)) . "/php/class/account.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
// go into the database and grab their email object
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
//////// FOR TESTING YOUR VARIABLES ARE...
//$_SESSION["emailAddress"]
//$_SESSION["emailId"]
//$_SESSION["password"] (its a hash)
//$_SESSION["salt"]
//$_SESSION["activation"]
//$_SESSION["account"] (its an OBJECT)
//////// END TESTING

$oldSalt = $_SESSION["salt"];
// get their old password salt and value to check it against their old password
$checkOldPassword = hash_pbkdf2("sha512", $_POST["oldpassword"], $oldSalt, 2048, 128);
// get their new password POST and hash it to check against the old password (so it can't be used again)
$checkNewPassword = hash_pbkdf2("sha512", $_POST["newpassword"], $oldSalt, 2048, 128);
$account = $_SESSION["account"];

try {
	if($account->getAccountPassword() !== $checkOldPassword) {
		throw(new InvalidArgumentException('Your current password is incorrect.'));
	}
	if(@isset($_POST["newpassword"]) 	=== false	||
		(@isset($_POST["passwordcheck"]) === false) ||
		$account->getAccountPassword() === $checkNewPassword ||
		$account->getAccountPassword() !== $checkOldPassword)
	{
		throw(new InvalidArgumentException('Password fields must match, and must not be the same as your last password.'));
	}
	if($_GET["activation"] !== $account->getAccountActivation()) {
		throw(new InvalidArgumentException('Activation codes do not match. Please try again.'));
	}
	$newSalt = bin2hex(openssl_random_pseudo_bytes(32));
	// use 2048 for interations for login!
	$newPassword = hash_pbkdf2("sha512", $_POST["newpassword"], $newSalt, 2048, 128);
	$account = new Account($account->getAccountId, $newPassword, $newSalt, $_GET["activation"], null, $_SESSION["emailId"]);
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
	$account->update($pdo);
	echo "<p class=\"alert alert-success\">Password for (id = " . $account->getAccountId() . ") changed!</p>";
}	catch(Exception $exception) {
	echo "<p class=\"alert alert-danger\">Exception: " . $exception->getMessage() . "</p>";
}
?>