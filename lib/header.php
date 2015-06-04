<?php
require_once("../lib/utilities.php");
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>

	<div class="row header">
		<div class="col-md-1">
		<div id="sidebar-wrapper">
			<ul class="sidebar-nav">
				<li class="link">
					<a class="btn" id="home" href="../home" data-toggle="tooltip" data-placement="right" title="" data-original-title="Home" data-animation=""><span class="glyphicon glyphicon-home home"></span></a>
				</li>
				<li class="link">
					<a class="btn" id="shop" href="../shop" data-toggle="tooltip" data-placement="right" title="" data-original-title="Shop" data-animation=""><span class="glyphicon glyphicon-usd shop"></span></a>
				</li>
				<li class="link">
					<a class="btn" id="cart" href="../cart" data-toggle="tooltip" data-placement="right" title="" data-original-title="Cart" data-animation=""><span class="glyphicon glyphicon-shopping-cart cart"></span></a>
				</li>
				<li class="link">
					<a class="btn" id="acct" href="../account" data-toggle="tooltip" data-placement="right" title="" data-original-title="Account" data-animation=""><span class="glyphicon glyphicon-cog account"></span></a>
				</li>
				<li class="link">
					<a class="btn" id="about" href="../about" data-toggle="tooltip" data-placement="right" title="" data-original-title="Contact" data-animation=""><span class="glyphicon glyphicon-comment contact"></span></a>
				</li>
			</ul>
		</div>
			</div>
		<div class="col-md-8"></div>
		<h1>Cheqout</h1>
		<p>A catchy description about our stuff</p>
		<div id="loginform">
		<?php require_once("loginform.php"); ?>
		<p id="loginOutput" class="alert pull-left"></p>
		</div>
	</div>