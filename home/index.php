<?php
$PAGE_TITLE = "Home - Cheqout";
require_once("../lib/utilities.php");
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>
<!--We don't call to header.php on this page because of full page background-->
<body class="full">
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
<!-- Page Content -->
<div class="container">
	<div class="row">
		<div class="col-md-6 col-sm-12">
			<h1 class="front">CHEQ US OUT!</h1>
			<p class="front">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni, iusto, unde, sunt incidunt id sapiente
				rerum soluta voluptate harum veniam fuga odit ea pariatur vel eaque sint sequi tenetur eligendi.</p>
			<a href="../shop/index.php" class="btn btn-primary">Shop</a>
			<a href="../register/index.php" class="btn btn-primary">Sign Up</a>
			<a href="../account/index.php" class="btn btn-primary">Log In</a>
		</div>
	</div>
	<!-- /.row -->
</div>
<!-- /.container -->

</body>

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
