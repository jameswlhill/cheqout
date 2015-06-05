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
try {
		if(@isset($_POST["newemail"]) === false ||
			(@isset($_POST["emailcheck"]) === false) ||
			$_POST["newemail"] !== $_POST["emailcheck"]) {
			throw(new InvalidArgumentException("Please fill in all required fields and make sure they match."));
		}
	$testActivation = Account::getAccountByEmailId($pdo, $email->getEmailId());
	$testActivation = $testActivation->getActivation();
	if($testActivation === null) {
		throw(new InvalidArgumentException("You do not have an email change pending"));
		}
		if($testActivation !== ($_POST["emailchange"])) {
			throw(new InvalidArgumentException("Activation does not match, check that you are logged in, then try again."));
		}
$email->setEmailAddress($_POST["emailcheck"]);
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
$email->update($pdo);
$account->setActivation(null);
$account->update($pdo);
$_SESSION["notification"] = "Email changed to " . $email->getEmailAddress() . ".";
} catch(Exception $exception) {
$_SESSION['notification'] = "Exception: " . $exception->getMessage() . ".";
}
header('Location: ../account/index.php');
?>