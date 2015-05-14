<?php
// grab the encrypted properties file
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

/**
 * Abstract class containing universal and cheqout-specific mySQL parameters
 *
 * This class is designed to lay the foundation of the unit tests for the Cheqout project. It loads the all the database
 * parameters about the project so that table specific tests can share the parameters in on place. To use it:
 *
 * @author Dylan McDonald <dmcdonald21@cnm.edu> and customized for Cheqout by James Hill <james@appists.com>
 **/
abstract class CheqoutTest extends PHPUnit_Extensions_Database_TestCase {
	/**
	 * invalid id to use for an INT UNSIGNED field (maximum allowed INT UNSIGNED in mySQL) + 1
	 * @see https://dev.mysql.com/doc/refman/5.6/en/integer-types.html mySQL Integer Types
	 * @var int INVALID_KEY
	 **/
	const INVALID_KEY = 4294967296;
	const INVALID_STRING = "qqqqqqqqq1wwwwwwwww2eeeeeeeee3rrrrrrrrr4tttttttt5yyyyyyyyy6uuuuuuuuu7iiiiiiiii8ooooooooo9ppppppppp0qqqqqqqqq1wwwwwwwww2eeeeeeeee3";

	/**
	 * PHPUnit database connection interface
	 * @var PHPUnit_Extensions_Database_DB_IDatabaseConnection $connection
	 **/
	protected $connection = null;

	/**
	 * assembles the table from the schema and provides it to PHPUnit
	 *
	 * @return PHPUnit_Extensions_Database_DataSet_QueryDataSet assembled schema for PHPUnit
	 **/
	public final function getDataSet() {
		$dataset = new PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());

		// add all the tables for the project
		$dataset->addTable("email");
		$dataset->addTable("account");
		$dataset->addTable("guest");
		$dataset->addTable("address");
		$dataset->addTable("product");
		$dataset->addTable("cheqoutOrder");
		$dataset->addTable("productOrder");
		return($dataset);
	}

	/**
	 * templates the setUp method that runs before each test; this method expunges the database before each run
	 *
	 * @see https://phpunit.de/manual/current/en/fixtures.html#fixtures.more-setup-than-teardown PHPUnit Fixtures: setUp and tearDown
	 * @see https://github.com/sebastianbergmann/dbunit/issues/37 TRUNCATE fails on tables which have foreign key constraints
	 * @return PHPUnit_Extensions_Database_Operation_Composite array containing delete and insert commands
	 **/
	public final function getSetUpOperation() {
		return new PHPUnit_Extensions_Database_Operation_Composite(array(
			PHPUnit_Extensions_Database_Operation_Factory::DELETE_ALL(),
			PHPUnit_Extensions_Database_Operation_Factory::INSERT()
		));
	}

	/**
	 * templates the tearDown method that runs after each test; this method expunges the database after each run
	 *
	 * @return PHPUnit_Extensions_Database_Operation_IDatabaseOperation delete command for the database
	 **/
	public final function getTearDownOperation() {
		return(PHPUnit_Extensions_Database_Operation_Factory::DELETE_ALL());
	}

	/**
	 * sets up the database connection and provides it to PHPUnit
	 *
	 * @see <https://phpunit.de/manual/current/en/database.html#database.configuration-of-a-phpunit-database-testcase>
	 * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection PHPUnit database connection interface
	 **/
	public final function getConnection() {
		// if the connection hasn't been established, create it
		if($this->connection === null) {
			// grab the encrypted mySQL properties file and create the DSN
			$config = readConfig("/etc/apache2/capstone-mysql/cheqout.ini");
			$dsn = "mysql:host=" . $config["hostname"] . ";dbname=" . $config["database"];
			$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

			// provide the interface to PHPUnit
			$pdo = new PDO($dsn, $config["username"], $config["password"], $options);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->connection = $this->createDefaultDBConnection($pdo, $config["database"]);
		}
		return($this->connection);
	}

	/**
	 * returns the actual PDO object; this is a convenience method
	 *
	 * @return PDO active PDO object
	 **/
	public final function getPDO() {
		return($this->getConnection()->getConnection());
	}
}