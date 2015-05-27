<?php
/**
 * Format spl fixed array of products in JSON
 */

require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once(dirname(dirname(__DIR__)) . "/php/class/product.php");

/**
 * sets up the database connection
 */
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");

/**
 * Make an array of products from MySQL to pass to json_encode for use in typeahead plugin
 */
$userSearch = Product::getProductByProductDescription($pdo, $_POST['search']);

/**
 * Encode array of products into json format and store in fs
 */
$json = json_encode($userSearch);
echo $json;
?>