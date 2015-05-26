<?php
$PAGE_TITLE = "About - Cheqout";
require_once("../lib/utilities.php");

//if the form has been submitted
if(isset($_POST['submit'])) {
	//check if name has been entered
	if(!$_POST['name']) {
		throw (new InvalidArgumentException('Please enter your first and last name'));
	}
// Check if email has been entered and is valid
	if(!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === true) {
		throw (new InvalidArgumentException('Please enter a valid email address'));
	}
//Check if message has been entered
	if(!$_POST['message']) {
		throw (new InvalidArgumentException('Please enter a message'));
	}

	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];

	$from = 'Cheqout Contact Form';
	$to = 'ouremailaddress@cheqout.com';
	$subject = 'Comment on Cheqout';
	$body = "From: $name\n E-Mail: $email\n Message:\n $message";

	mail($to, $subject, $body, $from);
}
?>

<div class="row">
	<section class="side-panel col-md-3">
		<?php require_once("../lib/sidebar.php"); ?>
	</section>
	<div class="container">
		<header>
			<?php require_once("../lib/header.php"); ?>
		</header>

		<div class="col-md-8" id="divMain">

			<h2>Contact Us</h2>
			<hr>
			<!--Start Contact form -->
			<form id="contact" action="index.php" method="post">
				<div>
					<label for="name">Name:</label>
					<input type="text" id="name" maxlength="50" placeholder="First & Last Name">
				</div>
				<div>
					<label for="email">Email:</label>
					<input type="email" id="email" maxlength="256" placeholder="example@domain.com">
				</div>
				<div>
					<label for="message" id="message">Message:</label>
						<textarea id="message" minlength="50" rows="6" required="">Your message here</textarea>
				</div>
				<div>
					<button type="submit" name="submit">Submit</button>
				</div>
			</form>
		</div>
			<!--End Contact form -->
					<!--About us portion-->
		<div class="col-md-4 sidebar">
		<div class="sidebox">
			<h3 class="sidebox-title">About Us</h3>
			<p>I'm gonna build me an airport, put my name on it. Why, Michael? So you can fly away from your feelings? That
				coat costs more than your house! Michael was concerned that he was caught in a lie about his family. The
				family was concerned that they were being confronted by a woman they had clubbed, drugged, and left on a
				bench. Whoa whoa whoa whoa. Wait. Are you telling me you have a multi-stage trick with hidden identities? I
				thought the two of us could talk man-on-man. But I'm the oldest. The matriarch if you will. Do you guys know
				where I could get one of those gold necklaces with the T on it? That's a cross. Across from where?</p>
		</div>
	</div>