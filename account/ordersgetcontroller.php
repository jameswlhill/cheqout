<?php
require_once (dirname(__DIR__)) . "/php/class/autoload.php";
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
if(@isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
}
if(@isset($_SESSION["account"])) {
	$account = $_SESSION["account"];
}
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
try {
	if(@isset($email) === false && (@isset($account)) === false) {
		throw(new InvalidArgumentException("You aren't logged in!"));
	}
} catch(Exception $exception) {
	echo '<p class="alert alert-danger">Exception: ' . $exception->getMessage() . '</p>';
}

$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
// fill in an array with the order based on the order's ID only
$orderArray = Email::getOrdersByEmail($pdo, $email->getEmailId());
		try {
			$lastOrder = null;
			foreach($orderArray as $list) {
				if($list[1] === $lastOrder) goto end;
				echo '<div class="container">';
				echo '<div class="row">';
				echo '<div class="col-md-3 text-info">Date of Purchase</div>';
				echo '<div class="col-md-3 text-info">Order Total</div>';
				echo '<div class="col-md-3 text-info">Shipped To</div>';
				echo '<div class="col-md-3 text-info">Order Number</div>';
				echo '</div>';
				echo '<div class="row">';
				echo '<div class="col-md-3">' . $list[15] . '</div>';         //purchase datetime
				echo '<div class="col-md-3">' . $list[7] . '</div>';            //order total
				echo '<div class="col-md-3">';                                 //if we have a label, Label@Name
				if(@isset($list[9]) === true && $list[9] !== null) {   //if not, just the name
					echo $list[8] . '@' . $list[9];
				} else echo $list[8];
				echo '</div>';
				echo '<div class="col-md-3">' . $list[1] . '</div>';            //finally, the order number
				echo '</div>';
				echo '</div>';
				end:
				$lastOrder = $list[1];
		}
		}catch(Exception $exception) {
			echo '<p class="alert alert-danger">Exception: ' . $exception->getMessage() . '</p>';
		}

/*
*  The graveyard. Where code comes to die.
*/

//				if($orderArray[$tracker][1] !== $orderArray[$tracker2][1]) {
//					echo '<div class="row">';
//					echo '<div class="col-md-6">';
//					echo '<p class="text-info">Shipping Address</p>';
//					echo $list[9] . '</p><p>' . //label
//						$list[8] . '</p><p>' . //attention
//						$list[10] . '</p><p>' . //street1
//						$list[11] . '</p><p>' . //street2
//						$list[12] . '</p><p>' . //city
//						$list[13] . '</p><p>' . //state
//						$list[14] . '</p><p>';  //zip
//					echo '<p class="text-info">Order</p>';
//					echo $list[1] . '</p><p>' .  //order id
//						$list[15] . '</p><p>'; //order date/time
//					echo '<p class="text-info">Order Total</p>';
//					echo $list[7] . '</p><p>'; //order total
//					echo '</div>';
//				}

//			echo '<div class="row">';
//			echo '<div class="col-md-6 pull-left">';
//			echo '<div class="text-info">Shipping Address</p>';
//			echo $orderArray[0][9] . '</p><p>' . //label
//				$orderArray[0][8] . '</p><p>' . //attention
//				$orderArray[0][10] . '</p><p>' . //street1
//				$orderArray[0][11] . '</p><p>' . //street2
//				$orderArray[0][12] . '</p><p>' . //city
//				$orderArray[0][13] . '</p><p>' . //state
//				$orderArray[0][14] . '</p><p>';  //zip
//			echo '<p class="text-info">Order</p>';
//			echo $orderArray[0][1] . '</p><p>' .  //order id
//				$orderArray[0][15] . '</p><p>'; //order date/time
//			echo '<p class="text-info">Order Total</p>';
//			echo $orderArray[0][7] . '</p><p>'; //order total
//			echo '</div>';


//				echo '<p class="text-info">Product</p>';
//				echo $list[4] . '</p><p>' .   //product name
//					$list[2] . '</p><p>' .   //quantity
//					$list[5] . '</p><p>';   //price total
//				echo '</div>';

//	<th>Email Address</th>0
//<th>Order ID</th>1
//th>Quantity</th>2
//th>Product ID</th>3
//th>Product Title</th>4
//Price (quantity*sale)</th>5
//Shipping Cost</th>6
//Order Total</th>7
//Attention</th>8
//Label</th>9
//Street 1</th>10
//Street 2</th>11
//City</th>12
//State</th>13
//Zip 14
//Time of Order 15
?>