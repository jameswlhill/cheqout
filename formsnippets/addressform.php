<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html"
		xmlns="http://www.w3.org/1999/html">
	<head>
		<meta charset="utf-8">
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.4/superhero/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="../css/flow.css">
		<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<!--		<script type="text/javascript" src="../js/jquery214.js"></script>-->
<!--		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>		-->
<!--		<script type="text/javascript" src="../js/bootstrap.js"></script>-->
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/additional-methods.min.js"></script>
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="ajax.js"></script>
		<title>The Address Form</title>
	</head>
	<body>
		<section>
			<form id="address" method='POST' action="addressinsert.php">
				<h1 class="text-center">Address</h1>
				<div class="row"><div class="col-xs-4 col-md-2"><label for="emailid">Email ID: </label></div><div class="row col-xs-4 col-md-2"><input type="text" id="emailid" name="emailid" required /></div></div>
				<div class="row">
					<div class="col-xs-4 col-md-2">
						<label>Label: </label>
					</div>
					<div class="row col-xs-4 col-md-2">
						<input type="text" id="label" name="label" />
					</div>
				</div>
				<div class="row"><div class="col-xs-4 col-md-2"><label>ATTN: </label></div><div class="row col-xs-4 col-md-2"><input type="text" id="attention" name="attention" required /></div></div>
				<div class="row"><div class="col-xs-4 col-md-2"><label>Street 1: </label></div><div class="row col-xs-4 col-md-2"><input type="text" id="street1" name="street1" required /></div></div>
				<div class="row"><div class="col-xs-4 col-md-2"><label>Street 2: </label></div><div class="row col-xs-4 col-md-2"><input type="text" id="street2" name="street2" /></div></div>
				<div class="row"><div class="col-xs-4 col-md-2"><label>City: </label></div><div class="row col-xs-4 col-md-2"><input type="text" id="city" name="city" required /></div></div>
				<div class="row"><div class="col-xs-4 col-md-2"><label>State: </label></div><div class="row col-xs-4 col-md-2"><input type="text" id="state" name="state" required /></div></div>
				<div class="row"><div class="col-xs-4 col-md-2"><label>Zip Code: </label></div><div class="row col-xs-4 col-md-2"><input type="text" id="zip" name="zip" required /></div></div>
				<div class="row"><div class="col-xs-4 col-md-4"><input type="submit"></div>
				</form>
		</section>
		<p id="addressOutputArea"></p>
	</body>
</html>
