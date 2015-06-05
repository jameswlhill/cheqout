<?php
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
$PAGE_TITLE = "Change Password - Cheqout";
// go into the database and grab their email object
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
if(@isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
}
if(@isset($_SESSION["account"])) {
	$account = $_SESSION["account"];
}
require_once("../lib/utilities.php");
?>

<header>
	<?php require_once("../lib/header.php"); ?>
</header>

<div class="container-fluid">
	<h3>Change your password</h3>
	<div class="container">
		<form class="form-inline" id="passwordchange" method="post" action="updatepassword.php">
			<input type="hidden" name="passwordchange" value="<?php echo $_GET["passwordchange"]; ?>" />
			<input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New Password">
			<input type="password" class="form-control" id="passwordcheck" name="passwordcheck" placeholder="Retype Password">
			<button type="submit" name="submit" class="btn btn-primary">Change Password</button>
		</form>
		<p id="passwordChangeOutputArea"></p>
	</div>
</div>