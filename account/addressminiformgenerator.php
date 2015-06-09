<?php
function addressMiniFormGenerator($addressId, $label, $attention, $street1) {
	if($label === null) {
		$label = $attention;
	}
echo '<div class="row">
			<form class="form-inline" id="addressminiupdate" method="POST" action="../account/addressminibuttons.php">
				<div class="panel panel-primary">
  					<div class="panel-heading">
   					<h3 class="panel-title">' . $label . '</h3>
  					</div>
  					<div class="panel-body">
    					<p>ATTN: ' . $attention . '</p>
    					<p>' . $street1 . '</p>
  					<p>
  						<div class="form-group hidden">
							<label for="addressId"></label>
							<input type="text" class="form-control" id="addressId" name="addressId" value="' . $addressId . '" required>
						</div>
						<button type="submit" name="addressbilling" class="btn btn-primary col-md-4">Billing</button>
						<button type="submit" name="addressshipping" class="btn btn-success col-md-4 col-md-offset-3">Shipping</button>
					</p>
					</div>
				</div>
			</form>
		</div>';
}
