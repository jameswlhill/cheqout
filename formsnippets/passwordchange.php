<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once(dirname(__DIR__)) . "/php/class/account.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");


//   ******** FOR TESTING ONLY 1844 EMAIL ID **************
$oldSalt = bin2hex(openssl_random_pseudo_bytes(32));
$actCode = bin2hex(openssl_random_pseudo_bytes(16));
$createTime = new DateTime();
// use 2048 for interations for login!
$oldPassword = hash_pbkdf2("sha512", "shjkdfgh", $oldSalt, 2048, 128);
$email = new Email(1844, "emailaddy@email.email", "stripeidiswhat");
$_SESSION["email"] = $email;
$account = new Account(1844, $oldPassword, $oldSalt, $actCode, $createTime, 1844);
$_SESSION["account"] = $account;
// end test area


try {
	if(@isset($_POST["new-password"]) 	=== false	||
		(@isset($_POST["passwordcheck"]) === false)) {
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