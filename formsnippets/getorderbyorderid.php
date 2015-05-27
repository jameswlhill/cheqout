<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/cheqoutorder.php";
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once(dirname(__DIR__)) . "/php/class/account.php";
require_once(dirname(__DIR__)) . "/php/class/product.php";
require_once(dirname(__DIR__)) . "/php/class/productorder.php";
require_once(dirname(__DIR__)) . "/php/class/address.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");



try {
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
	$orderId = $_POST["orderid"];
	$orderObject = CheqoutOrder::getOrderByOrderId($pdo, $orderId);
	$email = Email::getEmailByEmailId($pdo, 1);
	$account = Account::getAccountByEmailId($pdo, 1);

	if(@isset($_POST["orderid"]) 	=== false) {
		throw(new InvalidArgumentException("Please fill in your orderObject ID."));
	}
	if($email->getEmailId() !== $orderObject->getEmailId()) {
		throw(new InvalidArgumentException("You can only get orders associated with YOUR E-Mail."));
	}

	$formattedDate = $orderObject->getOrderDateTime()->format("Y-m-d H:i:s");
	$order = array($orderObject->getOrderId(), $email->getEmailAddress(), $orderObject->getBillingAddressId(),
						$orderObject->getShippingAddressId(), $orderObject->getStripeId(), $formattedDate);
	echo '<table><tr><th>Order Id</th>
						  <th>Email Address</th>
						  <th>Billing Address Id</th>
						  <th>Shipping Address Id</th>
						  <th>Stripe Id</th>
						  <th>Order Date</th></tr>';
	foreach($order as $list) {
	echo '<td>' . $list  . '</td>';
	}
	echo '</table>';

}catch(Exception $exception) {
	echo "<p class=\"alert alert-danger\">Exception: " . $exception->getMessage() . "</p>";
}
?>