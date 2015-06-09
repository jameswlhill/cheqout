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
	<div class="col-md-4">
		<h2>Register with Cheqout</h2>
		<form id='register' class="form-group" action='register.php' role="form" method='post' accept-charset='UTF-8'>
<!--			<div class="form-group">-->
<!--				<input type='email' name='email' id='email' maxlength="128" placeholder="your@email.here"/>-->
<!--			</div>-->
			<div class="form-group row">
				<label for="email"></label>
				<input type="email" id="email" maxlength="128" name="email" placeholder="your@email.here" class="form-control">
			</div>
<!--			<div class="form-group">-->
<!--				<input type='password' name='password' id='password' maxlength="128" placeholder="Password" />-->
<!--			</div>-->
			<div class="form-group row">
				<label for="password"></label>
				<input type="password" id="password" maxlength="128" name="password" placeholder="Password" class="form-control">
			</div>
<!--			<div class="form-group">-->
<!--				<input type='password' name='password2' id='password2' maxlength="128" placeholder="Retype Password"/>-->
<!--			</div>-->
			<div class="form-group row">
				<label for="password2"></label>
				<input type="password" id="password2" maxlength="128" name="password2" placeholder="Retype Password" class="form-control">
			</div>
				<input type='submit' name='Submit' value='Submit' class="btn btn-primary pull-right" />
			<span class="col-md-6" id="registerOutput"></span>
		</form>
	</div>
</div>
