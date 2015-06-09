<?php
$PAGE_TITLE = "Contact - Cheqout";
require_once("../lib/utilities.php");
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>

<header>
	<?php require_once("../lib/header.php"); ?>
</header>

	<div class="container-fluid acont">
		<div class="content-wrapper">
			<div class="container-fluid acont contact col-md-6">
			<h2>Contact Us</h2>
			<hr>
			<!--Start Contact form -->
			<form id="contact" action="contact.php" method="post" role="form">
				<div class="form-group">
					<label for="name">Name:</label>
					<input type="text" id="name" maxlength="50" name="name" placeholder="First & Last Name" class="form-control">
				</div>
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="email" id="email" maxlength="256" name="email" placeholder="your@email.here" class="form-control">
				</div>
				<div class="form-group">
					<label for="message" id="message">Message:</label>
					<textarea id="message" rows="6" name="message" required="" class="form-control" placeholder="Your message here"></textarea>
				</div>
				<div>
					<button class="btn btn-primary" type="submit" name="submit">Submit</button>
				</div>
			</form>
			</div>
			<div class="container-fluid acont col-md-6">
				<h2>About Us</h2>
				<hr>
					<p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising
						pain was born and I will give you a complete account of the system, and expound the actual
						teachings of the great explorer of the truth, the master-builder of human happiness. No one
						rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who
						do not know how to pursue pleasure rationally encounter consequences that are extremely painful.
						Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it
						is pain, but because occasionally circumstances occur in which toil and pain can procure him some
						great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise,
						except to obtain some advantage from it? But who has any right to find fault with a man who chooses
						to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no
						resultant pleasure?</p>
		</div>
	</div>
	</div>