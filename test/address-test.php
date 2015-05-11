<?php
// grab the project test parameters
require_once("cheqouttest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/class/address.php");
require_once(dirname(__DIR__) . "/php/class/email.php");


/**
 * Full PHPUnit test for the Address class
 *
 * This is a complete PHPUnit test of the Address class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Address
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 **/
class AddressTest extends CheqoutTest {
	/**
	 * valid addressLabel to use
	 * @var string $VALID_LABEL
	 **/
	protected $VALID_LABEL = "Work";

	/**
	 * valid addressAttention to use
	 * @var string $VALID_ATTENTION
	 **/
	protected $VALID_ATTENTION = "Douglas";

	/**
	 * valid addressStreet1 to use
	 * @var string $VALID_STREET1
	 **/
	protected $VALID_STREET1 = "123 Stupid Street Way";

	/**
	 * valid addressStreet2 to use
	 * @var string $VALID_STREET2
	 **/
	protected $VALID_STREET2 = "Apartment Number 29";

	/**
	 * valid addressStreet2 to use
	 * @var string $VALID_CITY
	 **/
	protected $VALID_CITY = "Los Santos";

	/**
	 * valid addressState to use
	 * @var string $VALID_STATE
	 **/
	protected $VALID_STATE = "CA";

	/**
	 * valid addressZip to use
	 * @var string $VALID_ZIP
	 **/
	protected $VALID_ZIP = "23478-4598";

	/**
	 * valid addressStreet2 to use
	 * @var string $VALID_STREET2
	 **/
	protected $VALID_HIDDEN = 2;

