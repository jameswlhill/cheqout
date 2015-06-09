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

echo '
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Billing Address</h3>
		</div>
		<div class="panel-body">';
if(@isset($billing) === true) {
	echo $billing->getAddressLabel();
	echo $billing->getAddressAttention();
	echo $billing->getAddressStreet1();
	echo $billing->getAddressStreet2();
	echo $billing->getAddressCity();
	echo $billing->getAddressState();
	echo $billing->getAddressZip();
} else {
//	var_dump($_SESSION["billing"]);
	echo 'Billing Address is not yet set.';
}

echo '
		</div>
	</div>';