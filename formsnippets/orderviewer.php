<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/cheqoutorder.php";
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once(dirname(__DIR__)) . "/php/class/address.php";
require_once(dirname(__DIR__)) . "/php/class/account.php";
require_once(dirname(__DIR__)) . "/php/class/product.php";
require_once(dirname(__DIR__)) . "/php/class/productorder.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");




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
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/additional-methods.min.js"></script>
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/ajax.js"></script>
		<script type="text/javascript" src="../js/bootstrap.js"></script>
		<title>The Address Form</title>
	</head>
	<body>
		<h1 class="text-center">My Past Orders</h1>
		<section>
			<div class="container">
				<form id="orderbyid" method='POST' action="getorderbyorderid.php">
					<div class="row"><div class="col-xs-4 col-md-2"><label for="orderid">Order Number: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="orderid" name="orderid" required /></div></div>
					<div class="row"><div class="col-xs-4 col-xs-offset-3 col-md-4 col-md-offset-2"><input id="orderidbutton" type="submit" value="Get Order Info"></div>
				</form>
			</div>
		</section>
		<section>
			<div class="container">
				<form id="getorderhistory" method='POST' action="getorderhistory.php">
					<div class="row"><div class="col-xs-4 col-xs-offset-3 col-md-4 col-md-offset-2"><input id="orderhistory" type="submit" value="View Order History"></div>
				</form>
			</div>
		</section>
		<p id="orderOutputArea"></p>
	</body>

</html>
