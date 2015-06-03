<?php
$PAGE_TITLE = "Home - Cheqout";
require_once("../lib/utilities.php");
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>
<body class="full">
	<header>
		<?php require_once("../lib/header.php"); ?>
	</header>
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
