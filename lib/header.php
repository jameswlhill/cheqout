<?php
require_once("../lib/utilities.php");
?>

	<div class="row header">
		<div class="col-md-1">
		<div id="sidebar-wrapper">
			<ul class="sidebar-nav">
				<li class="link">
					<a class="btn" href="../home" data-toggle="tooltip" data-placement="right" title="" data-original-title="Home"><span class="glyphicon glyphicon-home home"></span></a>
				</li>
				<li class="link">
					<a class="btn" href="../shop" data-toggle="tooltip" data-placement="right" title="" data-original-title="Shop"><span class="glyphicon glyphicon-usd shop"></span></a>
				</li>
				<li class="link">
					<a class="btn" href="../cart" data-toggle="tooltip" data-placement="right" title="" data-original-title="Cart"><span class="glyphicon glyphicon-shopping-cart cart"></span></a>
				</li>
				<li class="link">
					<a class="btn" href="../account" data-toggle="tooltip" data-placement="right" title="" data-original-title="Account"><span class="glyphicon glyphicon-cog  account"></span></a>
				</li>
				<li class="link">
					<a class="btn" href="../about" data-toggle="tooltip" data-placement="right" title="" data-original-title="Contact"><span class="glyphicon glyphicon-comment  contact"></span></a>
				</li>
			</ul>
		</div>
			</div>
		<div class="col-md-8"></div>
		<h1>Cheqout</h1>
		<p>A catchy description about our stuff</p>
		<?php require_once("loginform.php"); ?>
		<p id="loginOutput" class="alert pull-left"></p>
	</div>

<script>
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>

