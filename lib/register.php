<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once(dirname(__DIR__)) . "/php/class/account.php";
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");

if($_POST['password'] !== $_POST['password2']){
	throw(new InvalidArgumentException("Passwords do not match"));
}
    if(isset($_POST['email'], $_POST['password'], $_POST['password2'])){
		 $email = new Email(null, $_POST['email'], null);
		 $email->insert($pdo);

		 //hash the input password and generate salt
		 $newSalt = bin2hex(openssl_random_pseudo_bytes(32));
		 $newPassword = hash_pbkdf2("sha512", $_POST['password'], $newSalt, 128, 2048);

		 $account = new Account(null, $newPassword, $newSalt, null, null, $this->getEmailIdByEmailAddress($_POST['email']));
		 $account->insert($pdo);

		 if($pdo->execute() ){
			 header("Location: ../account/index.php");
		 } else{
			 echo 'Unable to create account';
		 }
	 }
?>
