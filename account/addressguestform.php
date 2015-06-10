	<form class="form-inline" id="addressguest" method="POST" action="../account/addressguestinsert.php">
		<div class="form-group">
			<label for="label"></label>
			<input type="text" class="form-control" id="label" name="label" placeholder="Label" >
		</div>
		<div class="form-group">
			<label for="attention"></label>
			<input type="text" class="form-control" id="attention" name="attention" placeholder="Name" required>
		</div>
		<div class="form-group">
			<label for="street1"></label>
			<input type="text" class="form-control" id="street1" name="street1" placeholder="Street Line 1" required>
		</div>
		<div class="form-group">
			<label for="street2"></label>
			<input type="text" class="form-control" id="street2" name="street2" placeholder="Street Line 2">
		</div>
		<div class="form-group">
			<label for="city"></label>
			<input type="text" class="form-control" id="city" name="city" placeholder="City" required>
		</div>
		<div class="form-group">
			<label for="state"></label>
			<input type="text" class="form-control" id="state" name="state" placeholder="State" required>
		</div>
		<div class="form-group">
			<label for="zip"></label>
			<input type="text" class="form-control" id="zip" name="zip" placeholder="Zip Code" required>
		</div>
		<p>
			<button type="submit" name="guestbilling" id="guestbilling" class="btn btn-primary col-md-4 col-md-offset-1">Billing</button>
			<button type="submit" name="guestshipping" id="guestshipping" class="btn btn-success col-md-4 col-md-offset-1">Shipping</button>
		</p>
	</form>
	<p id="addressOutputArea"></p>


