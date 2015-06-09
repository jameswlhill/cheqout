<?php
$PAGE_TITLE = "About - Cheqout";
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
					<textarea id="message" minlength="50" rows="6" name="message" required="" class="form-control" placeholder="Your message here"></textarea>
				</div>
				<div>
					<button class="btn btn-primary" type="submit" name="submit">Submit</button>
				</div>
			</form>
			</div>
			<div class="container-fluid acont col-md-6">
				<h2>About Us</h2>
				<hr>
					<p>I'm gonna build me an airport, put my name on it. Why, Michael? So you can fly away from your feelings? That
						coat costs more than your house! Michael was concerned that he was caught in a lie about his family. The
						family was concerned that they were being confronted by a woman they had clubbed, drugged, and left on a
						bench. Whoa whoa whoa whoa. Wait. Are you telling me you have a multi-stage trick with hidden identities? I
						thought the two of us could talk man-on-man. But I'm the oldest. The matriarch if you will. Do you guys know
						where I could get one of those gold necklaces with the T on it? That's a cross. Across from where?</p>
		</div>
	</div>
	</div>