<?php
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
$PAGE_TITLE = "My Account - Cheqout";
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
if(@isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
}
if(@isset($_SESSION["account"])) {
	$email = $_SESSION["account"];
}
require_once("../lib/utilities.php");
?>

		<section class="side-panel col-md-3">
			<?php require_once("../lib/sidebar.php"); ?>
		</section>
			<header>
				<?php require_once("../lib/header.php"); ?>
			</header>

<div class="container">

	<div class="row">

			<button class="btn btn-primary" data-toggle="collapse" data-target="#updateaddress" aria-expanded="false" aria-controls="updateaddress">
				Update Address
			</button>

			<button class="btn btn-primary" data-toggle="collapse" data-target="#changepassword" aria-expanded="false" aria-controls="changepassword">
				Change Password
			</button>

			<button class="btn btn-primary" data-toggle="collapse" data-target="#changeemail" aria-expanded="false" aria-controls="changeemail">
				Change Email
			</button>

			<button class="btn btn-primary" data-toggle="collapse" data-target="#pastorders" aria-expanded="false" aria-controls="pastorders">
				Past Orders
			</button>

			<div class="row">
				<div class="collapse" id="changeemail">
					<div class="well">
						CHANGE EMAIL GOES HERE
					</div>
				</div>

			<div class="collapse" id="pastorders">
				<div class="well">
					<?php require_once("ordersgetcontroller.php"); ?>
				</div>
			</div>

			<div class="collapse" id="updateaddress">
				<div class="well">
					<div class="container">
						<?php require_once("addressgetcontroller.php"); ?>
					</div>

					<hr />

					<?php require_once("addressform.php"); ?>
				</div>
			</div>

			<div class="collapse" id="changepassword">
				<div class="well">
					CHANGE PASSWORD GOES HERE
				</div>
			</div>
		</div>
	</div>
</div>
