<?php
require_once (dirname(__DIR__)) . "/php/class/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once ("addressformgenerator.php");
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
	if(@isset($email)	=== false && (@isset($account)) === false) {
		throw(new InvalidArgumentException("You aren't logged in!"));
	}
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
	// fill in an array with the order based on the order's ID only
	$orderArray = Address::getAddressesByEmailId($pdo, $email->getEmailId());
	if(is_array($orderArray[0]) === true) {
//		echo '<div class="row">';
	foreach($orderArray as $list) {
		getAddressForm()
//			if($list[9] !== 1) {
//				echo '<div class="col-md-4 col-sm-6">';
//				echo '<p><strong>' .
//					$list[8] . '</strong><a href="#" class="btn btn-success pull-right">
//														<span class="glyphicon glyphicon-pencil"></span>
//													</a>
//													<a href="#" class="btn btn-danger pull-right">
//														<span class="glyphicon glyphicon-remove"></span>
//													</a>
//						</p><p>' .
//					$list[2] . '</p><p>' .
//					$list[3] . '</p><p>' .
//					$list[7] . '</p><p>' .
//					$list[4] . '</p><p>' .
//					$list[5] . '</p><p>' .
//					$list[6];
//				echo '</div>';
//			}
		}
//		echo '</div>';
	}

}catch(Exception $exception) {
	echo "<p class=\"alert alert-danger\">Exception: " . $exception->getMessage() . "</p>";
}
?>