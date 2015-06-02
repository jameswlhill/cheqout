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
		<form id='register' action='register.php' method='post' accept-charset='UTF-8'>
				<label for='email' >Email Address*:</label>
					<input type='text' name='email' id='email' maxlength="256" /><br />
				<label for='password' >Password*:</label>
					<input type='password' name='password' id='password' maxlength="128" /><br />
				<label for='password2' >Retype Password*:</label>
					<input type='password' name='password2' id='password2' maxlength="128" /><br />
				<input type='submit' name='Submit' value='Submit' />
			</form>
		Your current password is <span class="text-info">not going to be displayed.</span>
		<form class="form-horizontal" id="passwordchangeemail" method='POST' action="../formsnippets/passwordchangeemail.php">
			<div class="row"><div class="col-xs-4 col-xs-offset-3 col-md-4 col-md-offset-2"><input id="passwordchangeemail" type="submit" value="Change Password"></div>
		</form>
		<p id="registerOutput"></p>
	</div>
</div>
