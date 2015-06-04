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
	$account = $_SESSION["account"];
}
if(!isset($_SESSION["email"])) {
	header("Location: ../register/index.php");
}
require_once("../lib/utilities.php");
?>

<header>
	<?php require_once("../lib/header.php"); ?>
</header>

<div class="container">
	<div class="row">
		<div class="accordion" id="update">
			<div class="accordion-group changers">
			<button class="btn btn-primary openpanel1 closepanel1" data-toggle="collapse" data-parent="#update" aria-expanded="false">
				Update Address
			</button>

			<button class="btn btn-primary openpanel2 closepanel2" data-toggle="collapse" data-parent="#update" aria-expanded="false">
				Change Password
			</button>

			<button class="btn btn-primary openpanel3 closepanel3" data-toggle="collapse" data-parent="#update" aria-expanded="false">
				Change Email
			</button>

			<button class="btn btn-primary openpanel4 closepanel4" data-toggle="collapse" data-parent="#update" aria-expanded="false">
				Past Orders
			</button>
		</div>

				<div class="row">

					<div class="panel">
						<div class="panel-collapse collapse" id="panel1">
							<?php require_once("addressgetcontroller.php"); ?>
								<hr />
							<?php require_once("addressform.php"); ?>
						</div>
					</div>

					<div class="panel">
						<div class="panel-collapse collapse" id="panel2">
							<p>Your current password is <span class="text-info">not going to be displayed.</span></p>
							<p>To select a new password, you must enter your current password and verify your email:</p>
							<form class="form-inline" id="passwordchangeemail" method="post" action="passwordchangeemail.php">
								<input type="password" class="form-control" id="password" name="password" placeholder="Password">
								<button type="submit" class="btn btn-primary">Send Email</button>
								<p id="passwordOutputArea"></p>
							</form>
						</div>
					</div>

					<div class="panel">
						<div class="panel-collapse collapse" id="panel3">
							<p>Your current email is <span class="text-info"><?php echo $_SESSION["email"]->getEmailAddress() ?></span></p>
							<p>To change your email, you must enter your password:</p>
							<form class="form-inline" id="emailchangeemail" method="post" action="../account/emailchangeemail.php">
								<input type="password" class="form-control" id="emailpassword" name="password" placeholder="Password">
								<button type="submit" class="btn btn-primary">Send Email</button>
								<p id="emailOutputArea"></p>
							</form>
						</div>
					</div>

					<div class="panel">
						<div class="panel-collapse collapse" id="panel4">
							<?php require_once("ordersgetcontroller.php"); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
