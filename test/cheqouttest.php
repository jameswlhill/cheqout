<?php
// grab the encrypted properties file
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

/**
 * Abstract class containing universal and cheqout-specific mySQL parameters
 *
 * This class is designed to lay the foundation of the unit tests for the Cheqout project. It loads the all the database
 * parameters about the project so that table specific tests can share the parameters in on place. To use it:
 *
 * @author James Hill <james@appists.com>
 **/
abstract class CheqoutTest extends PHPUnit_Extensions_Database_TestCase {

}