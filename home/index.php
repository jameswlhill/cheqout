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
			<div class="col-md-11 col-sm-11">
				<h1 class="front row">
					CHEQOUT
				</h1>
				<p class="front row">
					Find the latest, hottest reading material with minimal effort. Purchase like you never have before!</p>
					<div class="quote">"The person, be it gentleman or lady, who has not pleasure in a good novel, <br>
						must be intolerably stupid.” <br>
						― Jane Austen</div>

				<div class="row">
					<a href="../shop/index.php" class="btn btn-primary btn-lg col-md-1">Shop</a>
					<a href="../register/index.php" class="btn btn-primary btn-lg col-md-1 col-md-offset-1">Sign Up</a>
					<a href="../account/index.php" class="btn btn-primary btn-lg col-md-1 col-md-offset-1">Log In</a>
				</div>
			</div>
		</div>
	</div>
</body>
