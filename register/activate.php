<?php
//activation page the emailed url will redirect to
$PAGE_TITLE = "Activation - Cheqout";
require_once("../lib/utilities.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once(dirname(__DIR__)) . "/php/class/autoload.php";
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
if(@isset($_SESSION["email"])) {
	$email = $_SESSION["email"];
}
if(@isset($_SESSION["account"])) {
	$account = $_SESSION["account"];
}
?>

<header>
	<?php require_once("../lib/header.php"); ?>
</header>

<?php
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
$emailId = Account::getEmailIdByActivation($pdo, $_GET["activation"]);
$query = "UPDATE account SET activation = null WHERE emailId = :emailId";
$statement = $pdo->prepare($query);

$parameters = array("emailId" => $emailId);
$statement->execute($parameters);
$testActivation = Account::getAccountByEmailId($pdo, $email->getEmailId());
$testActivation = $testActivation->getActivation();
if($testActivation === null) {
	echo '<div class="container"><p class="success">Your account has been successfully activated, thank you!</p></div>';
}
else {
		echo '<div class="container"><p class="warning"><strong>Uh oh!</strong> We were unable to activate your account.</p></div>';
	}
?>