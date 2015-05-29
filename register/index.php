<?php
$PAGE_TITLE = "Register - Cheqout";
require_once("../lib/utilities.php");
?>

<div class="row">
	<section class="side-panel col-md-3">
		<?php require_once("../lib/sidebar.php"); ?>
	</section>
	<header>
		<?php require_once("../lib/header.php"); ?>
	</header>

<form id='register' action='../lib/register.php' method='post' accept-charset='UTF-8'>
	<label for='email' >Email Address*:</label>
	<input type='text' name='email' id='email' maxlength="256" />
	<label for='password' >Password*:</label>
	<input type='password' name='password' id='password' maxlength="128" />
	<label for='password2' >Retype Password*:</label>
	<input type='text' name='password2' id='password2' maxlength="128" />
	<input type='submit' name='Submit' value='Submit' />
</form>
</body>
</html>