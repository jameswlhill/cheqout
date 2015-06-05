<?php
require_once (dirname(__DIR__)) . "/php/class/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once ("addressformgenerator.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
if(@isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
}
if(@isset($_SESSION["account"])) {
	$account = $_SESSION["account"];
}
try {
	if(@isset($email)	=== false && (@isset($account)) === false) {
		throw(new InvalidArgumentException("You aren't logged in!"));
	}
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
	// fill in an array with the order based on the order's ID only
	$orderArray = Address::getAddressesByEmailId($pdo, $email->getEmailId());
	if(is_array($orderArray[0]) === true) {
		$i = 0;
		echo '<div class="container-fluid">';
		echo '<div class="row">';
		foreach($orderArray as $list) {
			if(intval($list[9]) !== 1 && (is_array($list)) === true) {
				if($i % 3 == 0) {
					echo '</div><div class="row">';
				}
				addressFormGenerator($list[0], $list[8], $list[2], $list[3], $list[7], $list[4], $list[5], $list[6]);
				$i++;
			}
		}
		echo '</div>';
	}
} catch(Exception $exception) {
	$_SESSION["notification"] = 'Exception: ' . $exception->getMessage();
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>