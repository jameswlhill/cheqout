<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/address.php";
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once(dirname(__DIR__)) . "/php/class/account.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
$_SESSION["email"] = Email::getEmailByEmailId($pdo, 1);
$_SESSION["address"] = Address::getAddressByAddressId($pdo, 1)
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
		<script type="text/javascript" src="ajax.js"></script>
		<script type="text/javascript" src="../js/bootstrap.js"></script>
		<title>The Address Form</title>
	</head>
	<body>
		<h1 class="text-center">Update My Account</h1>
		<section>
			<div class="container">
					Your current email is <span class="text-info"><?php echo $_SESSION["email"]->getEmailAddress() ?></span>
				<form id="accountupdate" method='POST' action="emailchange.php">
					<div class="row"><div class="col-xs-4 col-md-2"><label for="activation-code">Activation Code: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="activation-code" name="activationcode" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="new-email">New Email: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="new-email" name="newemail" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="emailcheck">Re-enter: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="emailcheck" name="emailcheck" required /></div></div>
					<div class="row"><div class="col-xs-4 col-xs-offset-3 col-md-4 col-md-offset-2"><input type="submit" value="Change Email"></div>
				</form>
				<p id="emailOutputArea"></p>
			</div>
				Your current password is <span class="text-info">not going to be displayed.</span>
				<form method='POST' action="passwordchange.php">
					<div class="row"><div class="col-xs-4 col-md-2"><label for="old-password">Current Password: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="old-password" name="old-password" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="new-password">New Password: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="new-password" name="new-password" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="passwordcheck">Re-enter New Password: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="passwordcheck" name="passwordcheck" /></div></div>
					<div class="row"><div class="col-xs-4 col-xs-offset-3 col-md-4 col-md-offset-2"><input type="submit" value="Change Password"></div>
				</form>
			<p id="passwordOutputArea"></p>
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
				<form method='POST' action="addressinsert.php">
					<div class="row"><div class="col-xs-4 col-md-2"><label for="emailid">Email ID: </label></div><div class="row col-xs-4 col-md-2">
							<input type="text" id="emailid" name="emailid" required /></div></div>
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
			<p id="addressOutputArea"></p>
		</section>
		
	</body>
</html>
