<?php
$PAGE_TITLE = "Register - Cheqout";
require_once("../lib/utilities.php");
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>

<div class="row">
	<section class="side-panel col-md-3">
		<?php require_once("../lib/sidebar.php"); ?>
	</section>
	<header>
		<?php require_once("../lib/header.php"); ?>
	</header>

	<div class="container">
		<h2>Register with Cheqout</h2>
		<form id='register' action='register.php' role="form" method='post' accept-charset='UTF-8'>
			<div class="form-group">
				<label for='email'></label>
				<input type='text' name='email' id='email' maxlength="128" placeholder="your@email.here"/>
			</div>
			<div class="form-group">
				<label for='password'></label>
				<input type='password' name='password' id='password' maxlength="128" placeholder="Password" />
			</div>
			<div class="form-group">
				<label for='password2'></label>
				<input type='password' name='password2' id='password2' maxlength="128" placeholder="Retype Password"/>
			</div>
				<input type='submit' name='Submit' value='Submit' class="btn btn-primary" />
		</form>
		<p id="registerOutput"></p>
	</div>
</div>
