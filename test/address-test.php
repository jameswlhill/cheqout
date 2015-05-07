<?php
// grab the project test parameters
require_once("cheqouttest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/class/address.php");


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
	 *  valid addressAttention to use
	 * @var string $VALID_ATTENTION
	 **/
	protected $VALID_ATTENTION = "Michael Douglas";

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
	 * test inserting a valid Address and verify that the actual mySQL data matches
	 **/
	public function testInsertValidAddress() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("address");

		// create a new Address and insert to into mySQL
		$address = new Address(null, $this->$VALID_ATTENTION, $this->$VALID_STREET1, $this->$VALID_CITY,
									  $this->$VALID_STATE, $this->$VALID_ZIP, $this->$VALID_STREET2,
									  $this->$VALID_LABEL, $this->$VALID_HIDDEN);
		$address->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAddress = Address::getAddressByAddressId($this->getPDO(), $address->getAddressId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("address"));
		$this->assertSame($pdoAddress->getAtHandle(), $this->VALID_ATHANDLE);
		$this->assertSame($pdoAddress->getEmail(), $this->VALID_EMAIL);
		$this->assertSame($pdoAddress->getPhone(), $this->VALID_PHONE);
	}

	/**
	 * test inserting a Address that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidAddress() {
		// create a address with a non null addressId and watch it fail
		$address = new Address(DataDesignTest::INVALID_KEY, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_PHONE);
		$address->insert($this->getPDO());
	}

	/**
	 * test inserting a Address, editing it, and then updating it
	 **/
	public function testUpdateValidAddress() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("address");

		// create a new Address and insert to into mySQL
		$address = new Address(null, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_PHONE);
		$address->insert($this->getPDO());

		// edit the Address and update it in mySQL
		$address->setAtHandle($this->VALID_ATHANDLE2);
		$address->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAddress = Address::getAddressByAddressId($this->getPDO(), $address->getAddressId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("address"));
		$this->assertSame($pdoAddress->getAtHandle(), $this->VALID_ATHANDLE2);
		$this->assertSame($pdoAddress->getEmail(), $this->VALID_EMAIL);
		$this->assertSame($pdoAddress->getPhone(), $this->VALID_PHONE);
	}

	/**
	 * test updating a Address that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidAddress() {
		// create a Address and try to update it without actually inserting it
		$address = new Address(null, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_PHONE);
		$address->update($this->getPDO());
	}

	/**
	 * test creating a Address and then deleting it
	 **/
	public function testDeleteValidAddress() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("address");

		// create a new Address and insert to into mySQL
		$address = new Address(null, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_PHONE);
		$address->insert($this->getPDO());

		// delete the Address from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("address"));
		$address->delete($this->getPDO());

		// grab the data from mySQL and enforce the Address does not exist
		$pdoAddress = Address::getAddressByAddressId($this->getPDO(), $address->getAddressId());
		$this->assertNull($pdoAddress);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("address"));
	}

	/**
	 * test deleting a Address that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidAddress() {
		// create a Address and try to delete it without actually inserting it
		$address = new Address(null, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_PHONE);
		$address->delete($this->getPDO());
	}

	/**
	 * test inserting a Address and regrabbing it from mySQL
	 **/
	public function testGetValidAddressByAddressId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("address");

		// create a new Address and insert to into mySQL
		$address = new Address(null, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_PHONE);
		$address->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAddress = Address::getAddressByAddressId($this->getPDO(), $address->getAddressId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("address"));
		$this->assertSame($pdoAddress->getAtHandle(), $this->VALID_ATHANDLE);
		$this->assertSame($pdoAddress->getEmail(), $this->VALID_EMAIL);
		$this->assertSame($pdoAddress->getPhone(), $this->VALID_PHONE);
	}

	/**
	 * test grabbing a Address that does not exist
	 **/
	public function testGetInvalidAddressByAddressId() {
		// grab a address id that exceeds the maximum allowable address id
		$address = Address::getAddressByAddressId($this->getPDO(), DataDesignTest::INVALID_KEY);
		$this->assertNull($address);
	}

	public function testGetValidAddressByAtHandle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("address");

		// create a new Address and insert to into mySQL
		$address = new Address(null, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_PHONE);
		$address->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAddress = Address::getAddressByAtHandle($this->getPDO(), $this->VALID_ATHANDLE);
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("address"));
		$this->assertSame($pdoAddress->getAtHandle(), $this->VALID_ATHANDLE);
		$this->assertSame($pdoAddress->getEmail(), $this->VALID_EMAIL);
		$this->assertSame($pdoAddress->getPhone(), $this->VALID_PHONE);
	}

	/**
	 * test grabbing a Address by at handle that does not exist
	 **/
	public function testGetInvalidAddressByAtHandle() {
		// grab an at handle that does not exist
		$address = Address::getAddressByAtHandle($this->getPDO(), "@doesnotexist");
		$this->assertNull($address);
	}

	/**
	 * test grabbing a Address by email
	 **/
	public function testGetValidAddressByEmail() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("address");

		// create a new Address and insert to into mySQL
		$address = new Address(null, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_PHONE);
		$address->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAddress = Address::getAddressByEmail($this->getPDO(), $this->VALID_EMAIL);
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("address"));
		$this->assertSame($pdoAddress->getAtHandle(), $this->VALID_ATHANDLE);
		$this->assertSame($pdoAddress->getEmail(), $this->VALID_EMAIL);
		$this->assertSame($pdoAddress->getPhone(), $this->VALID_PHONE);
	}

	/**
	 * test grabbing a Address by an email that does not exists
	 **/
	public function testGetInvalidAddressByEmail() {
		// grab an email that does not exist
		$address = Address::getAddressByEmail($this->getPDO(), "does@not.exist");
		$this->assertNull($address);
	}
}
?>