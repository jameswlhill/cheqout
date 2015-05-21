<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/cheqoutorder.php";
require_once(dirname(__DIR__)) . "/php/class/email.php";
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
				Your current email is <span class="text-info"><?php echo $_SESSION["email"]->getEmailAddress() ?></span>
				<form method='POST' action="emailchange.php">
					<div class="row"><div class="col-xs-4 col-md-2"><label for="new-email">New Email: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="new-email" name="new-email" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="emailcheck">Re-enter: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="emailcheck" name="emailcheck" required /></div></div>
					<div class="row"><div class="col-xs-4 col-xs-offset-3 col-md-4 col-md-offset-2"><input type="submit" value="Change Email"></div>
				</form>
			</div>
			Your current password is <span class="text-info">not going to be displayed.</span>
			<form method='POST' action="passwordchange.php">
				<div class="row"><div class="col-xs-4 col-md-2"><label for="new-password">Password: </label></div><div class="row col-xs-4 col-md-3">
						<input type="text" id="new-password" name="new-password" required /></div></div>
				<div class="row"><div class="col-xs-4 col-md-2"><label for="passwordcheck">Re-enter: </label></div><div class="row col-xs-4 col-md-3">
						<input type="text" id="passwordcheck" name="passwordcheck" /></div></div>
				<div class="row"><div class="col-xs-4 col-xs-offset-3 col-md-4 col-md-offset-2"><input type="submit" value="Change Email"></div>
			</form>
		</section>
		<section>
			<div class="container">
				Your current email is: <br /><span class="text-info text-left"><?php echo
						$_SESSION["address"]->getAddressLabel()
						. "<br />" . $_SESSION["address"]->getAddressAttention()
						. "<br />" . $_SESSION["address"]->getAddressStreet1()
						. "<br />" . $_SESSION["address"]->getAddressStreet2()
						. "<br />" . $_SESSION["address"]->getAddressCity()
						. "<br />" . $_SESSION["address"]->getAddressState()
						. "<br />" . $_SESSION["address"]->getAddressZip() ?></span>
				<form method='POST' action="accountupdateinsert.php">
					<div class="row"><div class="col-xs-4 col-md-2"><label for="attention">ATTN: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="attention" name="attention" value="<?php echo $_SESSION["address"]->getAddressAttention() ?>" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="street1">Street 1: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="street1" name="street1" value="<?php echo $_SESSION["address"]->getAddressStreet1() ?>" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="street2">Street 2: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="street2" name="street2"  value="<?php echo $_SESSION["address"]->getAddressStreet2() ?>" /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="city">City: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="city" name="city" value="<?php echo $_SESSION["address"]->getAddressCity() ?>" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="state">State: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="state" name="state" value="<?php echo $_SESSION["address"]->getAddressState() ?>" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="zip">Zip Code: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="zip" name="zip" value="<?php echo $_SESSION["address"]->getAddressZip() ?>" required /></div></div>
					<div class="row"><div class="col-xs-4 col-xs-offset-3 col-md-4 col-md-offset-2"><input type="submit" value="Change Address"></div>
				</form>
			</div>
		</section>

	</body>
</html>
