<?php
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once(dirname(__DIR__) . "/lib/csrfver.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
if(@isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
}
if(@isset($_SESSION["account"])) {
	$account = $_SESSION["account"];
}


$PAGE_TITLE = "Cart - Cheqout";
require_once("../lib/utilities.php");

echo '<div class="container text-center">
	<h1>Thank you!</h1>
	<h4>Your order has been processed.</h4>
	<h3>Your monies have been CHARGED <span class="text-success">$' . $_SESSION["total"] . '</span>.</h3>
	<h5>...and some trees might have died.</h5>
	<h2>EMAIL SENT TO ' . $_SESSION["emailAddress"] . '</h2>
</div>';