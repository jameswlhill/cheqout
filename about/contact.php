<?php
require_once("../about/index.php");

//if the form has been submitted
if(isset($_POST['submit'])) {
	//check if name has been entered
	if($_POST['name'] === null) {
		throw (new InvalidArgumentException('Please enter your first and last name'));
	}
// Check if email has been entered and is valid
	if(!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === true) {
		throw (new InvalidArgumentException('Please enter a valid email address'));
	}
//Check if message has been entered
	if(!isset($_POST['message'])) {
		throw (new InvalidArgumentException('Please enter a message'));
	}

	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];

	$from = 'Cheqout Contact Form';
	$to = 'kylacarroll43@gmail.com';
	$subject = 'Comment on Cheqout';
	$body = "From: $name\n E-Mail: $email\n Message:\n $message";

	mail($to, $subject, $body, $from);
}
?>