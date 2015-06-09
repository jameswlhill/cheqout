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

<!--Search Bar-->
<div class="row">
	<div class="col-md-4 col-md-offset-4">
			<form id='searchSubmit' action="../controllers/jsoncontroller.php" method="get">
			<div class="input-group pull-right">
				<input class="form-control" type="text" size="30" name="search" id="search" placeholder="search our products">
					<span class="input-group-btn">
						<button class="btn btn-success btn-md" id="searchSubmit" type="submit">Search</button>
					</span>
			</div>
		</form>
	</div>
</div>
	<div class="row">
		<div class="container">
			<div id="output"></div>
		</div>
	</div>
<!--Shop Title-->
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Shop
					<small>Books galore!</small>
					</h1>
			</div>
		</div>

			<!-- products Row 1 -->
			<div class="page" id="page1">
			<div class="row">
				<div class="col-md-4 portfolio-item">
						<img class="img-responsive book" src="../img/product/hagakure.jpg" alt="hagakure">
					<div class="row">
						<div class="col-md-6">
							<h3>
								The Hagakure
							</h3>
							<p>Bushido philosophy</p>
							<p class="price">$10.99</p>
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
									<button type="submit" class="btn btn-success btn-sm add" data-toggle="modal" data-target="#myModal">
										<i class="glyphicon glyphicon-flash"></i>Add To Cart
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 portfolio-item">
						<img class="img-responsive book" src="../img/product/plato.jpg" alt="plato">
					<div class="row">
						<div class="col-md-6">
							<h3>
								Plato's Republic
							</h3>
							<p>A dialogue on an ideal society</p>
							<p class="price">$11.99</p>
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
									<button type="submit" class="btn btn-success btn-sm add" data-toggle="modal" data-target="#myModal">
										<i class="glyphicon glyphicon-flash"></i>Add To Cart
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 portfolio-item">
						<img class="img-responsive book" src="../img/product/nietzsche.jpg" alt="beyond good and evil">
					<div class="row">
						<div class="col-md-6">
							<h3>
								Beyond Good and Evil
							</h3>
							<p>Leaving dogmatism behind</p>
							<p class="price">$11.99</p>
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
									<button type="submit" class="btn btn-success btn-sm add" data-toggle="modal" data-target="#myModal">
										<i class="glyphicon glyphicon-flash"></i>Add To Cart
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

