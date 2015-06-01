<?php
require_once("../lib/utilities.php");
?>

<div class="jumbotron">
	<div class="container">
		<h1>CAPSTEEEEEWN (Cheqout)</h1>
		<p>A catchy description about our figurines</p>
<!--		<div>-->
<!--			<form id="login" method="post" action="../lib/loginvalidate.php">-->
<!--				<input name="email" type="text" placeholder="Email Address" maxlength="128">-->
<!--				<input name="password" type="password" placeholder="Password" maxlength="128">-->
<!--				<input type="submit" name="login" value="Login">-->
<!--			</form>-->
<!--		</div>-->
		<div class="container-fluid col-md-6"
			<form id="login" method="post" action="../lib/loginvalidate.php">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon">Email:</span>
						<input type="text" class="form-control">
						<span class="input-group-addon">Password:</span>
						<input type="password" class="form-control">
						<span class="input-group-btn">
				<button class="btn btn-default" type="button">Login</button>
			 </span>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>