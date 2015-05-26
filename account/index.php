<?php
$PAGE_TITLE = "My Account - Cheqout";
require_once("../lib/utilities.php");
?>


	<div class="row">
		<section class="side-panel col-md-3">
			<?php require_once("../lib/sidebar.php"); ?>
		</section>
		<div class="container">
			<header>
				<?php require_once("../lib/header.php"); ?>
			</header>

<div class="container">
	<div class="row">
		<div class="col-md-5  toppad  pull-right col-md-offset-3 ">
			<a href="../formsnippets/accountupdateform.php" >Edit Profile</a>

			<a href="../lib/logout.php" >Logout</a>
			<br>
			<p class=" text-info">May 05,2014,03:00 pm </p>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >


			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Name</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=100" class="img-circle"> </div>

						<div class=" col-md-9 col-lg-9 ">
							<table class="table table-user-information">
								<tbody>
									<tr>
										<td>Join date:</td>
										<td>06/23/2013</td>
									</tr>
									<tr>
										<td>Past Orders</td>
										<td><a href="../orders/index.php">#</a></td>
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

							<a href="#" class="btn btn-default">Update Address</a>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>