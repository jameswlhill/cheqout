<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
require_once("../lib/utilities.php");
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
if(@isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
} else {
	$email = null;
}
if(@isset($_SESSION["account"])) {
	$email = $_SESSION["account"];
} else {
	$account = null;
}

if(@isset($email) === true) {
	echo '<a href="../lib/logout.php" class="btn btn-primary form-inline pull-left">Logout</a>';
} else {
	echo '<form class="form-inline" id="login" method="post" action="../lib/loginvalidate.php">
	<div class="form-group">
		<input type="email" class="form-control" id="email" name="email" placeholder="your@email.here">
	</div>
	<div class="form-group">
		<input type="password" class="form-control" id="password" name="password" placeholder="Password">
	</div>
	<button type="submit" class="btn btn-primary">Login</button>';
}

echo '</form><p id="loginOutput"></p>';