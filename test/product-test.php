<?php
/**
 * Test for product.php
 *
 * Loads product.php, connects to MySQL database,
 * instantiates a new Product object via the class' constructor magic method,
 * inserts that Product object into database,
 * updates the Product object in the database,
 * selects/reads the Product database entry,
 * and finally, deletes that Product entry from the database
 *
 * @author James Hill <james@appists.com>
 **/
//first, require the system library AES 256 functions
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

//load product.php, class to be tested
require_once('../product.php');

try {
	//readConfig reads/decrypts the config array, can throw exception so should be put in trycatch block
	$config = readConfig("/etc/apache2/capstone-mysql/cheqout.ini");

//create a data connection string and specify user credentials
	$dsn = "mysql:host=" . $config["hostname"] . ";dbname=" . $config["database"];

//enable UTF-8 text handling
	$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

//connect to MySQL via PDO
	$pdo = new PDO($dsn, $config["username"], $config["password"], $options);

//have PDO throw exceptions whenever possible
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//instantiate a new Product object via constructor
	$product = new Product(null, "Cyborg Cheney", 7.99, "evil Dick", 200, 1);
	echo $product;

} catch(PDOException $pdoException) {
	var_dump($pdoException);
	echo "Exception: " . $pdoException->getMessage();
}