<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once(dirname(__DIR__)) . "/php/class/account.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
// go into the database and grab their email object
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
$_SESSION["email"] = Email::getEmailByEmailId($pdo, 1);
// get their account by their email id
$account = Account::getAccountByEmailId($pdo, $_SESSION["email"]->getEmailId);
$oldsalt = $account->getAccountPasswordSalt();
// get their old password salt and value to check it against their old password
$checkOldPassword = hash_pbkdf2("sha512", $_POST["old-password"], $oldsalt, 2048, 128);
// get their new password POST and hash it to check against the old password (so it can't be used again)
$checkNewPassword = hash_pbkdf2("sha512", $_POST["new-password"], $oldsalt, 2048, 128);

try {
	if($account->getAccountPassword() !== $checkOldPassword) {
		throw(new InvalidArgumentException('You must enter your old password to change it.'));
	}
	if(@isset($_POST["new-password"]) 	=== false	||
		(@isset($_POST["passwordcheck"]) === false) ||
		$account->getAccountPassword() === $checkNewPassword ||
		$account->getAccountPassword() !== $checkOldPassword)
	{
		throw(new InvalidArgumentException('Password fields must match, and must not be the same as your last password.'));
	}
	$newSalt = bin2hex(openssl_random_pseudo_bytes(32));
	// use 2048 for interations for login!
	$newPassword = hash_pbkdf2("sha512", $_POST["new-password"], $newSalt, 2048, 128);
	$account = new Account(1844, $newPassword, $newSalt, $actCode, $createTime, 1844);
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
	$account->update($pdo);
	echo "<p class=\"alert alert-success\">Password for (id = " . $account->getAccountId() . ") changed!</p>";
}	catch(Exception $exception) {
	echo "<p class=\"alert alert-danger\">Exception: " . $exception->getMessage() . "</p>";
}
?>