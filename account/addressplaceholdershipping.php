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
if(@isset($_SESSION["shipping"])) {
	$shipping = $_SESSION["shipping"];
}

if(@isset($shipping) === true) {
	echo $shipping->getAddressLabel();
	echo $shipping->getAddressAttention();
	echo $shipping->getAddressStreet1();
	echo $shipping->getAddressStreet2();
	echo $shipping->getAddressCity();
	echo $shipping->getAddressState();
	echo $shipping->getAddressZip();
} else {
	echo 'Shipping Address is not yet set.';
}