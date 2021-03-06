<?php
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
$PAGE_TITLE = "Change Email - Cheqout";
// go into the database and grab their email object
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
if(@isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
}
if(@isset($_SESSION["account"])) {
	$account = $_SESSION["account"];
}
if(!isset($_SESSION["email"])) {
	header("Location: ../register/index.php");
}
if($account->getActivation() === null) {
	$_SESSION['notification'] = 'You have not requested an email change.';
	header("Location: ../account/index.php");
}
require_once("../lib/utilities.php");
?>

<header>
	<?php require_once("../lib/header.php"); ?>
</header>

<div class="container-fluid">
	<h3>Change your email</h3>
	<div class="container">
		<form class="form-inline" id="emailchange" method="post" action="updateemail.php">
			<input type="hidden" name="emailchange" value="<?php echo $_GET["emailchange"]; ?>"/>
			<input type="email" class="form-control" id="newemail" name="newemail" placeholder="your@new.email">
			<input type="email" class="form-control" id="emailcheck" name="emailcheck" placeholder="Retype Email">
			<button type="submit" name="submit" class="btn btn-primary">Change Email</button>
		</form>
		<p id="emailOutputArea"></p>
	</div>
</div>
