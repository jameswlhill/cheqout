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
	protected $VALID_EMAILID = null;
	/**
	 * valid billing address id
	 * @var int $VALID_BILLING
	 */
	protected $VALID_BILLING = null;
	/**
	 * valid shipping address id
	 * @var int $VALID_SHIPPING
	 */
	protected $VALID_SHIPPING = null;
	/**
	 * valid stripeId
	 * @var string $VALID_STRIPE
	 */
	protected $VALID_STRIPE = "abcedef";
	/**
	 * valid orderDateTime
	 * @var datetime $VALID_DATETIME
	 */
	protected $VALID_DATETIME = "0000-00-00 00:00:00";
	/**
	 * valid shipping Id to update
	 * @var int $VALID_SHIPPING2
	 */
	protected $VALID_SHIPPING2 = "102";
	/**
	 * email parent object for foreign key relations
	 * @var Email $email
	 */
	protected $email = null;
	/**
	 * billing address parent object for foreign key relations
	 * @var Address $billingAddress
	 */
	protected $billingAddress = null;
	/**
	 * shipping address parent object for foreign key relations
	 * @var Address $shippingAddress
	 */
	protected $shippingAddress = null;
	/**
	 * shipping address to update for foreign key relations
	 */

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();
		//create and insert an Email parent object
		$this->email = new Email(null,"jim@cnm.edu","stripe");
		$this->email->insert($this->getPDO());
		//create and insert billing Address object
		$this->billingAddress = new Address(null, $this->email->getEmailId(),"attn","streetone","city","state","87102-5784","streettwo","label");
		$this->billingAddress->insert($this->getPDO());
		//create and insert shipping Address object
		$this->shippingAddress = new Address(null,$this->email->getEmailId(),"attn","streetone","city","state","87102-5785","streettwo","label");
		$this->shippingAddress->insert($this->getPDO());
	}

	/**
	 * test insert on valid checkout and verify mySQL data matches
	 **/
	public function testInsertValidOrder() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("cheqoutOrder");

		// create a new Order and insert to into mySQL
		$order = new CheqoutOrder(null, $this->email->getEmailId(), $this->billingAddress->getAddressId(), $this->shippingAddress->getAddressId(),
			$this->VALID_STRIPE, $this->VALID_DATETIME);
		$order->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoOrder = CheqoutOrder::getOrderByOrderId($this->getPDO(), $order->getOrderId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("cheqoutOrder"));
		$this->assertSame($pdoOrder->getEmailId(), $this->email->getEmailId());
		$this->assertSame($pdoOrder->getBillingAddressId(), $this->billingAddress->getAddressId());
		$this->assertSame($pdoOrder->getShippingAddressId(), $this->shippingAddress->getAddressId());
		$this->assertSame($pdoOrder->getStripeId(), $this->VALID_STRIPE);
		$this->assertSame($pdoOrder->getOrderDateTime(), $this->VALID_DATETIME);
	}
	/**
	 * test insert on an invalid checkout
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidOrder() {
		$email = new CheqoutOrder(CheqoutTest::INVALID_KEY, $this->email->getEmailId(), $this->billingAddress->getAddressId(), $this->shippingAddress->getAddressId(),
			$this->VALID_STRIPE, $this->VALID_DATETIME);
		$email->insert($this->getPDO());
	}

	/**
	 * test delete of valid checkout
	 **/
	public function testDeleteValidOrder() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("cheqoutOrder");

		// create a new checkout and insert to into mySQL
		$order = new CheqoutOrder(null, $this->email->getEmailId(), $this->billingAddress->getAddressId(), $this->shippingAddress->getAddressId(),
			$this->VALID_STRIPE, $this->VALID_DATETIME);

		$order->insert($this->getPDO());

		//run the delete function
		$order->delete($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoOrder = CheqoutOrder::getOrderByOrderId($this->getPDO(), $order->getOrderId());
		$this->assertNull($pdoOrder);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("cheqoutOrder"));
	}

	/**
	 * test delete of invalid checkout
	 *
	 * @expectedException PDOException
	 */
	public function testDeleteInvalidOrder() {
		$order = new CheqoutOrder(null, $this->email->getEmailId(), $this->billingAddress->getAddressId(), $this->shippingAddress->getAddressId(),
			$this->VALID_STRIPE, $this->VALID_DATETIME);
		$order->delete($this->getPDO());
	}

	/**
	 * test update on a valid checkout
	 **/
	public function testUpdateValidOrder() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("cheqoutOrder");

		// create a new checkout and insert to into mySQL
		$order = new CheqoutOrder(null, $this->email->getEmailId(), $this->billingAddress->getAddressId(), $this->shippingAddress->getAddressId(),
			$this->VALID_STRIPE, $this->VALID_DATETIME);
		$order->insert($this->getPDO());

		// update the shipping address id field
		$order->setShippingAddressId($this->billingAddress->getAddressId());
		$order->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoOrder = CheqoutOrder::getOrderByOrderId($this->getPDO(), $order->getOrderId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("cheqoutOrder"));
		$this->assertSame($pdoOrder->getEmailId(), $this->email->getEmailId());
		$this->assertSame($pdoOrder->getBillingAddressId(), $this->billingAddress->getAddressId());
		$this->assertSame($pdoOrder->getShippingAddressId(), $this->billingAddress->getAddressId());
		$this->assertSame($pdoOrder->getStripeId(), $this->VALID_STRIPE);
		$this->assertSame($pdoOrder->getOrderDateTime(), $this->VALID_DATETIME);
	}
	/**
	 * test update with invalid shipping address
	 *
	 * @expectedException UnexpectedValueException
	 */
	public function testUpdateInvalidOrder() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("cheqoutOrder");

		// create a new checkout and insert to into mySQL
		$order = new CheqoutOrder(null, $this->email->getEmailId(), $this->billingAddress->getAddressId(), $this->shippingAddress->getAddressId(),
			$this->VALID_STRIPE, $this->VALID_DATETIME);
		$order->insert($this->getPDO());

		//update the shipping address field
		$order->setShippingAddressId(CheqoutTest::INVALID_STRING);
		$order->update($this->getPDO());
	}

	/**
	 * test getting email by email id
	 **/
	public function testGetValidOrderByOrderId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("cheqoutOrder");
		// create a new address and insert to into mySQL
		$order = new CheqoutOrder(null, $this->email->getEmailId(), $this->billingAddress->getAddressId(), $this->shippingAddress->getAddressId(),
			$this->VALID_STRIPE, $this->VALID_DATETIME);
		$order->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoOrder = CheqoutOrder::getOrderByOrderId($this->getPDO(), $order->getOrderId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("cheqoutOrder"));
		$this->assertSame($pdoOrder->getEmailId(), $this->email->getEmailId());
		$this->assertSame($pdoOrder->getBillingAddressId(), $this->billingAddress->getAddressId());
		$this->assertSame($pdoOrder->getShippingAddressId(), $this->shippingAddress->getAddressId());
		$this->assertSame($pdoOrder->getStripeId(), $this->VALID_STRIPE);
		$this->assertSame($pdoOrder->getOrderDateTime(), $this->VALID_DATETIME);
	}
	/**
	 * test grabbing an email that does not exist by email id
	 **/
	public function testGetInvalidOrderByOrderId() {
		// grab an checkout id that exceeds the maximum allowable checkout id int
		$order = CheqoutOrder::getOrderByOrderId($this->getPDO(), CheqoutTest::INVALID_KEY);
		$this->assertNull($order);
	}
	/**
	 * test inserting an email and re-grabbing it from mySQL by stripeId
	 **/
	public function testGetValidOrderByEmailId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("cheqoutOrder");
		// create a new address and insert to into mySQL
		$order = new CheqoutOrder(null, $this->email->getEmailId(), $this->billingAddress->getAddressId(), $this->shippingAddress->getAddressId(),
			$this->VALID_STRIPE, $this->VALID_DATETIME);
		$order->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = CheqoutOrder::getOrderByEmailId($this->getPDO(), $order->getEmailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("cheqoutOrder"));

		// grab the result
		$pdoOrder = $results;
		$this->assertSame($pdoOrder->getEmailId(), $this->email->getEmailId());
		$this->assertSame($pdoOrder->getBillingAddressId(), $this->billingAddress->getAddressId());
		$this->assertSame($pdoOrder->getShippingAddressId(), $this->shippingAddress->getAddressId());
		$this->assertSame($pdoOrder->getStripeId(), $this->VALID_STRIPE);
		$this->assertSame($pdoOrder->getOrderDateTime(), $this->VALID_DATETIME);
	}
	/**
	 * test grabbing an checkout that does not exist by email id
	 **/
	public function testGetInvalidOrderByEmailId() {
		// grab an email id that exceeds the maximum allowable address id
		$order = CheqoutOrder::getOrderByEmailId($this->getPDO(), CheqoutTest::INVALID_KEY);
		$this->assertNull($order);
	}

	/**
	 * test breaking emailId
	 *
	 * @expectedException RangeException
	 **/

	public function testBreakingEmailId() {
		new CheqoutOrder(null, CheqoutTest::INVALID_KEY, $this->billingAddress->getAddressId(), $this->shippingAddress->getAddressId(),
			$this->VALID_STRIPE, $this->VALID_DATETIME);
	}
	/**
	 * test breaking billing address id
	 *
	 * @expectedException RangeException
	 **/

	public function testBreakingBillingAddressId() {
		new CheqoutOrder(null, $this->email->getEmailId(), CheqoutTest::INVALID_KEY, $this->shippingAddress->getAddressId(),
			$this->VALID_STRIPE, $this->VALID_DATETIME);
	}
	/**
	 * test breaking shipping address Id
	 *
	 * @expectedException RangeException
	 **/

	public function testBreakingShippingAddressId() {
		new CheqoutOrder(null, $this->email->getEmailId(), $this->billingAddress->getAddressId(), CheqoutTest::INVALID_KEY,
			$this->VALID_STRIPE, $this->VALID_DATETIME);
	}
	/**
	 * test breaking stripe id string
	 *
	 * @expectedException RangeException
	 **/

	public function testBreakingStripeId() {
		new CheqoutOrder(null, $this->email->getEmailId(), $this->billingAddress->getAddressId(), $this->shippingAddress->getAddressId(),
			CheqoutTest::INVALID_STRING, $this->VALID_DATETIME);
	}
	/**
	 * test breaking checkout date time
	 *
	 * @expectedException RangeException
	 **/

	public function testBreakingOrderDateTime() {
		new CheqoutOrder(null, $this->email->getEmailId(), $this->billingAddress->getAddressId(), $this->shippingAddress->getAddressId(),
			$this->VALID_STRIPE, CheqoutTest::INVALID_STRING);
	}

}
