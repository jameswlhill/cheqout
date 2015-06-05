<?php
$PAGE_TITLE = "Cart - Cheqout";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once(dirname(__DIR__) . "/lib/csrfver.php");
require_once("../lib/utilities.php");
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();

}
?>
<header>
	<?php require_once("../lib/header.php"); ?>
</header>
		<link type="text/css" rel="stylesheet" href="../css/cart.css">
		<script type="text/javascript" src="../controllers/update.js"></script>
		<script type="text/javascript" src="../controllers/remove.js"></script>
	<body>
 <div class="row" id="cartview">
	<header>
		<?php require_once("../lib/header.php"); ?>
	</header>

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
						echo '<tr class="data-row" id="' . $product->getProductId() . '">';
						echo '<td>' . $product->getProductTitle() . '</td>';
						echo '<td>' . $product->getProductDescription() . '</td>';
						echo '<td>' . '$<span class="price">' . $product->getProductPrice() . '</span></td>';
						echo '<td><span class="quantityField">' . $quantity
							. '</span><form class="add" method="post" action="../controllers/cartcontroller.php">'
							.		'<span class="csrf">'
							.		 generateInputTags()
							.		'</span><label for="quantity">'
							.			'Update Qty:'
							.			'<input type="number" id="quantity" name="quantity" min="0" step="1" value="' . $quantity . '" class="form-control" />' .
										'<input type="hidden" class="productId" name="productId" value="' . $product->getProductId() . '" class="form-control" />'
							.			'<button type="submit" class="btn btn-success btn-xs update">'
							.				'<i class="glyphicon glyphicon-ok"></i>'
							.			'</button>'
							.		'</label>'
							. '</form>'.
								'<form class="remove" method="get" action="../controllers/remove.php?productId=' . $product->getProductId() . '">'
							. 	'<input type="hidden" class="productId" name="productId" value="' . $product->getProductId() . '" class="form-control" />'
							.			'<button type="submit" class="btn btn-danger btn-xs remove">'
							.				'<i class="glyphicon glyphicon-remove"></i>'
							.			'</button></form>'
							. '</td>';
						echo '</tr>';

						$cheqoutTotal = $cheqoutTotal + (($product->getProductPrice()) * ($quantity));
					}

					echo '</table>';

					echo 	'<div class="cheqouttotal pull-right"><strong>Total</strong> : $<span class="total">'  . $cheqoutTotal . '</span></div>';
					echo '<div class="row"></div>';
					echo  '<hr>';
					echo '<div class="row">'
							. '<div class="container">'
							.		'<div>'
							.			'<button class="btn btn-success btn-lg pull-right">Continue to Checqout</button>'
							.		'</div>'
							.		'<div>'
							.			'<button class="btn btn-danger btn-lg pull-right">Empty Cart</button>'
							.		'</div>'
							. '</div>'
							.'</div>';

				}else{
					echo 'There are no items in your cart';
			}
			?>
		</div>
	 <p id="output"></p>
	 </div>
	</body>
</html>