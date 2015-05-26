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
$pdo = $pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/encrypted-config.php");

if(verifyCsrf($name,$sentToken) === false){
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
	$_SESSION["cart"][$productId] = $quantity;
}

$quantity = filter_input(INPUT_POST, "quantity", FILTER_VALIDATE_INT);
if($quantity <= 0) {
	throw(new Exception("quantity must be positive"));
} elseif($quantity === 0) {
	unset($_SESSION["cart"][$productId]);
} else {
	$quantity = $_POST['quantity'];
}

?>