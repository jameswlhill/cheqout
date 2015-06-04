<section>
	<div class="container">
		<form class="form-horizontal" id="address" method='POST' action="addressinsert.php">
			<div class="row"><div class="col-xs-4 col-md-2"><label for="label">Label: </label></div><div class="row col-xs-4 col-md-2">
					<input type="text" id="label" name="label" value="<?php if(@isset($_SESSION["address"]) === true) { echo $_SESSION["address"]->getAddressLabel(); } ?>" /></div></div>
			<div class="row"><div class="col-xs-4 col-md-2"><label for="attention">Name: </label></div><div class="row col-xs-4 col-md-3">
					<input type="text" id="attention" name="attention" value="<?php if(@isset($_SESSION["address"]) === true) { echo $_SESSION["address"]->getAddressAttention(); } ?>" required /></div></div>
			<div class="row"><div class="col-xs-4 col-md-2"><label for="street1">Street 1: </label></div><div class="row col-xs-4 col-md-3">
					<input type="text" id="street1" name="street1" value="<?php if(@isset($_SESSION["address"]) === true) { echo $_SESSION["address"]->getAddressStreet1(); } ?>" required /></div></div>
			<div class="row"><div class="col-xs-4 col-md-2"><label for="street2">Street 2: </label></div><div class="row col-xs-4 col-md-3">
					<input type="text" id="street2" name="street2"  value="<?php if(@isset($_SESSION["address"]) === true) { echo $_SESSION["address"]->getAddressStreet2(); } ?>" /></div></div>
			<div class="row"><div class="col-xs-4 col-md-2"><label for="city">City: </label></div><div class="row col-xs-4 col-md-3">
					<input type="text" id="city" name="city" value="<?php if(@isset($_SESSION["address"]) === true) { echo $_SESSION["address"]->getAddressCity(); } ?>" required /></div></div>
			<div class="row"><div class="col-xs-4 col-md-2"><label for="state">State: </label></div><div class="row col-xs-4 col-md-3">
					<input type="text" id="state" name="state" value="<?php if(@isset($_SESSION["address"]) === true) { echo $_SESSION["address"]->getAddressState(); } ?>" required /></div></div>
			<div class="row"><div class="col-xs-4 col-md-2"><label for="zip">Zip Code: </label></div><div class="row col-xs-4 col-md-3">
					<input type="text" id="zip" name="zip" value="<?php if(@isset($_SESSION["address"]) === true) { echo $_SESSION["address"]->getAddressZip(); } ?>" required /></div></div>
			<div class="row"><div class="col-xs-4 col-xs-offset-3 col-md-4 col-md-offset-2"><input id="submitaddress" type="submit" class="btn btn-primary" value="Add Address"></div>
		</form>
	</div>
	<p id="addressOutputArea"></p>
</section>