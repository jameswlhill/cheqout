<?php
// grab the project test parameters
require_once("cheqouttest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/class/email.php");
require_once(dirname(__DIR__) . "/php/class/cheqoutorder.php");
require_once(dirname(__DIR__) . "/php/class/address.php");

/**
 * Full PHPUnit test for the CheqoutOrder class
 *
 * This is a complete PHPUnit test of the CheqoutOrder class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see CheqoutOrder
 * @author Kyla Carroll <kylacarroll43@gmail.com>
 **/
class CheqoutOrderTest extends CheqoutTest {
	/**
	 * valid email id
	 * @var int $VALID_EMAILID
	 */
	protected $VALID_EMAILID = "43";
	/**
	 * valid billing address id
	 * @var int $VALID_BILLING
	 */
	protected $VALID_BILLING = "100";
	/**
	 * valid shipping address id
	 * @var int $VALID_SHIPPING
	 */
	protected $VALID_SHIPPING = "101";
	/**
	 * valid stripeId
	 * @var string $VALID_STRIPE
	 */
	protected $VALID_STRIPE = "abcedefghijklmnopqrstuvwxy";
	/**
	 * valid orderDateTime
	 * @var datetime $VALID_DATETIME
	 */
	protected $VALID_DATETIME = "04-20-2015 16:20:00";

	/**
	 * test insert on valid order and verify mySQL data matches
	 **/
	public function testInsertValidOrder() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("cheqoutOrder");

		// create a new Order and insert to into mySQL
		$order = new CheqoutOrder(null, $this->VALID_EMAILID, $this->VALID_BILLING, $this->VALID_SHIPPING,
			$this->VALID_STRIPE, $this->VALID_DATETIME);
		$order->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoOrder = CheqoutOrder::getOrderByOrderId($this->getPDO(), $order->getOrderId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("cheqoutOrder"));
		$this->assertSame($pdoOrder->getEmailId(), $this->VALID_EMAILID);
		$this->assertSame($pdoOrder->getBillingAddressId(), $this->VALID_BILLING);
		$this->assertSame($pdoOrder->getShippingAddressId(), $this->VALID_SHIPPING);
		$this->assertSame($pdoOrder->getStripeId(), $this->VALID_STRIPE);
		$this->assertSame($pdoOrder->getOrderDateTime(), $this->VALID_DATETIME);
	}
	/**
	 * test insert on an invalid email
	 *
	 * @expectedException RangeException
	 **/
	public function testInsertInvalidOrder() {
		$email = new CheqoutOrder(null, CheqoutTest::INVALID_STRING, $this->VALID_BILLING, $this->VALID_SHIPPING, $this->VALID_STRIPEID, $this->VALID_DATETIME);
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
		$pdoEmail = Email::getEmailByEmailId($this->getPDO(), $email->getEmailId());
		$this->assertNull($pdoEmail);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("email"));
	}

	/**
	 * test delete of invalid email
	 *
	 * @expectedException PDOException
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
		$this->assertSame($pdoEmail->getEmailAddress(), $this->VALID_EMAILADDRESS2);
	}
	/**
	 * test update with invalid email address
	 *
	 * @expectedException RangeException
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
		$pdoEmail = Email::getEmailByEmailId($this->getPDO(), $email->getEmailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("email"));
		$this->assertEquals($pdoEmail->getEmailAddress(), $this->VALID_EMAILADDRESS);
		$this->assertEquals($pdoEmail->getStripeId(), $this->VALID_STRIPEID);
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
		$results = Email::getEmailByStripeId($this->getPDO(), $email->getStripeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("email"));

		// grab the result
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
	 * @expectedException RangeException
	 **/

	public function testBreakingEmailAddressString() {
		//make a new email entry and break email address
		new Email(null, CheqoutTest::INVALID_STRING, $this->VALID_STRIPEID);
	}
	/**
	 * test breaking stripe id string
	 *
	 * @expectedException RangeException
	 **/

	public function testBreakingStripeIdString() {
		//make a new email entry and break stripe id string
		new Email(null, $this->VALID_EMAILADDRESS, CheqoutTest::INVALID_STRING);
	}

}
