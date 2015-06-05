<?php
$PAGE_TITLE = "Register - Cheqout";
require_once("../lib/utilities.php");
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>

<header>
	<?php require_once("../lib/header.php"); ?>
</header>

	<div class="container-fluid">
		<h2>Register with Cheqout</h2>
		<form id='register' action='register.php' role="form" method='post' accept-charset='UTF-8'>
			<div class="form-group">
				<input type='email' name='email' id='email' maxlength="128" placeholder="your@email.here"/>
			</div>
			<div class="form-group">
				<input type='password' name='password' id='password' maxlength="128" placeholder="Password" />
			</div>
			<div class="form-group">
				<input type='password' name='password2' id='password2' maxlength="128" placeholder="Retype Password"/>
			</div>
				<input type='submit' name='Submit' value='Submit' class="btn btn-primary pull-left" />
			<span class="col-md-6" id="registerOutput"></span>
		</form>
	</div>

