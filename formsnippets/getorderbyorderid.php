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

	if(@isset($orderId) 	=== false) {
		throw(new InvalidArgumentException("Please fill in your Order ID."));
	}
	// fill in an array with the order based on the order's ID only
	$orderArray = CheqoutOrder::getOrderHistoryByOrderId($pdo, $orderId);
	// THIS EMAIL GETTER WILL CHANGE TO SESSION LATER
	$email = Email::getEmailByEmailId($pdo, 1);
	// END COMMENT


	$orderArray = CheqoutOrder::getOrderHistoryByOrderId($pdo, $orderId);
	$challengeEmail = $orderArray[0][0];
	$account = Account::getAccountByEmailId($pdo, 1);
	if($email->getEmailAddress() !== $challengeEmail) {
		throw(new InvalidArgumentException("You can only get orders associated with YOUR E-Mail."));
	}
//	$formattedDate = $orderArray->getOrderDateTime()->format("Y-m-d H:i:s");

	echo '<table><tr id="order-header" class="text-info"><th>Email Address</th>
						  <th>Order ID</th>
						  <th>Quantity</th>
						  <th>Product ID</th>
						  <th>Product Title</th>
						  <th>Price (quantity*sale)</th>
						  <th>Shipping Cost</th>
						  <th>Order Total</th>
						  <th>Attention</th>
						  <th>Label</th>
						  <th>Street 1</th>
						  <th>Street 2</th>
						  <th>City</th>
						  <th>State</th>
						  <th>Zip</th>
						  <th>Time of Order</th></tr>';
	foreach($orderArray as $list) {
		echo '<tr>';
		foreach($list as $listItem) {
			echo '<td>' . $listItem  . '</td>';
		}
		echo '</tr>';
	}
	echo '</table>';

}catch(Exception $exception) {
	echo "<p class=\"alert alert-danger\">Exception: " . $exception->getMessage() . "</p>";
}
?>