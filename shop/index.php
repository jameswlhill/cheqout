<?php
$PAGE_TITLE = "Shop - Cheqout";
require_once(dirname(__DIR__) . "/lib/csrfver.php");
require_once(dirname(__DIR__) . "/lib/utilities.php");
require_once(dirname(__DIR__) . "/php/class/autoload.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>

<header>
	<?php require_once("../lib/header.php"); ?>
</header>


			<!-- Page Header -->
			<div class="container">
			<div class="row">

				<div class="col-lg-12">
					<h1 class="page-header">Shop
						<small>'Til your heart explodes</small>
					</h1>
				</div>
			</div>

			<!-- /.row -->
				<button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
					Categories
				</button>
				<div class="collapse" id="collapseExample">
					<div class="well">
						<a href="#">Celebrity</a> |
						<a href="#">Topical</a> |
						<a href="#">Political</a>
					</div>
				</div>
				<hr>
			<!-- Projects Row -->

			<div class="row">
				<div class="col-md-4 portfolio-item">
					<a href="#">
						<img class="img-responsive" src="//theuglytruth.files.wordpress.com/2011/09/evilcheney.jpg?w=472&h=375" alt="placeholder">
					</a>
					<div class="row">
						<div class="col-md-6">
							<h3>
								<a href="#">Product 1</a>
							</h3>
							<p>Our first product</p>
							<p class="price">$1</p>
						</div>
						<div class="col-md-6">
							<div class="container">
								<form class="add" method="post" action="../controllers/cartcontroller.php">
									<input type="hidden" id="productId" name="productId" value="1" />
									<?php echo generateInputTags(); ?>
									<label for="quantity">
										Quantity:
										<input type="number" id="quantity" name="quantity" min="0" step="1" value="1" class="form-control" />
									</label>
									<button type="submit" class="btn btn-success btn-sm add">
										<i class="glyphicon glyphicon-flash"></i>Add To Cart
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 portfolio-item">
					<a href="#">
						<img class="img-responsive" src="http://placekitten.com/g/700/400" alt="placeholder">
					</a>
					<div class="row">
						<div class="col-md-6">
							<h3>
								<a href="#">Item Name</a>
							</h3>
							<p>Short description....</p>
							<p class="price">$12</p>
						</div>
						<div class="col-md-6">
							<div class="container">
								<button type="button" class="btn btn-success btn-xs add">
									<label for="add" class="btn"><i class="glyphicon glyphicon-flash"></i>Add To Cart</label>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 portfolio-item">
					<a href="#">
						<img class="img-responsive" src="http://placekitten.com/g/700/400" alt="placeholder">
					</a>
					<div class="row">
						<div class="col-md-6">
							<h3>
								<a href="#">Item Name</a>
							</h3>
							<p>Short description....</p>
							<p class="price">$12</p>
						</div>
						<div class="col-md-6">
							<div class="container">
								<button type="button" class="btn btn-success btn-xs add">
									<label for="add" class="btn"><i class="glyphicon glyphicon-flash"></i>Add To Cart</label>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /.row -->

			<!-- Projects Row -->
			<div class="row">
				<div class="col-md-4 portfolio-item">
					<a href="#">
						<img class="img-responsive" src="http://placekitten.com/g/700/400" alt="placeholder">
					</a>
					<div class="row">
						<div class="col-md-6">
							<h3>
								<a href="#">Item Name</a>
							</h3>
							<p>Short description....</p>
							<p class="price">$12</p>
						</div>
						<div class="col-md-6">
							<div class="container">
							<button type="button" class="btn btn-success btn-xs add">
								<label for="add" class="btn"><i class="glyphicon glyphicon-flash"></i>Add To Cart</label>
							</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 portfolio-item">
					<a href="#">
						<img class="img-responsive" src="http://placekitten.com/g/700/400" alt="placeholder">
					</a>
					<div class="row">
						<div class="col-md-6">
							<h3>
								<a href="#">Item Name</a>
							</h3>
							<p>Short description....</p>
							<p class="price">$12</p>
						</div>
						<div class="col-md-6">
							<div class="container">
								<button type="button" class="btn btn-success btn-xs add">
									<label for="add" class="btn"><i class="glyphicon glyphicon-flash"></i>Add To Cart</label>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 portfolio-item">
					<a href="#">
						<img class="img-responsive" src="http://placekitten.com/g/700/400" alt="placeholder">
					</a>
					<div class="row">
						<div class="col-md-6">
							<h3>
								<a href="#">Item Name</a>
							</h3>
							<p>Short description....</p>
							<p class="price">$12</p>
						</div>
						<div class="col-md-6">
							<div class="container">
								<button type="button" class="btn btn-success btn-xs add">
									<label for="add" class="btn"><i class="glyphicon glyphicon-flash"></i>Add To Cart</label>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Projects Row -->
			<div class="row">
				<div class="col-md-4 portfolio-item">
					<a href="#">
						<img class="img-responsive" src="http://placekitten.com/g/700/400" alt="placeholder">
					</a>
					<div class="row">
						<div class="col-md-6">
							<h3>
								<a href="#">Item Name</a>
							</h3>
							<p>Short description....</p>
							<p class="price">$12</p>
						</div>
						<div class="col-md-6">
							<div class="container">
								<button type="button" class="btn btn-success btn-xs add">
									<label for="add" class="btn"><i class="glyphicon glyphicon-flash"></i>Add To Cart</label>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 portfolio-item">
					<a href="#">
						<img class="img-responsive" src="http://placekitten.com/g/700/400" alt="placeholder">
					</a>
					<div class="row">
						<div class="col-md-6">
							<h3>
								<a href="#">Item Name</a>
							</h3>
							<p>Short description....</p>
							<p class="price">$12</p>
						</div>
						<div class="col-md-6">
							<div class="container">
								<button type="button" class="btn btn-success btn-xs add">
									<label for="add" class="btn"><i class="glyphicon glyphicon-flash"></i>Add To Cart</label>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 portfolio-item">
					<a href="#">
						<img class="img-responsive" src="http://placekitten.com/g/700/400" alt="placeholder">
					</a>
					<div class="row">
						<div class="col-md-6">
							<h3>
								<a href="#">Item Name</a>
							</h3>
							<p>Short description....</p>
							<p class="price">$12</p>
						</div>
						<div class="col-md-6">
							<div class="container">
								<button type="button" class="btn btn-success btn-xs add">
									<label for="add" class="btn"><i class="glyphicon glyphicon-flash"></i>Add To Cart</label>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /.row -->

			<hr>

			<!-- Pagination -->
			<div class="row text-center">
				<div class="col-lg-12">
					<ul class="pagination">
						<li>
							<a href="#">&laquo;</a>
						</li>
						<li class="active">
							<a href="#">1</a>
						</li>
						<li>
							<a href="#">2</a>
						</li>
						<li>
							<a href="#">3</a>
						</li>
						<li>
							<a href="#">&raquo;</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
			<!-- /.row -->

			<hr>


		<!-- /.container -->
		<script type="text/javascript" src="../controllers/addtocart.js"></script>

	</body>

</html>