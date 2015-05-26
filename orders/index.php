<?php
$PAGE_TITLE = "Order History - Cheqout";
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

<div class="panel panel-default panel-order">
	<div class="panel-heading">
		<strong>Order history</strong>
		<div class="btn-group pull-right">
			<div class="btn-group">
				<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
					Filter history <i class="fa fa-filter"></i>
				</button>
				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="#">Approved orders</a></li>
					<li><a href="#">Pending orders</a></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="panel-body">
		<div class="row">
			<div class="col-md-11">
				<div class="row">
					<div class="col-md-12">
						<div class="pull-right"><label class="label label-danger">rejected</label> </div>
						<span><strong>Order name</strong></span> <span class="label label-info">group name</span><br>
						Quantity : 2, cost: $323.13 <br>
						<a data-placement="top" class="btn btn-success btn-xs glyphicon glyphicon-ok" href="#" title="View"></a>
						<a data-placement="top" class="btn btn-danger  btn-xs glyphicon glyphicon-trash" href="#" title="Danger"></a>
						<a data-placement="top" class="btn btn-info  btn-xs glyphicon glyphicon-usd" href="#" title="Danger"></a>
					</div>
					<div class="col-md-12">
						order made on: 05/31/2014 by <a href="#">Jane Doe </a>
					</div>
				</div>
			</div>
		</div>
<hr>
		<div class="row">
			<div class="col-md-11">
				<div class="row">
					<div class="col-md-12">
						<div class="pull-right"><label class="label label-info">pending</label> </div>
						<span><strong>Order name</strong></span> <span class="label label-info">group name</span><br>
						Quantity : 12, cost: $12623.13<br>
						<a data-placement="top" class="btn btn-success btn-xs glyphicon glyphicon-ok" href="#" title="View"></a>
						<a data-placement="top" class="btn btn-danger  btn-xs glyphicon glyphicon-trash" href="#" title="Danger"></a>
						<a data-placement="top" class="btn btn-info  btn-xs glyphicon glyphicon-usd" href="#" title="Danger"></a>
					</div>
					<div class="col-md-12">
						order made on: 06/12/2014 by <a href="#">Jane Doe </a>
					</div>
				</div>
			</div>
		</div>
<hr>
		<div class="row">
			<div class="col-md-11">
				<div class="row">
					<div class="col-md-12">
						<div class="pull-right"><label class="label label-success">Approved</label> </div>
						<span><strong>Order name</strong></span> <span class="label label-info">group name</span><br>
						Quantity : 4, cost: $523.13<br>
						<a data-placement="top" class="btn btn-success btn-xs glyphicon glyphicon-ok" href="#" title="View"></a>
						<a data-placement="top" class="btn btn-danger  btn-xs glyphicon glyphicon-trash" href="#" title="Danger"></a>
						<a data-placement="top" class="btn btn-info  btn-xs glyphicon glyphicon-usd" href="#" title="Danger"></a>
					</div>
					<div class="col-md-12">
						order made on: 06/20/2014 by <a href="#">Jane Doe</a>
					</div>
				</div>
			</div>
		</div>
<hr>
		<div class="row">
			<div class="col-md-11">
				<div class="row">
					<div class="col-md-12">
						<div class="pull-right"><label class="label label-info">pending</label> </div>
						<span><strong>Order name</strong></span> <span class="label label-info">group name</span><br>
						Quantity : 4, cost: $523.13<br>
						<a data-placement="top" class="btn btn-success btn-xs glyphicon glyphicon-ok" href="#" title="View"></a>
						<a data-placement="top" class="btn btn-danger  btn-xs glyphicon glyphicon-trash" href="#" title="Danger"></a>
						<a data-placement="top" class="btn btn-info  btn-xs glyphicon glyphicon-usd" href="#" title="Danger"></a>
					</div>
					<div class="col-md-12">
						order made on: 06/20/2014 by <a href="#">Jane Doe</a>
					</div>
				</div>
			</div>
		</div