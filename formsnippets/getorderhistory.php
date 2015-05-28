<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/cheqoutorder.php";
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once(dirname(__DIR__)) . "/php/class/account.php";
require_once(dirname(__DIR__)) . "/php/class/product.php";
require_once(dirname(__DIR__)) . "/php/class/productorder.php";
require_once(dirname(__DIR__)) . "/php/class/address.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

// INSERTED FOR TESTING WITHOUT A SESSION
$_SESSION["emailId"] = 1;
$_SESSION["accountId"] = 1;
// FUTURE VERSION WILL HAVE SESSION["emailId"] ALREAYD SET


try {
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
	$emailId = $_SESSION["emailId"];

	if(@isset($emailId) 	=== false && @isset($_SESSION["accountId"])) {
		throw(new InvalidArgumentException("You aren't logged in!"));
	}
	// fill in an array with the order based on the order's ID only
	$orderArray = Email::getOrdersByEmail($pdo, $emailId);
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
	echo "<p class=\"alert alert-danger\">Exception: " . $exception->getMessage() . "</p>";
}
?>