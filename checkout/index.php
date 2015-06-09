<?php
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
$PAGE_TITLE = "My Account - Cheqout";
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
if(@isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
	$emailAddress = $email->getEmailAddress();
}
if(@isset($_SESSION["account"])) {
	$account = $_SESSION["account"];
}
require_once("../stripe-php-2.2.0/init.php");
require_once("../lib/utilities.php");
$config = readConfig("/etc/apache2/capstone-mysql/cheqout.ini");

$testKey = $config['publishable_key'];
$logo = '../img/logo.png'; // taken from first product on the order
$tagline = 'Cheq out our booqs!'; //taken from the first product's description
$orderTotal = $_SESSION["total"] * 100; // taken from the order total in productOrder


echo '<form action="../checkout/charge.php" method="POST">
			<script
				src="https://checkout.stripe.com/checkout.js" class="stripe-button"
				data-key="' . $testKey . '"
				data-email="' . $_SESSION['emailAddress'] . '"
				data-image="' . $logo . '"
				data-name="Cheqout"
				data-description="' . $tagline . '"
				data-zip-code="true"
				data-amount="' . $orderTotal . '">
			</script>
		</form>';


