<?php
//requires the AES 256 functions
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

//load the account class
require_once(dirname(__DIR__) . '/php/class/account.php');

try {
	//read and decrypt the configuration array
	$config = readConfig("/etc/apache2/capstone-mysql/cheqout.ini");

	//create a data connection string(dsn) and specify the login credentials
	$dsn = "mysql:host=" . $config["hostname"] . ";dbname=" . $config["database"];

	//enable UTF-8 text handling
	$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

	//connect to mySQL via PDO
	$pdo = new PDO($dsn, $config["username"], $config["password"], $options);

	//have PDO throw exceptions when possible
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//insert new account into sql
	$account = new Account(145, "password1", "omgpassword1", "FJGITKASLDFKMN", "04-22-20 15:45:36", 56786);
	$account->insert($pdo);

	//update an account in mysql
	$account->setAccountId(4343);
	$account->setAccountPassword("newhashedpassword");
	$account->setAccountPasswordSalt("newsaltystring");
	$account->setActivation("newactivationcode");
	$account->setAccountCreateDateTime("the new today");
	$account->setEmailId(98765);
	$account->update($pdo);

	//select an account by emailId
	$pdoName = Account::getAccountByEmailId($pdo, $account->getEmailId());

	//delete the email from mySQL and show that it is gone
	$account->delete($pdo);
	$pdoName = Account::getAccountByEmailId($pdo, $account->getEmailId());

} catch (PDOException $pdoException) {
	echo "Exception: " . $pdoException->getMessage();
}
?>