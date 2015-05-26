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
	$email = Email::getEmailByEmailId($pdo, 1);
	$account = Account::getAccountByEmailId($pdo, 1);
	$orderId = $_POST["orderid"];
	$orderObject = CheqoutOrder::getOrderByOrderId($pdo, $orderId);
	var_dump($orderObject);

	if(@isset($_POST["orderid"]) 	=== false) {
		throw(new InvalidArgumentException("Please fill in your orderObject ID."));
	}
	if($email->getEmailId() !== $orderObject->getEmailId()) {
		throw(new InvalidArgumentException("You can only get orders associated with YOUR E-Mail."));
	}
	echo "Valid Request.";

	$order = array($orderObject->getOrderId, $orderObject->getEmailId, $orderObject->getBillingAddressId,
						$orderObject->getShippingAddressId, $orderObject->getStripeId, $orderObject->getOrderDateTime);
	foreach($order as $list) {
	echo $list;
	}
	echo "End of For Each.";

}catch(Exception $exception) {
	echo "<p class=\"alert alert-danger\">Exception: " . $exception->getMessage() . "</p>";
}
?>