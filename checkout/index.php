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
	$emailAddress = $email->getEmailAddress();
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
		data-key="<?php echo 'pk_test_u7pqTkqPAABpBYtvqDLMPdlD'; ?>"
		data-image="<?php echo 'linktothepicofthefirstiteminthecartORALOGO'; ?>"
		data-name="Cheqout"
		data-description="The Cheq-outiest!"
		data-zip-code="true"
		data-amount="<?php echo 'dollars in DDCC with no periods'; ?>">
	</script>
</form>