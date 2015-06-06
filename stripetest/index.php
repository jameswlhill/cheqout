<?php
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
$PAGE_TITLE = "My Account - Cheqout";
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
if(@isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
}
if(@isset($_SESSION["account"])) {
	$account = $_SESSION["account"];
}
require_once("../stripe-php-2.2.0/init.php");
require_once("../lib/utilities.php");
?>

<form action="/charge" method="POST">
	<script
		src="https://checkout.stripe.com/checkout.js" class="stripe-button"
		data-key="<?php echo ''; ?>"
		data-image="/img/documentation/checkout/marketplace.png"
		data-name="Cheqout"
		data-description="2 widgets"
		data-zip-code="true"
		data-amount="2000">
	</script>
</form>