<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/address.php";
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once(dirname(__DIR__)) . "/php/class/account.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");


// FOR TESTING ONLY -- TO TEST FUNCTIONALITY ASSUMING SESSION WILL ALWAYS HAVE AN ADDRESS
//   ******** FOR TESTING ONLY 1845 EMAIL ID **************
$email = new Email(1845, "emailadddyhere@wsup.com", "stripeidgoeshere");
$_SESSION["email"] = $email;
$address = new Address(1845, $_SESSION["email"]->getEmailId(), "attentionbro", "street1bro", "citybro", "statebro", "34567");
$_SESSION["address"] = $address;
var_dump($_SESSION["email"])
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
		<h1 class="text-center">Update My Account</h1>
		<section>
			<div class="container">
				<h2 class="text-center">
					Your current email is <span class="text-info"><?php echo $_SESSION["email"]->getEmailAddress() ?></span>
				</h2>
				<form method='POST' action="emailchange.php">
					<div class="row"><div class="col-xs-4 col-md-2"><label for="new-email">New Email: </label></div><div class="row col-xs-4 col-md-2">
							<input type="text" id="new-email" name="new-email" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="emailcheck">Re-enter: </label></div><div class="row col-xs-4 col-md-2">
							<input type="text" id="emailcheck" name="emailcheck" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="new-password">Password: </label></div><div class="row col-xs-4 col-md-2">
							<input type="text" id="new-password" name="new-password" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="passwordcheck">Re-enter: </label></div><div class="row col-xs-4 col-md-2">
							<input type="text" id="passwordcheck" name="passwordcheck" /></div></div>
					<div class="row"><div class="col-xs-4 col-xs-offset-3 col-md-4 col-md-offset-3"><input type="submit"></div>
				</form>
			</div>
		</section>
		<section>
			<div class="container">
				<form method='POST' action="accountupdateinsert.php">
					<div class="row"><div class="col-xs-4 col-md-2"><label for="attention">ATTN: </label></div><div class="row col-xs-4 col-md-2">
							<input type="text" id="attention" name="attention" value="<?php echo $_SESSION["address"]->getAddressAttention() ?>" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="street1">Street 1: </label></div><div class="row col-xs-4 col-md-2">
							<input type="text" id="street1" name="street1" value="<?php echo $_SESSION["address"]->getAddressStreet1() ?>" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="street2">Street 2: </label></div><div class="row col-xs-4 col-md-2">
							<input type="text" id="street2" name="street2"  value="<?php echo $_SESSION["address"]->getAddressStreet2() ?>" /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="city">City: </label></div><div class="row col-xs-4 col-md-2">
							<input type="text" id="city" name="city" value="<?php echo $_SESSION["address"]->getAddressCity() ?>" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="state">State: </label></div><div class="row col-xs-4 col-md-2">
							<input type="text" id="state" name="state" value="<?php echo $_SESSION["address"]->getAddressState() ?>" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="zip">Zip Code: </label></div><div class="row col-xs-4 col-md-2">
							<input type="text" id="zip" name="zip" value="<?php echo $_SESSION["address"]->getAddressZip() ?>" required /></div></div>
					<div class="row"><div class="col-xs-4 col-xs-offset-3 col-md-4 col-md-offset-3"><input type="submit"></div>
				</form>
			</div>
		</section>
	</body>
</html>
