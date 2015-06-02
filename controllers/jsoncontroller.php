<?php
/**
 * Format spl fixed array of products in JSON
 */

require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once(dirname(__DIR__)) . "/php/class/product.php";

/**
 * sets up the database connection
 */
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");

/**
 * Make an array of products from MySQL to pass to json_encode
 */
$userSearch = Product::getProductByProductDescription($pdo, filter_var($_GET['search'], FILTER_SANITIZE_STRING));

if($userSearch !== null) {
	echo "<table class='table table-striped'>"
		. "<tr class='text-info'>"
		. "<td>" . "Product ID" . "</td>"
		. "<td>" . "Product Title" . "</td>"
		. "<td>" . "Product Price" . "</td>"
		. "<td>" . "Product Description" . "</td>"
		. "</tr>";


	foreach($userSearch as $product) {
		echo '<tr class="data-row">';
		echo '<td>' . $product->getProductId() . '</td>';
		echo '<td>' . $product->getProductTitle() . '</td>';
		echo '<td>' . $product->getProductPrice() . '</td>';
		echo '<td>' . $product->getProductDescription() . '</td>';
		echo '</tr>';
	}

	echo '</table>';

} else {
	echo "<p class=\"alert alert-warning\">No matches found</p>";
}
?>