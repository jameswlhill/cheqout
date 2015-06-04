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
						<img class="img-responsive" src="http://upload.wikimedia.org/wikipedia/en/3/36/Hagakure.jpg" alt="hagakure">
					</a>
					<div class="row">
						<div class="col-md-6">
							<h3>
								<a href="#">The Hagakure</a>
							</h3>
							<p>Bushido philosophy</p>
							<p class="price">$10.30</p>
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
						<img class="img-responsive" src="data:image/jpeg;base64,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" alt="placeholder">
					</a>
					<div class="row">
						<div class="col-md-6">
							<h3>
								<a href="#">Plato's Republic</a>
							</h3>
							<p>A dialogue on an ideal society</p>
							<p class="price">$11.20</p>
						</div>
						<div class="col-md-6">
							<div class="container">
								<form class="add" method="post" action="../controllers/cartcontroller.php">
									<input type="hidden" id="productId" name="productId" value="2" />
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
						<img class="img-responsive" src="data:image/jpeg;base64,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" alt="beyond good and evil">
					</a>
					<div class="row">
						<div class="col-md-6">
							<h3>
								<a href="#">Beyond Good and Evil</a>
							</h3>
							<p>Leaving dogmatism behind</p>
							<p class="price">$11.10</p>
						</div>
						<div class="col-md-6">
							<div class="container">
								<form class="add" method="post" action="../controllers/cartcontroller.php">
									<input type="hidden" id="productId" name="productId" value="3" />
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