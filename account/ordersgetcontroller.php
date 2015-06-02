<?php
require_once (dirname(__DIR__)) . "/php/class/autoload.php";
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
if(@isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
}
if(@isset($_SESSION["account"])) {
	$account = $_SESSION["account"];
}
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
try {
	if(@isset($email)	=== false && (@isset($account)) === false) {
		throw(new InvalidArgumentException("You aren't logged in!"));
	}
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
	// fill in an array with the order based on the order's ID only
	$orderArray = Email::getOrdersByEmail($pdo, $email->getEmailId());
	var_dump($orderArray);
	echo '<table class="table table-striped table-bordered"><tr id="order-header" class="text-info">
						  <th>Email Address</th>
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
	echo '<p class="alert alert-danger">Exception: ' . $exception->getMessage() . '</p>';
}

?>
