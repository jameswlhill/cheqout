<?php
$PAGE_TITLE = "About - Cheqout";

if ($_POST["submit"]) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];
	$from = 'Cheqout Contact Form';
	$to = 'ouremailaddress@cheqout.com';
	$subject = 'Comment on Cheqout';
	$body = "From: $name\n E-Mail: $email\n Message:\n $message";

	// Check if name has been entered
	if(!$_POST['name']) {
		$errName = 'Please enter your name';
	}
// Check if email has been entered and is valid
	if(!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$errEmail = 'Please enter a valid email address';
	}
//Check if message has been entered
	if(!$_POST['message']) {
		$errMessage = 'Please enter your message';
	}

	// If there are no errors, send the email
	if(!$errName && !$errEmail && !$errMessage) {
		if(mail($to, $subject, $body, $from)) {
			$result = '<div class="alert alert-success">Thank you for your message!</div>';
		} else {
			$result = '<div class="alert alert-danger">Sorry there was an error sending your message. Please try again.</div>';
		}
	}
}
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

		<div class="span8" id="divMain">

			<h1>Contact Us</h1>
			<hr>
			<!--Start Contact form -->
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
			<form class="form-horizontal" role="form" method="post" action="index.php">
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">Name</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="name" name="name" placeholder="First & Last Name" value="<?php echo htmlspecialchars($_POST['name']); ?>">
						<?php echo "<p class='text-danger'>$errName</p>";?>
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="<?php echo htmlspecialchars($_POST['email']); ?>">
						<?php echo "<p class='text-danger'>$errEmail</p>";?>
					</div>
				</div>
				<div class="form-group">
					<label for="message" class="col-sm-2 control-label">Message</label>
					<div class="col-sm-10">
						<textarea class="form-control" rows="4" name="message"><?php echo htmlspecialchars($_POST['message']);?></textarea>
						<?php echo "<p class='text-danger'>$errMessage</p>";?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-10 col-sm-offset-2">
						<input id="submit" name="submit" type="submit" value="Send" class="btn btn-default">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-10 col-sm-offset-2">
						<?php echo $result; ?>
					</div>
				</div>
			</form>
			<!--End Contact form -->

			<!--About us portion-->
		</div>
		<div class="span4 sidebar">
		<div class="sidebox">
			<h3 class="sidebox-title">About Us</h3>
			<p>
				I'm gonna build me an airport, put my name on it. Why, Michael? So you can fly away from your feelings? That
				coat costs more than your house! Michael was concerned that he was caught in a lie about his family. The
				family was concerned that they were being confronted by a woman they had clubbed, drugged, and left on a
				bench. Whoa whoa whoa whoa. Wait. Are you telling me you have a multi-stage trick with hidden identities? I
				thought the two of us could talk man-on-man. But I'm the oldest. The matriarch if you will. Do you guys know
				where I could get one of those gold necklaces with the T on it? That's a cross. Across from where?
				</p>
			<!-- end about us -->
		</div>
	</div>