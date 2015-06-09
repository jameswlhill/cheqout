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
echo '
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Shipping Address</h3>
		</div>
		<div class="panel-body">';
if(@isset($shipping) === true) {
	echo $shipping->getAddressLabel();
	echo $shipping->getAddressAttention();
	echo $shipping->getAddressStreet1();
	echo $shipping->getAddressStreet2();
	echo $shipping->getAddressCity();
	echo $shipping->getAddressState();
	echo $shipping->getAddressZip();
} else {
//	var_dump($_SESSION["shipping"]);
	echo 'Shipping Address is not yet set.';
}
echo '
		</div>
	</div>';