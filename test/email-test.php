<?php
// grab the project test parameters
require_once("cheqouttest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/class/email.php");

/**
 * Full PHPUnit test for the Email class
 *
 * This is a complete PHPUnit test of the Address class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Email
 * @author Kyla Carroll <kylacarroll43@gmail.com>
 **/
class EmailTest extends CheqoutTest {
	/**
	 * valid email address
	 * @var string $VALID_EMAILADDRESS
	 **/
	protected $VALID_EMAILADDRESS = "giblets@turkey.com";
	/**
	 * valid stripeId to use
	 * @var string $VALID_STRIPEID
	 **/
	protected $VALID_STRIPEID = "abcdefghijklmnopqrstuvwxy";
	/**
	 * valid email address 2
	 * @var string $VALID_EMAILADDRESS2
	 */
	protected $VALID_EMAILADDRESS2 = "innards@chicken.com";

	/**
	 * test insert on valid email and verify mySQL data matches
	 **/
	public function testInsertValidEmail() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("email");

		// create a new Address and insert to into mySQL
		$email = new Email(null, $this->VALID_EMAILADDRESS, $this->VALID_STRIPEID);
		$email->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoEmail = Email::getEmailByStripeId($this->getPDO(), $email->getEmailId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("email"));
		$this->assertSame($pdoEmail->getEmailAddress(), $this->VALID_EMAIL);
		$this->assertSame($pdoEmail->getStripeId(), $this->VALID_STRIPEID);
	}
	/**
	 * test insert on an invalid email
	 *
	 * @expectedException PDOException faulty insert function throws this exception
	 **/
	public function testInsertInvalidEmail() {
		$email = new Email(CheqoutTest::INVALID_KEY, $this->VALID_EMAILADDRESS, $this->VALID_STRIPEID);
		$email->insert($this->getPDO());
	}

	/**
	 * test delete of valid email
	 **/
	public function testDeleteValidEmail() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("email");

		// create a new email and insert to into mySQL
		$email = new Email(null, $this->VALID_EMAILADDRESS, $this->VALID_STRIPEID);

		$email->insert($this->getPDO());

		//run the delete function
		$email->delete($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoEmail = Email::getEmailByStripeId($this->getPDO(), $email->getEmailId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("email"));
		$this->assertSame($pdoEmail->getStripeId(), $this->VALID_STRIPEID);
	}

	/**
	 * test delete of invalid email
	 *
	 * @ExpectedException PDOException faulty delete function throws this exception
	 */
	public function testDeleteInvalidEmail() {
		$email = new Email(null, $this->VALID_EMAILADDRESS, $this->VALID_STRIPEID);
		$email->delete($this->getPDO());
	}
	/**
	 * test update on a valid email
	 **/
	public function testUpdateValidEmail() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("email");

		// create a new Address and insert to into mySQL
		$email = new Email(null, $this->VALID_EMAILADDRESS, $this->VALID_STRIPEID);
		$email->insert($this->getPDO());

		// update the email address field
		$email->setEmailAddress($this->VALID_EMAILADDRESS2);
		$email->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoEmail = Email::getEmailByEmailId($this->getPDO(), $email->getEmailId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("email"));
		$this->assertSame($pdoEmail->getEmailAddress, $this->VALID_EMAILADDRESS2);
	}
	/**
	 * test update with invalid email address
	 *
	 * @ExpectedException PDOException
	 */
	public function testUpdateInvalidEmail() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("email");

		// create a new email and insert to into mySQL
		$email = new Email(null, $this->VALID_EMAILADDRESS, $this->VALID_STRIPEID);
		$email->insert($this->getPDO());

		//update the email address field
		$email->setEmailAddress(CheqoutTest::INVALID_STRING);
		$email->update($this->getPDO());
	}

	/**
	 * test getting email by email id
	 **/
	public function testGetValidEmailByEmailId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("email");
		// create a new address and insert to into mySQL
		$email = new Email(null, $this->VALID_EMAILADDRESS, $this->VALID_STRIPEID);
		$email->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Email::getEmailByEmailId($this->getPDO(), $email->getEmailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("email"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Email", $results);
		// grab the result from the array and validate it
		$pdoEmail = $results[0];
		$this->assertSame($pdoEmail->getEmailAddress(), $this->VALID_EMAILADDRESS);
		$this->assertSame($pdoEmail->getStripeId(), $this->VALID_STRIPEID);
	}
	/**
	 * test grabbing an email that does not exist by email id
	 **/
	public function testGetInvalidEmailByEmailId() {
		// grab an email id that exceeds the maximum allowable address id
		$email = Email::getEmailByEmailId($this->getPDO(), CheqoutTest::INVALID_KEY);
		$this->assertNull($email);
	}
	/**
	 * test inserting an email and re-grabbing it from mySQL by stripeId
	 **/
	public function testGetValidEmailByStripeId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("email");
		// create a new address and insert to into mySQL
		$email = new Email(null, $this->VALID_EMAILADDRESS, $this->VALID_STRIPEID);
		$email->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Email::getEmailByStripeId($this->getPDO(), $email->getEmailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("email"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Email", $results);
		// grab the result from the array and validate it
		$pdoEmail = $results[0];
		$this->assertSame($pdoEmail->getEmailAddress(), $this->VALID_EMAILADDRESS);
		$this->assertSame($pdoEmail->getStripeId(), $this->VALID_STRIPEID);
	}
	/**
	 * test grabbing an email that does not exist by stripe id
	 **/
	public function testGetInvalidEmailByStripeId() {
		// grab an email id that exceeds the maximum allowable address id
		$email = Email::getEmailByStripeId($this->getPDO(), CheqoutTest::INVALID_STRING);
		$this->assertNull($email);
	}
	/**
	 * test getting all emails and verifying same as inserted
	 */
	public function testGetAllEmails() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("email");
		// create a new address and insert to into mySQL
		$email = new Email(null, $this->VALID_EMAILADDRESS, $this->VALID_STRIPEID);
		$email->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Email::getAllEmails($this->getPDO(), $email->getEmailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("email"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Email", $results);
		// grab the result from the array and validate it
		$pdoEmail = $results[0];
		$this->assertSame($pdoEmail->getEmailAddress(), $this->VALID_EMAILADDRESS);
		$this->assertSame($pdoEmail->getStripeId(), $this->VALID_STRIPEID);
	}

	/**
	 * test breaking email address string
	 *
	 * @expectedException UnexpectedValueException
	 **/

	public function testBreakingEmailAddressString() {
		//make a new email entry and break email address
		new Email(null, CheqoutTest::INVALID_STRING, $this->VALID_STRIPEID);
	}
	/**
	 * test breaking stripe id string
	 *
	 * @expectedException UnexpectedValueException
	 **/

	public function testBreakingStripeIdString() {
		//make a new email entry and break stripe id string
		new Email(null, $this->VALID_EMAILADDRESS, CheqoutTest::INVALID_STRING);
	}

}
