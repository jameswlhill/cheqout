<?php
/**
 * Test for address.php
 *
 * Loads address.php, connects to MySQL database,
 * instantiates a new Address object via the class' constructor magic method,
 * inserts that Address object into database,
 * updates the Address object in the database,
 * selects/reads the Address database entry,
 * update the Address to be hidden
 * and finally, deletes that Product entry from the database
 *
 * @author Tyler Wiegand <tyler dot wiegand at me dot com>
 **/
//first, require the system library AES 256 functions
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

//load product.php, class to be tested
require_once('../address.php');

try {
	$config = readConfig("/etc/apache2/capstone-mysql/cheqout.ini");
	$dsn = "mysql:host=" . $config["hostname"] . ";dbname=" . $config["database"];
	$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
	$pdoConnection = new PDO($dsn, $config["username"], $config["password"], $options);
	$pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//create a new Product object
	$address = new Address(null, "Work", "Dudes Name", "234 Wilco Way",
								  "Albuquerque", "NM", "89734-8745");
	echo $address;









	//insert $address into the database!
	$address->insert($pdoConnection);
	echo $address;

	//user hides their address and adds a new one (simulate edit address)
	$address->userDelete($pdoConnection);
	echo $address;
	$address->userDelete($pdoConnection);
	echo $address;

} catch(PDOException $pdoException) {
	var_dump($pdoException);
	echo "Exception: " . $pdoException->getMessage();
}