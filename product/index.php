<?php
$PAGE_TITLE = "Shop - Cheqout";
require_once("../lib/utilities.php");
?>

			<div class="row">
				<section class="side-panel col-md-3">
					<?php require_once("../lib/sidebar.php"); ?>
				</section>
					<header>
						<?php require_once("../lib/header.php"); ?>
					</header>
				<div class="container">
		<div class="container-fluid">
			<div class="content-wrapper">
				<div class="item-container">
					<div class="container">
						<div class="col-md-12">
							<div class="product col-md-3 service-image-left">
									<img id="item-display" src="http://www.placekitten.com/g/240/360" alt="product image placeholder" />
							</div>
						<div class="col-md-7">
							<div class="product-title">Product Title</div>
							<div class="product-desc">This is a short product description</div>
							<hr>
							<div class="product-price">$ 1234.00</div>
							<div class="product-stock">In Stock</div>
							<hr>
							<div class="btn-group cart">
								<button type="button" class="btn btn-success">
									Add to cart
								</button>
								<div class="quantity">
								<form action="#" class="quantity quantity-form">Quantity: <input type="text" placeholder="1"></form>
									</div>

							</div>
							</div>
						</div>
					</div>
					</div>
				</div>
				<div class="container-fluid">
					<div class="col-md-12 product-info">
						<ul id="myTab" class="nav nav-tabs nav_tabs">

							<li class="active"><a href="#service-one" data-toggle="tab">DESCRIPTION</a></li>
							<li><a href="#service-two" data-toggle="tab">PRODUCT INFO</a></li>
							<li><a href="#service-three" data-toggle="tab">RELATED</a></li>

						</ul>
						<div id="myTabContent" class="tab-content nav-stacked">
							<div class="tab-pane fade in active" id="service-one">
								<section class="container description">
										We live in a space ship, dear. Welcome to the nancy tribe. One of my personalities
										happens to be a multiple personality, but that doesn't make me a multiple personality.
										With any luck, he'll poke the wrong one and end up in an alternative dimension inhabited
										by a fifty-foot Giles that squishes annoying teeny pirates. The human mind is like Van
										Halen; if you just pull out one piece and keep replacing it, it just degenerates. Little
										man loved fire. Oh my god! Did it sing? Bunnies! Bunnies! It must be Bunnies! I wanna hurt
										you, but I can't resist the sinister attraction of your cold and muscular body!
								</section>
							</div>

							<div class="tab-pane fade" id="service-two">

								<section class="container product-info">
									Instead of seeing the rug being pulled from under us, we can learn to dance on a shifting
									carpet. There is a time for departure even when there is no certain place to go. He who has
									begun his task has half done it. First we form habits, then they form us. Conquer your bad
									habits, or they will eventually conquer you. Everything comes to him who hustles while he
									waits. Nothing determines who we will become so much as those things we choose to ignore.
								</section>

							</div>
								<div class="tab-pane fade" id="service-three">
									<section class="container related">
										Do not play for safety; it is the most dangerous thing in the world. If you are not fired
										with enthusiasm, you will be fired with enthusiasm. The first two letters of the word goal
										spell go. If you have a lemon, make lemonade. The difference between doers and dreamers is
										that the latter wait for the mood before taking action while the former create the mood by
										acting. This Saturday, do something you have wanted to do for years. Something just for
										yourself. And repeat this process once every month. The man who is waiting for something
										to turn up might start on his shirt sleeves. Quit now, you will never make it. If you
										disregard this advice, you will be halfway there.
									</section>
								</div>
						</div>
						<hr>
					</div>
				</div>
			</div>
				</div>
				</div>
	</body>
</html>