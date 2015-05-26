<?php
$PAGE_TITLE = "Checkout - Cheqout";
require_once("../lib/utilities.php");
?>

	<div class="row">
		<section class="side-panel col-md-3">
			<?php require_once("../lib/sidebar.php"); ?>
		</section>
		<div class="container">
			<header>
				<?php require_once("../lib/header.php"); ?>
			</header>

				<div class="row">
					<div class="col-xs-8">
						<div class="panel panel-info">
							<div class="panel-heading">
								<div class="panel-title">
									<div class="row">
										<div class="col-xs-6">
											<h5><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</h5>
										</div>
										<div class="col-xs-6">
											<button type="button" class="btn btn-primary btn-sm btn-block">
												<span class="glyphicon glyphicon-share-alt"></span> Continue shopping
											</button>
										</div>
									</div>
								</div>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-xs-2"><img class="img-responsive" src="http://placehold.it/100x70">
									</div>
									<div class="col-xs-4">
										<h4 class="product-name"><strong>Product name</strong></h4><h4><small>Product description</small></h4>
									</div>
									<div class="col-xs-6">
										<div class="col-xs-6 text-right">
											<h6><strong>25.00 <span class="text-muted">x</span></strong></h6>
										</div>
										<div class="col-xs-4">
											<input type="text" class="form-control input-sm" value="1">
										</div>
										<div class="col-xs-2">
											<button type="button" class="btn btn-link btn-xs">
												<span class="glyphicon glyphicon-trash"> </span>
											</button>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-xs-2"><img class="img-responsive" src="http://placehold.it/100x70">
									</div>
									<div class="col-xs-4">
										<h4 class="product-name"><strong>Product name</strong></h4><h4><small>Product description</small></h4>
									</div>
									<div class="col-xs-6">
										<div class="col-xs-6 text-right">
											<h6><strong>25.00 <span class="text-muted">x</span></strong></h6>
										</div>
										<div class="col-xs-4">
											<input type="text" class="form-control input-sm" value="1">
										</div>
										<div class="col-xs-2">
											<button type="button" class="btn btn-link btn-xs">
												<span class="glyphicon glyphicon-trash"> </span>
											</button>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="text-center">
										<div class="col-xs-9">
											<h6 class="text-right">Changed quantity?</h6>
										</div>
										<div class="col-xs-3">
											<button type="button" class="btn btn-default btn-sm btn-block">
												Update cart
											</button>
										</div>
									</div>
								</div>
							</div>
							<div class="panel-footer">
								<div class="row text-center">
									<div class="col-xs-9">
										<h4 class="text-right">Total <strong>$50.00</strong></h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class='row'>
					<div class='col-md-4'>
						<script src='https://js.stripe.com/v2/' type='text/javascript'></script>
						<form accept-charset="UTF-8" action="/" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="pk_bQQaTxnaZlzv4FnnuZ28LFHccVSaj" id="payment-form" method="post"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="✓" /><input name="_method" type="hidden" value="PUT" /><input name="authenticity_token" type="hidden" value="qLZ9cScer7ZxqulsUWazw4x3cSEzv899SP/7ThPCOV8=" /></div>
							<div class='form-row'>
								<div class='col-xs-12 form-group required'>
									<label class='control-label'>Name on Card</label>
									<input class='form-control' size='4' type='text'>
								</div>
							</div>
							<div class='form-row'>
								<div class='col-xs-12 form-group card required'>
									<label class='control-label'>Card Number</label>
									<input autocomplete='off' class='form-control card-number' size='20' type='text'>
								</div>
							</div>
							<div class='form-row'>
								<div class='col-xs-4 form-group cvc required'>
									<label class='control-label'>CVC</label>
									<input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
								</div>
								<div class='col-xs-4 form-group expiration required'>
									<label class='control-label'>Expiration</label>
									<input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
								</div>
								<div class='col-xs-4 form-group expiration required'>
									<label class='control-label'> </label>
									<input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
								</div>
							</div>
							<div class='form-row'>
								<div class='col-md-12'>
									<div class='form-control total btn btn-info'>
										Total:
										<span class='amount'>$300</span>
									</div>
								</div>
							</div>
							<div class='form-row'>
								<div class='col-md-12 form-group'>
									<button class='form-control btn btn-primary submit-button' type='submit'>Pay »</button>
								</div>
							</div>
							<div class='form-row'>
								<div class='col-md-12 error form-group hide'>
									<div class='alert-danger alert'>
										Please correct the errors and try again.
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class='col-md-4'></div>
				</div>
			</div>
