<?php
function generateLoginContainer($email) {
	if(@isset($email) === true) {
		echo '<a href="../lib/logout.php" class="btn btn-primary form-inline pull-right">Logout</a>';
	} else {
		echo '<form class="form-inline" id="login" method="post" action="../lib/loginvalidate.php">
	<div class="form-group">
		<input type="email" class="form-control" id="email" name="email" placeholder="your@email.here">
	</div>
	<div class="form-group">
		<input type="password" class="form-control" id="password" name="password" placeholder="Password">
	</div>
	<button type="submit" class="btn btn-primary">Login</button>';
	}
	echo '</form>';
}