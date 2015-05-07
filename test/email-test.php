<?php
//requires the AES 256 functions
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

//load the account class
require_once("../php/email.php");

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

	//insert new email address into sql
	$email = new email (null, "its@yu.com", "ermagerdstripeid");
	$email->insert($pdo);

	//update an email address in mysql
	$email->setEmailAddress("diemf@dmfd.com");
	$email->setStripeId("the coolest customer");
	$email->update($pdo);

	//select an email
	$pdoName = Email::getEmailByEmailAddress($pdo, $email->getEmailAddress());

	//delete the email from mySQL and show that it is gone
	$email->delete($pdo);
	$pdoName = Email::getEmailByEmailAddress($pdo, $email->getEmailAddress());

} catch (PDOException $pdoException) {
	echo "Exception: " . $pdoException->getMessage();
}
?>