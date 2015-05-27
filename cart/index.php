<?php
$PAGE_TITLE = "Cart - Cheqout";
require_once("../lib/utilities.php");
?>


 <div class="row">
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
			if(isset($_SESSION["cart"]))
			{
				$cheqoutTotal = 0;
				echo '<ol>';
				foreach ($_SESSION["cart"] as $cartItem)
				{
					echo '<li class="cartItem">';
					echo '<h3>'.$cartItem["title"].'</h3>';
					echo '<div class="qty">Qty : '.$cartItem["qty"].'</div>';
					echo '<div class="price">Price :'.$cartItem["price"].'</div>';
					echo '</li>';
					$total = ($cartItem["price"]*$cartItem["qty"]);
				}
				echo '</ol>';
				echo '<span class="cheqouttotal"><strong>Total : $ '.$total.'</strong> <a href="#">Continue to Checqout</a></span>';
				echo '<span class="emptycart"><a href="#">Empty Cart</a></span>';
			}else{
				echo 'There are no items in your cart';
			}
			?>
		</div>
	 </div>
	</body>
</html>