<?php
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once("Mail.php");
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
	if(@isset($_POST["newemail"]) === false  ||
		(@isset($_POST["emailcheck"]) === false) ||
		$_POST["newemail"] !== $_POST["emailcheck"]) {
		throw(new InvalidArgumentException("Please fill in all required fields."));
	}
	$email = new Email($_SESSION["email"]->getEmailId(),$_POST["emailcheck"] ,$_SESSION["email"]->getStripeId());
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
	$email->update($pdo);
	echo "<p class=\"alert alert-success\">E-Mail (id = " . $email->getEmailId() . ") posted!</p>";
}	catch(Exception $exception) {
	echo "<p class=\"alert alert-danger\">Exception: " . $exception->getMessage() . "</p>";
}


?>

<form class="form-inline">

</form>