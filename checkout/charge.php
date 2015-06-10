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
	$_SESSION["emailAddress"] = $email->getEmailAddress();
}
if(@isset($_SESSION["account"])) {
	$account = $_SESSION["account"];
}
require_once("../stripe-php-2.2.0/init.php");
$config = readConfig("/etc/apache2/capstone-mysql/cheqout.ini");
require_once("../lib/utilities.php");

$token = $_POST['stripeToken'];

//rtfm
\Stripe\Stripe::setApiKey($config['secret_key']);

$customer = \Stripe\Customer::create(array(
	'email' => $_SESSION["emailAddress"],
	'card'  => $token
));


$charge = \Stripe\Charge::create(array(
	'customer' => $customer->id,
	'amount'   => $_SESSION["total"],
	'currency' => 'usd'
));

if($charge->paid === true) {
	$emailId = $_SESSION["email"]->getEmailId();
	$shippingId = $_SESSION["shipping"]->getAddressId();
	$billingId = $_SESSION["billing"]->getAddressId();
	$datetime = new DateTime('NOW');
	$cheqoutOrder = new CheqoutOrder(null, $emailId, $billingId, $shippingId, "stripeid", $datetime);
	$cheqoutOrder->insert($pdo);
	$orderId = $cheqoutOrder->getOrderId();
	$shippingCost = ($_SESSION["shippingcost"]/100);
	$orderTotal = ($_SESSION["ordercost"]/100);
	$cart = $_SESSION['cart'];
	foreach($cart as $productId => $quantity) {
		$productOrder = new ProductOrder($orderId, $productId, $quantity, $shippingCost, $orderTotal);
		$productOrder->insert($pdo);
	}
	header( 'Location: ../lib/ordercomplete.php');
	unset($_SESSION['cart']);
} else {
	header( 'Location: ../lib/orderfailed.php');
}
?>