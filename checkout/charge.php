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
$config = readConfig("/etc/apache2/capstone-mysql/cheqout.ini");
require_once("../lib/utilities.php");

$token = $_POST['stripeToken'];

echo "token";
echo json_encode($token, JSON_PRETTY_PRINT);

//rtfm
\Stripe\Stripe::setApiKey($config['secret_key']);

$customer = \Stripe\Customer::create(array(
	'email' => $emailAddress,
	'card'  => $token
));


$charge = \Stripe\Charge::create(array(
	'customer' => $customer->id,
	'amount'   => 5000,
	'currency' => 'usd'
));

if($charge->paid === true) {
	echo 'AWL PAID UP!';
} else {
	echo 'NOT PAID AT ALL!';
}

echo '<h1>Successfully charged $50.00!</h1>';
?>