<?php
session_start();
$PAGE_TITLE = "My Account - Cheqout";
require_once("../lib/utilities.php");
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");

if(@isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
}
if(@isset($_SESSION["acount"])) {
	$email = $_SESSION["account"];
}
?>

		<section class="side-panel col-md-3">
			<?php require_once("../lib/sidebar.php"); ?>
		</section>
			<header>
				<?php require_once("../lib/header.php"); ?>
			</header>

<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-offset-1 col-lg-8 toppad" >
			<a class="pull-right" href="../lib/logout.php" >Logout</a>
				<form class="form-horizontal">
					<fieldset>
					<legend>Account Information</legend>
						<div class="form-group">
							<label class="col-lg-2 control-label">Join date: <?php $account->getAccountCreateDateTime()?></label>
						</div>
										<td>06/23/2013</td>
									</tr>
									<tr>
										<td>Past Orders</td>
										<td><a href="../orders/index.php">Here</a></td>
									</tr>

									<tr>
										<td>Default Address</td>
										<td>Label</td>
									</tr>
									<tr>
										<td>Email</td>
										<td>theiremail@me.com</td>
									</tr>
								</tbody>
							</table>
						<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#updateaddress" aria-expanded="false" aria-controls="updateaddress">
							Update Address
						</button>
						<div class="collapse" id="updateaddress">
							<div class="well">
								ADDRESS UPDATE GOES HERE
							</div>
						</div>
						<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#changepassword" aria-expanded="false" aria-controls="updateaddress">
							Change Password
						</button>
						<div class="collapse" id="changepassword">
							<div class="well">
								CHANGE PASSWORD GOES HERE
							</div>
						</div>
						<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#changeemail" aria-expanded="false" aria-controls="changemail">
							Change Email
						</button>
						<div class="collapse" id="changemail">
							<div class="well">
								CHANGE EMAIL GOES HERE
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>