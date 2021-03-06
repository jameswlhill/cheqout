<?php
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once(dirname(__DIR__) . "/lib/csrfver.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
if(@isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
}
if(@isset($_SESSION["account"])) {
	$account = $_SESSION["account"];
}


$PAGE_TITLE = "Cart - Cheqout";
require_once("../lib/utilities.php");
?>
<header>
	<?php require_once("../lib/header.php"); ?>
</header>
		<link type="text/css" rel="stylesheet" href="../css/cart.css">
		<script type="text/javascript" src="../controllers/update.js"></script>
		<script type="text/javascript" src="../controllers/remove.js"></script>
	<body>
	<div class="container">
		<div class="container" id="cartview">
			<div class="col-md-5" id="cart">
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

				$cart = $_SESSION['cart'];

					foreach($cart as $productId => $quantity) {
						$csrf = generateInputTags();
						$product = Product::getProductByProductId($pdo, $productId);
						echo '<tr class="data-row" id="' . $product->getProductId() . '">';
						echo '<td>' . $product->getProductTitle() . '</td>';
						echo '<td>' . $product->getProductDescription() . '</td>';
						echo '<td>' . '$<span class="price">' . $product->getProductPrice() . '</span></td>';
						echo '<td><span class="quantityField">' . $quantity
							. '</span><form class="add" method="post" action="../controllers/cartcontroller.php">'
							.		'<span class="csrf">'
							.		 $csrf
							.		'</span><label for="quantity">'
							.			'Update Qty:'
							.			'<input type="number" id="quantity" name="quantity" min="0" step="1" value="' . $quantity . '" class="form-control" />' .
										'<input type="hidden" name="productId" value="' . $product->getProductId() . '" class="form-control" />'
							.			'<button type="submit" class="btn btn-success btn-xs update">'
							.				'<i class="glyphicon glyphicon-ok"></i>'
							.			'</button>'
							.		'</label>'
							. '</form>'.
								'<form class="remove" method="get" action="../controllers/remove.php?productId=' . $product->getProductId() . '">'
							. 	'<input type="hidden" name="productId" value="' . $product->getProductId() . '" class="form-control" />'
							.			'<button type="submit" class="btn btn-danger btn-xs remove">'
							.				'<i class="glyphicon glyphicon-remove"></i>'
							.			'</button></form>'
							. '</td>';
						echo '</tr>';
						$cheqoutTotal = $cheqoutTotal + (($product->getProductPrice()) * ($quantity));
					}
				// completely arbitrary shipping cost
				echo '</table>';
				$cheqoutTotal = $cheqoutTotal * 100;
				$shippingTotal = 500; // this means 5 bucks
				$_SESSION["shippingcost"] = $shippingTotal;
				$_SESSION["ordercost"] = $cheqoutTotal;
				$_SESSION["total"] = $_SESSION["shippingcost"] + $_SESSION["ordercost"];
					echo 		'<div class="text-right"><strong>Shipping</strong>: $<span class="total">' . ($shippingTotal / 100) . '</span></div>';
					echo		'<div class="text-right"><strong>Total</strong> : $<span class="total">' . (($cheqoutTotal + $shippingTotal)/100) . '</span></div>';

				} else {
					echo '<h2>There are no items in your cart. Add some! =)</h2>';
			}
			echo		'<p id="output"></p>';
		echo		'</div>';

//		$_SESSION["order"] = new CheqoutOrder(null, $_POST['billing']
			?>

				<div class="container col-md-3">
					<div class="col-md-12">
						<?php require_once(dirname(__DIR__) . "/account/addressplaceholderbilling.php"); ?>
					</div>
					<div class="col-md-12">
						<?php require_once(dirname(__DIR__) . "/account/addressplaceholdershipping.php"); ?>
					</div>
				</div>
				<div class="container col-md-3 col-md-offset-1">
					<?php require_once(dirname(__DIR__) . "/account/addressminigetcontroller.php"); ?>
				</div>
			</div>

<?php
				// BUTTON FOR PAYING
				echo 		'<div class="container">'
						.		'<div class="pull-right">';
							require_once("../checkout/index.php");
							echo 			'</div>'
						. '</div>'
					.'</div>';
?>