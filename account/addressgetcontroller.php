<?php
require_once (dirname(__DIR__)) . "/php/class/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
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
	foreach($orderArray as $list) {
	echo '<div class="col-md-4 col-sm-12 col-lg-3">';
		foreach($list as $listItem) {
			echo '<p>' . $listItem  . '</p>';
		}
	echo '</div>';
	}

}catch(Exception $exception) {
	echo "<p class=\"alert alert-danger\">Exception: " . $exception->getMessage() . "</p>";
}
?>