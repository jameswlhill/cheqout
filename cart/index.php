<?php
$PAGE_TITLE = "Cart - Cheqout";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once("../lib/utilities.php");
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();

}
?>
<<<<<<< Updated upstream
<header>
	<?php require_once("../lib/header.php"); ?>
</header>
=======
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<link type="text/css" rel="stylesheet" href="../css/cart.css"
	</head>
	<body>
 <div class="row" id="cartview">
	<header>
		<?php require_once("../lib/header.php"); ?>
	</header>
>>>>>>> Stashed changes

		<div class="container">
			<div id="main">
				<h2>Your Shopping Cart</h2>
			</div>
		</div>
		<div id="cart">
			<h1>Cheqout Shopping Cart</h1>
			<?php
			if(isset($_SESSION["cart"])) {
				$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
				$cheqoutTotal = 0;

					echo "<table class='table table-hover'>"
						. "<tr class='text-info'>"
						. "<td>" . "Product Title" . "</td>"
						. "<td>" . "Product Description" . "</td>"
						. "<td>" . "Product Price" . "</td>"
						. "<td>" . "Order Quantity" . "</td>"
						. "</tr>";


					foreach($_SESSION["cart"] as $productId => $quantity) {
						$product = Product::getProductByProductId($pdo, $productId);
						echo '<tr class="data-row">';
						echo '<td>' . $product->getProductTitle() . '</td>';
						echo '<td>' . $product->getProductDescription() . '</td>';
						echo '<td>' . $product->getProductPrice() . '</td>';
						echo '<td>' . $quantity . '</td>';
						echo '</tr>';

						$total = (($product->getProductPrice()) * ($quantity));
					}

					echo '</table>';

					echo '<span class="cheqouttotal"><strong>Total : $ ' . $total . '</strong> <a href="#">Continue to Checqout</a></span>';
					echo '<span class="emptycart"><a href="#">Empty Cart</a></span>';

				}else{
					echo 'There are no items in your cart';
			}
			?>
		</div>
	 <p id="output"></p>
	 </div>
	</body>
</html>