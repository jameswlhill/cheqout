<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once(dirname(__DIR__)) . "/php/class/account.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
//connect to db
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
$_SESSION["email"] = $email;

/**set valid characters allowed in email **/
$eValid = array("@", ".", "-", "_", "+");

/*** check that both the username, password have been submitted ***/
if(!isset( $_POST['emailAddress'], $_POST['password']))
{
	$message = 'Please enter a valid username and password';
}

/*** check the username is the correct length ***/
if(strlen( $_POST['emailAddress']) > 256 || strlen($_POST['emailAddress']) < 5)
{
	$message = 'Incorrect Length for Email';
}
/*** check the password is the correct length ***/
if(strlen( $_POST['password']) > 128 || strlen($_POST['password']) < 4)
{
	$message = 'Incorrect Length for Password';
}
/*** check the username has only alpha numeric characters ***/
if(!ctype_alnum(str_ireplace($eValid, '', $email))) {
	$message = "Email contains disallowed characters.";
}

else {
	/*** if we are here the data is valid and we can use it with database ***/
	$vEmail = filter_var($_POST['email'], FILTER_SANITIZE_STRING);

	Email::getLoginDataByEmailAddress($pdo, $vEmail);


	/**hash the password**/
	$vPassword = hash_pbkdf2("sha512", $_POST['password'], $salt, 128, 2048);


}



