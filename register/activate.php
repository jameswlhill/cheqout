<?php
//activation page the emailed url will redirect to
$PAGE_TITLE = "Activated - Cheqout";
require_once("../lib/utilities.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once("../php/class/account.php");

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

echo '<div class="container"><p class="success">Your account has been successfully activated, thank you!</p></div>'
?>