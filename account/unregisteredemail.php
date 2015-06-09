<?php
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// go into the database and grab their email object
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");

try {
	if(@isset($_POST["unregisteredEmail"]) === true) {
		$_SESSION["emailAddress"] = filter_var($_POST["unregisteredEmail"], FILTER_SANITIZE_STRING);
	}


$_SESSION["notification"] = "Email set to " . $_SESSION["emailAddress"] . ".";

	header('Location: ' . $_SERVER['HTTP_REFERER']);
} catch(Exception $exception) {
echo "Error: " . $exception->getMessage() . ".";
}
?>