<!--				Products Row 2-->
			<div class="row">
				<div class="col-md-4 portfolio-item">
						<img class="img-responsive book" src="../img/product/conics.jpg" alt="conics">
					<div class="row">
						<div class="col-md-6">
							<h3>
								Conics
							</h3>
							<p>Treatise on conic sections</p>
							<p class="price">$7.99</p>
						</div>
						<div class="col-md-6">
							<div class="container">
								<form class="add" method="post" action="../controllers/cartcontroller.php">
									<input type="hidden" id="productId" name="productId" value="4" />
									<?php echo generateInputTags(); ?>
									<label for="quantity">
										Quantity:
										<input type="number" id="quantity" name="quantity" min="0" step="1" value="1" class="form-control" />
									</label>
									<button type="submit" class="btn btn-success btn-sm add" data-toggle="modal" data-target="#myModal">
										<i class="glyphicon glyphicon-flash"></i>Add To Cart
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 portfolio-item">
						<img class="img-responsive book" src="../img/product/theory.jpg" alt="theory">
					<div class="row">
						<div class="col-md-6">
							<h3>
								Theory of Numbers
							</h3>
							<p>Study of the infinite and infinitesimal</p>
							<p class="price">$1.99</p>
						</div>
						<div class="col-md-6">
							<div class="container">
								<form class="add" method="post" action="../controllers/cartcontroller.php">
									<input type="hidden" id="productId" name="productId" value="5" />
									<?php echo generateInputTags(); ?>
									<label for="quantity">
										Quantity:
										<input type="number" id="quantity" name="quantity" min="0" step="1" value="1" class="form-control" />
									</label>
									<button type="submit" class="btn btn-success btn-sm add" data-toggle="modal" data-target="#myModal">
										<i class="glyphicon glyphicon-flash"></i>Add To Cart
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 portfolio-item">
						<img class="img-responsive book" src="../img/product/minkowski.jpg" alt="minkowski">
					<div class="row">
						<div class="col-md-6">
							<h3>
								Minkowski's Space and Time
							</h3>
							<p>Intro to four-dimensional spacetime</p>
							<p class="price">$8.99</p>
						</div>
						<div class="col-md-6">
							<div class="container">
								<form class="add" method="post" action="../controllers/cartcontroller.php">
									<input type="hidden" id="productId" name="productId" value="6" />
									<?php echo generateInputTags(); ?>
									<label for="quantity">
										Quantity:
										<input type="number" id="quantity" name="quantity" min="0" step="1" value="1" class="form-control" />
									</label>
									<button type="submit" class="btn btn-success btn-sm add" data-toggle="modal" data-target="#myModal">
										<i class="glyphicon glyphicon-flash"></i>Add To Cart
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Products Row 3 -->
			<div class="row">
				<div class="col-md-4 portfolio-item">
						<img class="img-responsive book" src="../img/product/prince.jpg" alt="the prince">
					<div class="row">
						<div class="col-md-6">
							<h3>
								The Prince
							</h3>
							<p>Do unto others before they do unto you</p>
							<p class="price">$15.99</p>
						</div>
						<div class="col-md-6">
							<div class="container">
								<form class="add" method="post" action="../controllers/cartcontroller.php">
									<input type="hidden" id="productId" name="productId" value="7" />
									<?php echo generateInputTags(); ?>
									<label for="quantity">
										Quantity:
										<input type="number" id="quantity" name="quantity" min="0" step="1" value="1" class="form-control" />
									</label>
									<button type="submit" class="btn btn-success btn-sm add" data-toggle="modal" data-target="#myModal">
										<i class="glyphicon glyphicon-flash"></i>Add To Cart
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 portfolio-item">
						<img class="img-responsive book" src="../img/product/federalist.jpg" alt="federalist papers">
					<div class="row">
						<div class="col-md-6">
							<h3>
								The Federalist Papers
							</h3>
							<p>Discussions on the US Constitution</p>
							<p class="price">$10.99</p>
						</div>
						<div class="col-md-6">
							<div class="container">
								<form class="add" method="post" action="../controllers/cartcontroller.php">
									<input type="hidden" id="productId" name="productId" value="8" />
									<?php echo generateInputTags(); ?>
									<label for="quantity">
										Quantity:
										<input type="number" id="quantity" name="quantity" min="0" step="1" value="1" class="form-control" />
									</label>
									<button type="submit" class="btn btn-success btn-sm add" data-toggle="modal" data-target="#myModal">
										<i class="glyphicon glyphicon-flash"></i>Add To Cart
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 portfolio-item">
						<img class="img-responsive book" src="../img/product/dumal.jpg" alt="les fleurs du mal">
					<div class="row">
						<div class="col-md-6">
							<h3>
								Les Fleurs du Mal
							</h3>
							<p>"An insult to public decency"</p>
							<p class="price">$12.69</p>
						</div>
						<div class="col-md-6">
							<div class="container">
								<form class="add" method="post" action="../controllers/cartcontroller.php">
									<input type="hidden" id="productId" name="productId" value="9" />
									<?php echo generateInputTags(); ?>
									<label for="quantity">
										Quantity:
										<input type="number" id="quantity" name="quantity" min="0" step="1" value="1" class="form-control" />
									</label>
									<button type="submit" class="btn btn-success btn-sm add" data-toggle="modal" data-target="#myModal">
										<i class="glyphicon glyphicon-flash"></i>Add To Cart
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
			<!-- End Product page-->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Successfully added to cart!</h4>
			</div>
			<div class="modal-body">
				Good job!
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal">Okey Dokey</button>
			</div>
		</div>
	</div>
</div>

		<!-- /.container -->
		<script type="text/javascript" src="../controllers/addtocart.js"></script>
