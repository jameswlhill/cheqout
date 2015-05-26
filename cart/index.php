<?php
/**
 * Cheqout cart index/view
 *
 * @author James Hill <james@appists.com>
 */
?>

<!DOCTYPE HTML>
<html>
	<head lang="en">
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Cheqout shopping cart</title>

		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
		<!-- Optional theme -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css" />
		<!-- HTML5 shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- Load jQuery and the typeahead JS files -->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/additional-methods.min.js"></script>

		<!-- Latest compiled and minified Bootstrap JavaScript, all compiled plugins included -->
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	</head>

	<body>
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
	</body>
</html>