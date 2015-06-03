<?php
/**
 * Shopping cart processor
 *
 * @author James Hill <james@appists.com>
 */


session_start();

require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once(dirname(__DIR__) . "/php/class/product.php");
require_once(dirname(__DIR__) . "/lib/csrfver.php");

$productId = $_POST['productId'];
$quantity = $_POST['quantity'];
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");

if(verifyCsrf($_POST["csrfName"], $_POST["csrfToken"]) === false){
	throw(new RuntimeException('CSRF verification failed'));
}

$productId = filter_var($productId, FILTER_VALIDATE_INT);
if($productId === false) {
	throw(new PDOException("product id is not a valid integer"));
}
if($productId <= 0) {
	throw(new PDOException("product id must be a positive integer"));
}

$product = Product::getProductByProductId($pdo, $productId);

//if we have the product info, add to an array of added items
if($product !== null) {
	$_SESSION["cart"][$productId] = $qty;
}

$qty = filter_input(INPUT_POST, "qty", FILTER_VALIDATE_INT);
if($qty <= 0) {
	throw(new Exception("qty must be positive"));
} elseif($qty === 0) {
	unset($_SESSION["cart"][$productId]);
} else {
	$qty= $_SESSION["cart"][$qty];
}

?>