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
		<script type="text/javascript" src="../js/ajax.js"></script>
		<script type="text/javascript" src="../js/bootstrap.js"></script>
		<title>The Address Form</title>
	</head>
	<body>
		<h1 class="text-center">Change My Password</h1>
		<section>
			<div class="container">
				<form class="form-horizontal" id="testsession" method='POST' action="testsession.php">
					<div class="row"><div class="col-xs-4 col-xs-offset-3 col-md-4 col-md-offset-2"><input id="testsession" type="submit" value="Create Test Session"></div>
				</form>
				<p id="testSessionOutput"></p>
			</div>
			<div class="container">
				Your current password is <span class="text-info">not going to be displayed.</span>
				<form class="form-horizontal" id="passwordchange" method='POST' action="passwordchange.php">
					<div class="row"><div class="col-xs-4 col-md-2"><label for="activationcode">Current Password: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="activationcode" name="activationcode" value=""required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="oldpassword">Current Password: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="oldpassword" name="oldpassword" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="newpassword">New Password: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="newpassword" name="newpassword" required /></div></div>
					<div class="row"><div class="col-xs-4 col-md-2"><label for="passwordcheck">Re-enter New Password: </label></div><div class="row col-xs-4 col-md-3">
							<input type="text" id="passwordcheck" name="passwordcheck" /></div></div>
					<div class="row"><div class="col-xs-4 col-xs-offset-3 col-md-4 col-md-offset-2"><input id="passwordchange" type="submit" value="Change Password"></div>
				</form>
				<p id="passwordOutputArea"></p>
		</section>

</html>
