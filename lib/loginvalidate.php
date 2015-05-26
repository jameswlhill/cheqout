<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once(dirname(__DIR__)) . "/php/class/account.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
//connect to db and get the email/password
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
$email = Email::getEmailIdByEmailAddress($pdo, 1);
$_SESSION["email"] = $email;
$account = Account::getAccountByEmailId($pdo, 1);
$password = $account->getAccountPassword();
/**set valid characters allowed in email **/
$eValid = array("@", ".", "-", "_", "+");

/*** check that both the username, password have been submitted ***/
if(!isset( $_POST['emailAddress'], $_POST['password']))
{
	$message = 'Please enter a valid username and password';
}

/*** check the username is the correct length ***/
if(strlen( $_POST['emailAddress']) > 128 || strlen($_POST['emailAddress']) < 5)
{
	$message = 'Incorrect Length for Email';
}
/*** check the password is the correct length ***/
if(strlen( $_POST['password']) > 128 || strlen($_POST['password']) < 4)
{
	$message = 'Incorrect Length for Password';
}
/*** check the username has only alpha numeric characters ***/
if(!ctype_alnum(str_replace($eValid, '', $email)))
{
	$message = "Email contains disallowed characters.";
}

else {
	/*** if we are here the data is valid and we can use it with database ***/
	$vEmail = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
	$vPassword = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

	/**hash the password**/

	$vPassword = hash_pbkdf2("sha512", $_POST['password'], $salt, 128, 2048);
	if(@isset($_POST['emailAddress'], $_POST['password'])) {

		$statement = $pdo->prepare("SELECT * FROM email, account WHERE emailAddress = $vEmail & accountPassword = $vPassword");
	}
	if($vEmail === $_POST['email'] & $vPassword === $account->getAccountPassword()) {

	}
}



