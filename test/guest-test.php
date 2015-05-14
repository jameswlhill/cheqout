<?php
// grab the project test parameters
require_once("cheqouttest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/class/guest.php");
require_once(dirname(__DIR__) . "/php/class/email.php");


/**
 * Full PHPUnit test for the Guest class
 *
 * This is a complete PHPUnit test of the Guest class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Guest
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 **/
class GuestTest extends CheqoutTest {
	/**
	 * EmailId that created the Guest; this is for foreign key relations
	 * @var Address address
	 **/
	protected $VALID_EMAIL = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// though we are making ANOTHER setup, run the first setup first
		parent::setUp();
		// create and insert a email to own the test address
		$this->VALID_EMAIL = new Email(null, "phpunittest@phpunittester.com", "stripeID");
		$this->VALID_EMAIL->insert($this->getPDO());
		return;
	}
	/**
	 * test inserting a valid guest and verify that the actual mySQL data matches
	 **/
	public function testInsertValidGuest() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("guest");

		// create a new Address and insert to into mySQL
		$guest = new Guest(null, $this->VALID_EMAIL->getEmailId());
		$guest->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoGuest = Guest::getGuestIdByEmailId($this->getPDO(), $guest->getEmailId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("guest"));
		$this->assertSame($pdoGuest->getGuestId(), $guest->getGuestId());
	}
}
?>