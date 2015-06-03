<?php
$PAGE_TITLE = "Cart - Cheqout";
require_once("../lib/utilities.php");
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();

}
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<link type="text/css" rel="stylesheet" href="../css/cart.css" />
	</head>
 <div class="row" id="cartview">
	<section class="side-panel col-md-3">
		<?php require_once("../lib/sidebar.php"); ?>
	</section>
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
				$cheqoutTotal = 0;
				echo "<table class='table table-striped'>"
					. "<tr class='text-info'>"
					. "<td>" . "Product ID" . "</td>"
					. "<td>" . "Product Price" . "</td>"
					. "<td>" . "Qty" . "</td>"
					. "</tr>";

				foreach ($_SESSION["cart"] as $cartItem) {

					echo '<tr class="data-row">';
					echo '<td>' . $cartItem[0] . '</td>';
					echo '<td>' . $cartItem['price'] . '</td>';
					echo '<td>' . $cartItem['qty'] . '</td>';
					echo '</tr>';


					/**echo '<li class="cartItem">';
					echo '<h3>'.$cartItem[0].'</h3>';
					echo '<div class="qty">Qty : '.$cartItem['qty'].'</div>';
					echo '<div class="price">Price :'.$cartItem['price'].'</div>';
					echo '</li>';*/

					$total = ($cartItem['qty']*$cartItem['price']);
				}

				echo "</table>";

				echo '<span class="cheqouttotal"><strong>Total : $ '.$total.'</strong> <a href="#">Continue to Checqout</a></span>';
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