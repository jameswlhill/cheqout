<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.4/superhero/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/codewizard.css">
		<!--	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>										-->
		<script type="text/javascript" src="../js/jquery214.js"></script>
		<!--	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>		-->
		<script type="text/javascript" src="../js/bootstrap.js"></script>
		<title>The Address Form</title>
	</head>
	<body>
		<form>
				<label for="address">
					<h1 class="text-center">Address: </h1>
					<p class="col-xs-2 col-md-2">Label:<input type="text" id="label" name="label" /></p>
					<p>ATTN: <input type="text" id="attention" name="attention" required /></p>
					<p>Street 1: <input type="text" id="street1" name="street1" required /></p>
					<p>Street 2: <input type="text" id="street2" name="street2" /></p>
					<p>City: <input type="text" id="city" name="city" required /></p>
					<p>State: <input type="text" id="state" name="state" required /></p>
					<p>Zip Code: <input type="text" id="zip" name="zip" required /></p>
				</label>
		</form>
	</body>
</html>