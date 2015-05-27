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

	if(@isset($_POST["orderid"]) 	=== false) {
		throw(new InvalidArgumentException("Please fill in your orderArray ID."));
	}
	if($email->getEmailAddress() !== $orderArray["emailAddress"]) {
		throw(new InvalidArgumentException("You can only get orders associated with YOUR E-Mail."));
	}

	$orderArray = CheqoutOrder::getOrderHistoryByOrderId($pdo, $orderId);
	$email = Email::getEmailByEmailId($pdo, 1);
	$account = Account::getAccountByEmailId($pdo, 1);
//	$formattedDate = $orderArray->getOrderDateTime()->format("Y-m-d H:i:s");
	$order = array($orderArray["emailAddress"],
		$orderArray["orderId"],
		$orderArray["quantity"],
		$orderArray["productId"],
		$orderArray["productTitle"],
		$orderArray["productQuantityTotal"],
		$orderArray["shippingCost"],
		$orderArray["orderPrice"],
		$orderArray["attention"],
		$orderArray["label"],
		$orderArray["street1"],
		$orderArray["street2"],
		$orderArray["city"],
		$orderArray["state"],
		$orderArray["zip"],
		$orderArray["orderDateTime"]);
	echo '<table><tr><th>Email Address</th>
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
	foreach($order as $list) {
	echo '<td>' . $list  . '</td>';
	}
	echo '</table>';

}catch(Exception $exception) {
	echo "<p class=\"alert alert-danger\">Exception: " . $exception->getMessage() . "</p>";
}
?>