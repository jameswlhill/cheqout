<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/cheqoutorder.php";
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once(dirname(__DIR__)) . "/php/class/address.php";
require_once(dirname(__DIR__)) . "/php/class/account.php";
require_once(dirname(__DIR__)) . "/php/class/product.php";
require_once(dirname(__DIR__)) . "/php/class/productorder.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");


//   ******** FOR TESTING ONLY **************
$email = new Email(1844, "emailadddyhere@wsup.com", "stripeidgoeshere");
$_SESSION["email"] = $email;
$address = new Address(1844, $_SESSION["email"]->getEmailId(), "attentionbro", "street1bro", "citybro", "statebro", "34567");
$_SESSION["address"] = $address;
$product = new Product(1844, "Deez Nuts", 18.49, "This item is in yo mouf", 10, .8);
$_SESSION["product"] = $product;
$order = new CheqoutOrder(1844, 1844, 1844, 1844, "hfgsdjkgk", new DateTime());
$_SESSION["order1"] = $order;
// end testing area


?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html"
		xmlns="http://www.w3.org/1999/html">
	<head>
		<meta charset="utf-8">
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.4/superhero/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="../css/flow.css">
		<!--	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>										-->
		<script type="text/javascript" src="../js/jquery214.js"></script>
		<!--	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>		-->
		<script type="text/javascript" src="../js/bootstrap.js"></script>
		<title>The Address Form</title>
	</head>
	<body>
		<h1 class="text-center">My Past Orders</h1>
		<section>
			<div class="container">
				<form method='POST' action="getorderbyorderid.php">
					<div class="row"><div class="col-xs-4 col-md-2"><label for="order-number">Order Number: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="order-number" name="order-number" required /></div></div>
					<div class="row"><div class="col-xs-4 col-xs-offset-3 col-md-4 col-md-offset-2"><input type="submit" value="Get Order Info"></div>
				</form>
			</div>
		</section>
		<section>
			<div class="container">
				<form method='POST' action="getorderbyemailaddress.php">
					<div class="row"><div class="col-xs-4 col-md-2"><label for="email-address">Email Address: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="email-address" name="email-address" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="password">Password: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="password" name="password" required /></div></div>
					<div class="row"><div class="col-xs-4 col-xs-offset-3 col-md-4 col-md-offset-2"><input type="submit" value="Get All Orders"></div>
				</form>
			</div>
		</section>
	</body>
</html>
