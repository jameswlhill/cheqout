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
	protected $VALID_HIDDEN = 0;

	/**
	 * Email that created the Address; this is for foreign key relations
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
	 * test inserting a valid Address and verify that the actual mySQL data matches
	 **/
	public function testInsertValidAddress() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("address");

		// create a new Address and insert to into mySQL
		$address = new Address(null, $this->VALID_EMAIL->getEmailId(), $this->VALID_ATTENTION, $this->VALID_STREET1,
									  $this->VALID_CITY, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_STREET2,
									  $this->VALID_LABEL, $this->VALID_HIDDEN);
		$address->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAddress = Address::getAddressByAddressId($this->getPDO(), $address->getAddressId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("address"));
		$this->assertSame($pdoAddress->getAddressStreet2(), $this->VALID_STREET2);
		$this->assertSame($pdoAddress->getAddressCity(), $this->VALID_CITY);
		$this->assertSame($pdoAddress->getAddressState(), $this->VALID_STATE);
		$this->assertSame($pdoAddress->getAddressZip(), $this->VALID_ZIP);
		$this->assertSame($pdoAddress->getAddressLabel(), $this->VALID_LABEL);
		$this->assertSame($pdoAddress->getAddressHidden(), $this->VALID_HIDDEN);
		$this->assertSame($pdoAddress->getAddressAttention(), $this->VALID_ATTENTION);
		$this->assertSame($pdoAddress->getAddressStreet1(), $this->VALID_STREET1);
	}

	/**
	 * test userDelete on a Address that does exist
	 *
	 **/
	public function testUserDeleteValidAddress() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("address");

		// create a new Address and insert to into mySQL
		$address = new Address(null, $this->VALID_EMAIL->getEmailId(), $this->VALID_ATTENTION, $this->VALID_STREET1,
									  $this->VALID_CITY, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_STREET2,
									  $this->VALID_LABEL, $this->VALID_HIDDEN);
		$address->insert($this->getPDO());

		// edit the addressHidden field in the object, then send it to mySQL
		// i think the setAddressHidden is redundant based on the way my "update" works...
		$address->userDelete($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAddress = Address::getAddressByAddressId($this->getPDO(), $address->getAddressId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("address"));
		$this->assertSame($pdoAddress->getAddressHidden(), $this->VALID_HIDDEN);
	}

	/**
	 * test userDelete on an Address that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUserDeleteInvalidAddress() {
		// create an Address then try to use the userDelete function to hide the address
		// from the user, simulating a deletion
		$address = new Address(null, $this->VALID_EMAIL->getEmailId(), $this->VALID_ATTENTION, $this->VALID_STREET1,
									  $this->VALID_CITY, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_STREET2,
									  $this->VALID_LABEL, $this->VALID_HIDDEN);
		$address->userDelete($this->getPDO());
	}

	/**
	 * test creating an Address and then adminDelete it
	 **/
	public function testAdminDeleteValidAddress() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("address");

		// create a new Address and insert to into mySQL
		$address = new Address(null, $this->VALID_EMAIL->getEmailId(), $this->VALID_ATTENTION, $this->VALID_STREET1,
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
		$address = new Address(null, $this->VALID_EMAIL->getEmailId(), $this->VALID_ATTENTION, $this->VALID_STREET1,
									  $this->VALID_CITY, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_STREET2,
									  $this->VALID_LABEL, $this->VALID_HIDDEN);
		$address->adminDelete($this->getPDO());
	}

	/**
	 * test inserting an Address and regrabbing it from mySQL
	 **/
	public function testGetValidAddressByAddressId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("address");

		// create a new Address and insert to into mySQL
		$address = new Address(null, $this->VALID_EMAIL->getEmailId(), $this->VALID_ATTENTION, $this->VALID_STREET1,
									  $this->VALID_CITY, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_STREET2,
									  $this->VALID_LABEL, $this->VALID_HIDDEN);
		$address->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAddress = Address::getAddressByAddressId($this->getPDO(), $address->getAddressId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("address"));
		$this->assertSame($pdoAddress->getAddressAttention(), $this->VALID_ATTENTION);
		$this->assertSame($pdoAddress->getAddressStreet1(), $this->VALID_STREET1);
		$this->assertSame($pdoAddress->getAddressStreet2(), $this->VALID_STREET2);
		$this->assertSame($pdoAddress->getAddressCity(), $this->VALID_CITY);
		$this->assertSame($pdoAddress->getAddressState(), $this->VALID_STATE);
		$this->assertSame($pdoAddress->getAddressZip(), $this->VALID_ZIP);
		$this->assertSame($pdoAddress->getAddressLabel(), $this->VALID_LABEL);
		$this->assertSame($pdoAddress->getAddressHidden(), $this->VALID_HIDDEN);

	}

	/**
	 * test grabbing a Address that does not exist by addressid
	 **/
	public function testGetInvalidAddressByAddressId() {
		// grab a address id that exceeds the maximum allowable address id
		$address = Address::getAddressByAddressId($this->getPDO(), CheqoutTest::INVALID_KEY);
		$this->assertNull($address);
	}

	/**
	 * test inserting an Address and regrabbing it from mySQL by emailId
	 **/
	public function testGetValidAddressesByEmailId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("address");
		// create a new address and insert to into mySQL
		$address = new Address(null, $this->VALID_EMAIL->getEmailId(), $this->VALID_ATTENTION, $this->VALID_STREET1,
			$this->VALID_CITY, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_STREET2,
			$this->VALID_LABEL, $this->VALID_HIDDEN);
		$address->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Address::getAddressesByEmailId($this->getPDO(), $address->getEmailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("address"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Address", $results);
		// grab the result from the array and validate it
		$pdoAddress = $results[0];
		$this->assertSame($pdoAddress->getAddressAttention(), $this->VALID_ATTENTION);
		$this->assertSame($pdoAddress->getAddressStreet1(), $this->VALID_STREET1);
		$this->assertSame($pdoAddress->getAddressStreet2(), $this->VALID_STREET2);
		$this->assertSame($pdoAddress->getAddressCity(), $this->VALID_CITY);
		$this->assertSame($pdoAddress->getAddressState(), $this->VALID_STATE);
		$this->assertSame($pdoAddress->getAddressZip(), $this->VALID_ZIP);
		$this->assertSame($pdoAddress->getAddressLabel(), $this->VALID_LABEL);
		$this->assertSame($pdoAddress->getAddressHidden(), $this->VALID_HIDDEN);
	}

	/**
	 * test grabbing a Address that does not exist by emailid
	 **/
	public function testGetInvalidAddressByEmailId() {
		// grab a address id that exceeds the maximum allowable address id
		$address = Address::getAddressesByEmailId($this->getPDO(), CheqoutTest::INVALID_KEY);
		$this->assertNull($address);
	}


	/**
	 * test breaking attention string
	 *
	 * @expectedException UnexpectedValueException
	 **/

	public function testBreakingAttentionStringTheory() {
		//make a new address object and break attention
		new Address(null, $this->VALID_EMAIL->getEmailId(), CheqoutTest::INVALID_STRING, $this->VALID_STREET1,
			$this->VALID_CITY, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_STREET2,
			$this->VALID_LABEL, $this->VALID_HIDDEN);
	}
	/**
	 * test breaking street1 string
	 *
	 * @expectedException UnexpectedValueException
	 **/
	public function testBreakingStreet1StringTheory() {
		// break street1
		new Address(null, $this->VALID_EMAIL->getEmailId(), $this->VALID_ATTENTION, CheqoutTest::INVALID_STRING,
			$this->VALID_CITY, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_STREET2,
			$this->VALID_LABEL, $this->VALID_HIDDEN);
	}
	/**
	 * test breaking city string
	 *
	 * @expectedException UnexpectedValueException
	 **/
	public function testBreakingCityStringTheory() {
		// break city
		new Address(null, $this->VALID_EMAIL->getEmailId(), $this->VALID_ATTENTION, $this->VALID_STREET1,
			CheqoutTest::INVALID_STRING, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_STREET2,
			$this->VALID_LABEL, $this->VALID_HIDDEN);
	}
	/**
	 * test breaking state string
	 *
	 * @expectedException UnexpectedValueException
	 **/
	public function testBreakingStateStringTheory() {
		// break state
		new Address(null, $this->VALID_EMAIL->getEmailId(), $this->VALID_ATTENTION, $this->VALID_STREET1,
			$this->VALID_CITY, CheqoutTest::INVALID_STRING, $this->VALID_ZIP, $this->VALID_STREET2,
			$this->VALID_LABEL, $this->VALID_HIDDEN);
	}
	/**
	 * test breaking ZIP string
	 *
	 * @expectedException UnexpectedValueException
	 **/
	public function testBreakingZipStringTheory() {
		// break ZIP
		new Address(null, $this->VALID_EMAIL->getEmailId(), $this->VALID_ATTENTION, $this->VALID_STREET1,
			$this->VALID_CITY, $this->VALID_STATE, CheqoutTest::INVALID_STRING, $this->VALID_STREET2,
			$this->VALID_LABEL, $this->VALID_HIDDEN);
	}
	/**
	 * test breaking street2 string
	 *
	 * @expectedException UnexpectedValueException
	 **/
	public function testBreakingStreet2StringTheory() {
		// break street 2
		new Address(null, $this->VALID_EMAIL->getEmailId(), $this->VALID_ATTENTION, $this->VALID_STREET1,
			$this->VALID_CITY, $this->VALID_STATE, $this->VALID_ZIP, CheqoutTest::INVALID_STRING,
			$this->VALID_LABEL, $this->VALID_HIDDEN);
	}
	/**
	 * test breaking label string
	 *
	 * @expectedException UnexpectedValueException
	 **/
	public function testBreakingLabelStringTheory() {
		// break label
		new Address(null, $this->VALID_EMAIL->getEmailId(), $this->VALID_ATTENTION, $this->VALID_STREET1,
			$this->VALID_CITY, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_STREET2,
			CheqoutTest::INVALID_STRING, $this->VALID_HIDDEN);
	}
}
?>