<?php
function addressMiniFormGenerator($addressId, $label, $attention, $street1) {
	if($label === null) {
		$label = $attention;
	}
echo '<div class="col-md-6">
			<form class="form-inline" id="addressminiupdate" method="POST" action="addressminiupdatebutton.php">
				<div class="panel panel-primary">
  					<div class="panel-heading">
   					<h3 class="panel-title">' . $label . '</h3>
  					</div>
  					<div class="panel-body">
    					ATTN: ' . $attention . ' < /br>
    					' . $street1 . '
  					</div>
  					<p>
  					<div class="form-group hidden">
						<label for="addressId"></label>
						<input type="text" class="form-control" id="addressId" name="addressId" value="' . $addressId . '" required>
					</div>
						<button type="submit" name="addressbilling" class="btn btn-primary col-md-3">Billing</button>
						<button type="submit" name="addressshipping" class="btn btn-success col-md-3">Shipping</button>
					</p>
			</form>
		</div>';
}
