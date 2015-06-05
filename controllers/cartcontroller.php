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

$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");

if(verifyCsrf($_POST["csrfName"], $_POST["csrfToken"]) === false){
	throw(new RuntimeException('CSRF verification failed'));
}

$productId = filter_input(INPUT_POST, "productId", FILTER_VALIDATE_INT);
if($productId === false) {
	throw(new PDOException("product id is not a valid integer"));
}
if($productId <= 0) {
	throw(new PDOException("product id must be a positive integer"));
}

$product = Product::getProductByProductId($pdo, $productId);

$quantity = filter_input(INPUT_POST, "quantity", FILTER_VALIDATE_INT);
if($product !== null) {
	if($quantity <= 0) {
		throw(new Exception("quantity must be positive"));
	} elseif($quantity === 0) {
		unset($_SESSION["cart"][$productId]);
		echo $quantity;
	} else {
		$_SESSION["cart"][$productId] = $quantity;
		echo $quantity;
	}
}
?>