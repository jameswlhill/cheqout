<?php
require_once("../lib/utilities.php");
?>

	<div class="row header">
		<div class="col-md-1">
		<div id="sidebar-wrapper">
			<ul class="sidebar-nav">
				<li class="link">
					<a class="btn" id="home" href="../home" data-toggle="tooltip" data-placement="right" title="" data-original-title="Home"><span class="glyphicon glyphicon-home home"></span></a>
				</li>
				<li class="link">
					<a class="btn" id="shop" href="../shop" data-toggle="tooltip" data-placement="right" title="" data-original-title="Shop"><span class="glyphicon glyphicon-usd shop"></span></a>
				</li>
				<li class="link">
					<a class="btn" id="cart" href="../cart" data-toggle="tooltip" data-placement="right" title="" data-original-title="Cart"><span class="glyphicon glyphicon-shopping-cart cart"></span></a>
				</li>
				<li class="link">
					<a class="btn" id="acct" href="../account" data-toggle="tooltip" data-placement="right" title="" data-original-title="Account"><span class="glyphicon glyphicon-cog account"></span></a>
				</li>
				<li class="link">
					<a class="btn" id="about" href="../about" data-toggle="tooltip" data-placement="right" title="" data-original-title="Contact"><span class="glyphicon glyphicon-comment contact"></span></a>
				</li>
			</ul>
		</div>
			</div>
		<div class="col-md-8"></div>
		<h1>Cheqout</h1>
		<p>A catchy description about our stuff</p>
		<div id="loginform">
		<?php require_once("loginform.php"); ?>
		<span id="loginOutput" class="alert pull-left"></span>
		</div>
	</div>

<script>
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>

<script>
	$('#home').mouseenter(function () {
		$('#home').effect("bounce", {
			direction: 'right',
			times: 1
		}, 200);
	});
	$('#shop').mouseenter(function () {
		$('#shop').effect("bounce", {
			direction: 'right',
			times: 1
		}, 200);
	});
	$('#cart').mouseenter(function () {
		$('#cart').effect("bounce", {
			direction:'right',
			times: 1
		}, 200);
	});
	$('#acct').mouseenter(function () {
		$('#acct').effect("bounce", {
			direction:'right',
			times: 1
		}, 200);
	});
	$('#about').mouseenter(function () {
		$('#about').effect("bounce", {
			direction:'right',
			times: 1
		}, 200);
	});
</script>

