<?php
require_once (dirname(__DIR__)) . "/php/class/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once("addressminiformgenerator.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
if(@isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
}
if(@isset($_SESSION["account"])) {
	$account = $_SESSION["account"];
}
try {
	if(@isset($email)	=== false) {
		if(@isset($_SESSION["emailAddress"]) === true) {
			echo 'Your email address is set to <span class="text-info">' . $_SESSION["emailAddress"] . '</span>.';
		} else {
			echo '<form class="form-inline" id="unregisteredEmail" method="post" action="../account/unregisteredemail.php">
					<input type="email" class="form-control" id="unregisteredEmail" name="unregisteredEmail" placeholder="your@email.here">
					<button type="submit" class="btn btn-primary">Use this Email</button>
					<p id="emailOutputArea"></p>
				</form>';
		}
	}
	if(@isset($account) === false) {
		require_once("addressguestform.php");
	}

	if((@isset($email)	=== true) && (@isset($account) === true)) {
		$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
		// fill in an array with the order based on the order's ID only
		$orderArray = Address::getAddressesByEmailId($pdo, $email->getEmailId());
		if(is_array($orderArray[0]) === true) {
			$i = 0;
			echo '<div class="container">';
			echo '<div class="row">';

			foreach($orderArray as $list) {
				if(intval($list[9]) !== 1 && (is_array($list)) === true) {
					if($i % 2 == 0) {
						echo '</div><div class="row">';
					}
					addressMiniFormGenerator($list[0], $list[8], $list[2], $list[3]);
					$i++;
				}
			}
			echo '</div>';
			echo '</div>';
		}
	}
} catch(Exception $exception) {
	echo 'Exception: ' . $exception->getMessage();
}
?>