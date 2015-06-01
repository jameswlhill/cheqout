<?php
require_once("../lib/utilities.php");
?>

<div class="jumbotron">
	<div class="container">
		<h1>CAPSTEEEEEWN (Cheqout)</h1>
		<p>A catchy description about our figurines</p>
		<form class="form-inline" id="login" method="post" action="../lib/loginvalidate.php">
			<div class="form-group">
				<input type="email" class="form-control" id="email" name="email" placeholder="your@email.here">
			</div>
			<div class="form-group">
				<input type="password" class="form-control" id="password" name="password" placeholder="Password">
			</div>
			<button type="submit" class="btn btn-default">Login</button>
		</form>
		</div>
	</div>
</div>