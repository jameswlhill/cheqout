<?php

function addressFormGenerator($addressId, $label, $attention, $street1, $street2, $city, $state, $zip) {
	echo '
	<div class="row col-md-4">
		<form class="form-inline" id="addressupdate" method="POST" action="addressupdatebutton.php">
			<div class="form-group">
				<label for="label"></label>
				<input type="text" class="form-control" id="label" name="label" value="' . $label . '">
			</div>
			<div class="form-group">
				<label for="attention"></label>
				<input type="text" class="form-control" id="attention" name="attention" value="' . $attention . '" required>
			</div>
			<div class="form-group">
				<label for="street1"></label>
				<input type="text" class="form-control" id="street1" name="street1"  value="' . $street1 . '" required>
			</div>
			<div class="form-group">
				<label for="street2"></label>
				<input type="text" class="form-control" id="street2" name="street2" value="' . $street2 . '">
			</div>
			<div class="form-group">
				<label for="city"></label>
				<input type="text" class="form-control" id="city" name="city" value="' . $city . '" required>
			</div>
			<div class="form-group">
				<label for="state"></label>
				<input type="text" class="form-control" id="state" name="state" value="' . $state . '" required>
			</div>
			<div class="form-group">
				<label for="zip"></label>
				<input type="text" class="form-control" id="zip" name="zip" value="' . $zip . '" required>
			</div>
			<div class="form-group hidden">
				<label for="addressId"></label>
				<input type="text" class="form-control" id="addressId" name="addressId" value="' . $addressId . '" required>
			</div>
			<p>
				<button type="submit" name="submit" class="btn btn-primary">Update Address</button>
		</form>
				<form class="form-inline" id="addressdelete" method="POST" action="addressdeletebutton.php">
				<button type="submit" name="submit" class="btn btn-primary">Delete Address</button>
			</p>
				<div class="form-group hidden">
					<label for="addressId"></label>
					<input type="text" class="form-control" id="addressId" name="addressId" value="' . $addressId . '" required>
				</div>
				</form>
	</div>

	';

}

