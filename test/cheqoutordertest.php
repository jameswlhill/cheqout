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
	 * valid shipping Id to update
	 * @var int $VALID_SHIPPING2
	 */
	protected $VALID_SHIPPING2 = "102";

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
	 * test insert on an invalid order
	 *
	 * @expectedException InvalidArgumentException
	 **/
	public function testInsertInvalidOrder() {
		$email = new CheqoutOrder(null, CheqoutTest::INVALID_KEY, $this->VALID_BILLING, $this->VALID_SHIPPING,
			$this->VALID_STRIPE, $this->VALID_DATETIME);
		$email->insert($this->getPDO());
	}

	/**
	 * test delete of valid order
	 **/
	public function testDeleteValidOrder() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("cheqoutOrder");

		// create a new order and insert to into mySQL
		$order = new CheqoutOrder(null, $this->VALID_EMAILID, $this->VALID_BILLING, $this->VALID_SHIPPING,
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
	 * test delete of invalid order
	 *
	 * @expectedException PDOException
	 */
	public function testDeleteInvalidOrder() {
		$order = new CheqoutOrder(null, $this->VALID_EMAILID, $this->VALID_BILLING, $this->VALID_SHIPPING,
			$this->VALID_STRIPE, $this->VALID_DATETIME);
		$order->delete($this->getPDO());
	}

	/**
	 * test update on a valid order
	 **/
	public function testUpdateValidOrder() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("cheqoutOrder");

		// create a new order and insert to into mySQL
		$order = new CheqoutOrder(null, $this->VALID_EMAILID, $this->VALID_BILLING, $this->VALID_SHIPPING,
			$this->VALID_STRIPE, $this->VALID_DATETIME);
		$order->insert($this->getPDO());

		// update the email address field
		$order->setShippingAddressId($this->VALID_SHIPPING2);
		$order->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoOrder = CheqoutOrder::getOrderByOrderId($this->getPDO(), $order->getOrderId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("cheqoutOrder"));
		$this->assertSame($pdoOrder->getShippingAddressId(), $this->VALID_EMAILADDRESS2);
	}
	/**
	 * test update with invalid shipping address
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function testUpdateInvalidOrder() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("cheqoutOrder");

		// create a new order and insert to into mySQL
		$order = new CheqoutOrder(null, $this->VALID_EMAILID, $this->VALID_BILLING, $this->VALID_SHIPPING,
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
	 * test grabbing an email that does not exist by email id
	 **/
	public function testGetInvalidOrderByOrderId() {
		// grab an order id that exceeds the maximum allowable order id int
		$order = CheqoutOrder::getORderByOrderId($this->getPDO(), CheqoutTest::INVALID_KEY);
		$this->assertNull($order);
	}
	/**
	 * test inserting an email and re-grabbing it from mySQL by stripeId
	 **/
	public function testGetValidOrderByEmailId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("CheqoutOrder");
		// create a new address and insert to into mySQL
		$order = new CheqoutOrder(null, $this->VALID_EMAILID, $this->VALID_BILLING, $this->VALID_SHIPPING,
			$this->VALID_STRIPE, $this->VALID_DATETIME);
		$order->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = CheqoutOrder::getOrderByEmailId($this->getPDO(), $order->getEmailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("cheqoutOrder"));

		// grab the result
		$pdoOrder = $results[0];
		$this->assertSame($pdoOrder->getEmailId(), $this->VALID_EMAILID);
		$this->assertSame($pdoOrder->getBillingAddressId(), $this->VALID_BILLING);
		$this->assertSame($pdoOrder->getShippingAddressId(), $this->VALID_SHIPPING);
		$this->assertSame($pdoOrder->getStripeId(), $this->VALID_STRIPE);
		$this->assertSame($pdoOrder->getOrderDateTime(), $this->VALID_DATETIME);
	}
	/**
	 * test grabbing an order that does not exist by email id
	 **/
	public function testGetInvalidOrderByEmailId() {
		// grab an email id that exceeds the maximum allowable address id
		$order = CheqoutOrder::getOrderByEmailId($this->getPDO(), CheqoutTest::INVALID_STRING);
		$this->assertNull($order);
	}
	/**
	 * test getting all orders and verifying same as inserted
	 */
	public function testGetAllOrders() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("cheqoutOrder");
		// create a new address and insert to into mySQL
		$order = new CheqoutOrder(null, $this->VALID_EMAILID, $this->VALID_BILLING, $this->VALID_SHIPPING,
			$this->VALID_STRIPE, $this->VALID_DATETIME);
		$order->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = CheqoutOrder::getAllOrders($this->getPDO(), $order->getOrderId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("cheqoutOrder"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("CheqoutOrder", $results);
		// grab the result from the array and validate it
		$pdoOrder = $results[0];
		$this->assertSame($pdoOrder->getEmailId(), $this->VALID_EMAILID);
		$this->assertSame($pdoOrder->getBillingAddressId(), $this->VALID_BILLING);
		$this->assertSame($pdoOrder->getShippingAddressId(), $this->VALID_SHIPPING);
		$this->assertSame($pdoOrder->getStripeId(), $this->VALID_STRIPE);
		$this->assertSame($pdoOrder->getOrderDateTime(), $this->VALID_DATETIME);
	}

	/**
	 * test breaking emailId
	 *
	 * @expectedException RangeException
	 **/

	public function testBreakingEmailId() {
		new CheqoutOrder(null, $this->VALID_EMAILID, $this->VALID_BILLING, $this->VALID_SHIPPING,
			$this->VALID_STRIPE, $this->VALID_DATETIME);
	}
	/**
	 * test breaking billing address id
	 *
	 * @expectedException InvalidArgumentException
	 **/

	public function testBreakingBillingAddressId() {
		new CheqoutOrder(null, $this->VALID_EMAILID, $this->VALID_BILLING, $this->VALID_SHIPPING,
			$this->VALID_STRIPE, $this->VALID_DATETIME);
	}
	/**
	 * test breaking shipping address Id
	 *
	 * @expectedException InvalidArgumentException
	 **/

	public function testBreakingShippingAddressId() {
		new CheqoutOrder(null, $this->VALID_EMAILID, $this->VALID_BILLING, $this->VALID_SHIPPING,
			$this->VALID_STRIPE, $this->VALID_DATETIME);
	}
	/**
	 * test breaking stripe id string
	 *
	 * @expectedException InvalidArgumentException
	 **/

	public function testBreakingStripeId() {
		new CheqoutOrder(null, $this->VALID_EMAILID, $this->VALID_BILLING, $this->VALID_SHIPPING,
			$this->VALID_STRIPE, $this->VALID_DATETIME);
	}
	/**
	 * test breaking order date time
	 *
	 * @expectedException InvalidArgumentException
	 **/

	public function testBreakingOrderDateTime() {
		new CheqoutOrder(null, $this->VALID_EMAILID, $this->VALID_BILLING, $this->VALID_SHIPPING,
			$this->VALID_STRIPE, CheqoutTest::INVALID_STRING);
	}

}