	/**
	 * Email that created the Address; this is for foreign key relations
	 * make 5 of them to test the methods!
	 * @var Address address
	 **/
	protected $email1 = null;
	protected $email2 = null;
	protected $email3 = null;
	protected $email4 = null;
	protected $email5 = null;


	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// though we are making ANOTHER setup, run the first setup first
		parent::setUp();
		// create and insert a email to own the test address
		$this->email1 = new Email(null, "phpunittest1@phpunittester.com", "stripeID1");
		$this->email1->insert($this->getPDO());
		$this->email2 = new Email(null, "phpunittest2@phpunittester.com", "stripeID2");
		$this->email2->insert($this->getPDO());
		$this->email3 = new Email(null, "phpunittest3@phpunittester.com", "stripeID3");
		$this->email3->insert($this->getPDO());
		$this->email4 = new Email(null, "phpunittest4@phpunittester.com", "stripeID4");
		$this->email4->insert($this->getPDO());
		$this->email5 = new Email(null, "phpunittest5@phpunittester.com", "stripeID4");
		$this->email5->insert($this->getPDO());
	}
	/**
	 * test inserting a valid Address and verify that the actual mySQL data matches
	 **/
	public function testInsertValidAddress() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("address");

		// create a new Address and insert to into mySQL
		$address = new Address(null, $this->email1->getEmailId(), $this->VALID_ATTENTION, $this->VALID_STREET1,
									  $this->VALID_CITY, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_STREET2,
									  $this->VALID_LABEL, $this->VALID_HIDDEN);
		$address->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAddress = Address::getAddressByAddressId($this->getPDO(), $address->getAddressId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("address"));
		$this->assertSame($pdoAddress->getAddressAttention(), $this->VALID_ATTENTION);
		$this->assertSame($pdoAddress->getAddressStreet1(), $this->VALID_STREET1);
		$this->assertSame($pdoAddress->getAddressStreet1(), $this->VALID_STREET2);
		$this->assertSame($pdoAddress->getAddressCity(), $this->VALID_CITY);
		$this->assertSame($pdoAddress->getAddressState(), $this->VALID_STATE);
		$this->assertSame($pdoAddress->getAddressZip(), $this->VALID_ZIP);
		$this->assertSame($pdoAddress->getAddressLabel(), $this->VALID_LABEL);
		$this->assertSame($pdoAddress->getAddressHidden(), $this->VALID_HIDDEN);
	}


	/**
	 * test userDelete on a Address that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidAddress() {
		// create an Address then try to use the userDelete function to hide the address
		// from the user, simulating a deletion
		$address = new Address(null, $this->email2->getEmailId(), $this->VALID_ATTENTION, $this->VALID_STREET1,
									  $this->VALID_CITY, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_STREET2,
									  $this->VALID_LABEL, $this->VALID_HIDDEN);
		$address->userDelete($this->getPDO());
		$pdoAddress = Address::getAddressByAddressId($this->getPDO(), $address->getAddressHidden());
		$this->assertSame($pdoAddress->getAddressHidden(), $address->getAddressHidden());
	}

	/**
	 * test creating an Address and then adminDelete it
	 **/
	public function testDeleteValidAddress() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("address");

		// create a new Address and insert to into mySQL
		$address = new Address(null, $this->email3->getEmailId(), $this->VALID_ATTENTION, $this->VALID_STREET1,
									  $this->VALID_CITY, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_STREET2,
									  $this->VALID_LABEL, $this->VALID_HIDDEN);
		$address->insert($this->getPDO());

		// delete the Address from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("address"));
		$address->adminDelete($this->getPDO());

		// grab the data from mySQL and enforce the Address does not exist
		$pdoAddress = Address::getAddressByAddressId($this->getPDO(), $address->getAddressId());
		$this->assertNull($pdoAddress);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("address"));
	}

	/**
	 * test adminDelete a Address that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testAdminDeleteInvalidAddress() {
		// create a Address and try to delete it without actually inserting it
		$address = new Address(null, $this->email4->getEmailId(), $this->VALID_ATTENTION, $this->VALID_STREET1,
									  $this->VALID_CITY, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_STREET2,
									  $this->VALID_LABEL, $this->VALID_HIDDEN);
		$address->adminDelete($this->getPDO());
	}

	/**
	 * test inserting a Address and regrabbing it from mySQL
	 **/
	public function testGetValidAddressByAddressId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("address");

		// create a new Address and insert to into mySQL
		$address = new Address(null, $this->email5->getEmailId(), $this->VALID_ATTENTION, $this->VALID_STREET1,
									  $this->VALID_CITY, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_STREET2,
									  $this->VALID_LABEL, $this->VALID_HIDDEN);
		$address->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAddress = Address::getAddressByAddressId($this->getPDO(), $address->getAddressId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("address"));
		$this->assertSame($pdoAddress->getAddressAttention(), $this->VALID_ATTENTION);
		$this->assertSame($pdoAddress->getAddressStreet1(), $this->VALID_STREET1);
		$this->assertSame($pdoAddress->getAddressStreet1(), $this->VALID_STREET2);
		$this->assertSame($pdoAddress->getAddressCity(), $this->VALID_CITY);
		$this->assertSame($pdoAddress->getAddressState(), $this->VALID_STATE);
		$this->assertSame($pdoAddress->getAddressZip(), $this->VALID_ZIP);
		$this->assertSame($pdoAddress->getAddressLabel(), $this->VALID_LABEL);
		$this->assertSame($pdoAddress->getAddressHidden(), $this->VALID_HIDDEN);

	}

	/**
	 * test grabbing a Address that does not exist
	 **/
	public function testGetInvalidAddressByAddressId() {
		// grab a address id that exceeds the maximum allowable address id
		$address = Address::getAddressByAddressId($this->getPDO(), CheqoutTest::INVALID_KEY);
		$this->assertNull($address);
	}

	/**
	 * test grabbing a Address that does not exist
	 **/
	public function testGetInvalidAddressByEmailId() {
		// grab a address id that exceeds the maximum allowable address id
		$address = Address::getAddressByEmailId($this->getPDO(), CheqoutTest::INVALID_KEY);
		$this->assertNull($address);
	}

}
?>