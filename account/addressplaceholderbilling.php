<?php
require_once (dirname(__DIR__)) . "/php/class/autoload.php";
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
if(@isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
}
if(@isset($_SESSION["account"])) {
	$account = $_SESSION["account"];
}
if(@isset($_SESSION["billing"])) {
	$billing = $_SESSION["billing"];

}

if(@isset($billing) === true) {
	echo $billing->getAddressLabel();
	echo $billing->getAddressAttention();
	echo $billing->getAddressStreet1();
	echo $billing->getAddressStreet2();
	echo $billing->getAddressCity();
	echo $billing->getAddressState();
	echo $billing->getAddressZip();
} else {
	echo 'Billing Address is not yet set.';
}
