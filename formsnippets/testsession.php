<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once(dirname(__DIR__)) . "/php/class/account.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");

$_SESSION["emailAddress"] = Email::getEmailByEmailId($pdo, 1);
$_SESSION["emailId"] = 1;
$password = "oldman";
$salt = bin2hex(openssl_random_pseudo_bytes(32));
// create a hash for the password
$hash = hash_pbkdf2("sha512", $password, $salt, 2048, 128);
// create an activation code for the account
$activation = bin2hex(openssl_random_pseudo_bytes(16));
// finally, make the object
$_SESSION["password"] = $hash;
$_SESSION["salt"] = $salt;
$_SESSION["activation"] = $activation;

echo "Temporary session created!<br />";
echo 'Email: ' . $_SESSION["emailAddress"] . '<br />';
echo "Password: $password<br />";