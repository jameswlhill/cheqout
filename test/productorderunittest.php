<?php
// grab the cheqout base test parameters
require_once("cheqouttest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/class/productorder.php");
require_once(dirname(__DIR__) . "/php/class/email.php");
require_once(dirname(__DIR__) . "/php/class/address.php");

//load product.php, class to be tested
require_once('../php/class/product.php');

//load cheqoutorder.php, class to be tested
require_once('../php/class/cheqoutorder.php');

/**
 * Full PHPUnit test for the ProductOrder class
 *
 * @see ProductOrder
 * @author James Hill <james@appists.com>
 **/
class ProductOrderTest extends CheqoutTest {
	/**
	 * Order that created the ProductOrder; this is for foreign key relations
	 * @var CheqoutOrder $cheqoutOrder
	 **/
	protected $cheqoutOrder= null;
	/**
	 *  product that was ordered; this is for foreign key relations
	 * @var Product $product
	 **/
	protected $product = null;
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
	 * valid inventory quantity
	 *
	 * @var int $VALID_QUANTITY
	 **/
	protected $VALID_QUANTITY = 200;
	/**
	 * valid shipping cost
	 *
	 * @var float $VALID_SHIPPINGCOST
	 **/
	protected $VALID_SHIPPINGCOST = 5.0;
	/**
	 * invalid shipping cost
	 *
	 * @var float $INVALID_SHIPPINGCOST
	 **/
	protected $INVALID_SHIPPINGCOST = -3;
	/**
	 * valid order price
	 *
	 * @var float $VALID_ORDERPRICE
	 **/
	protected $VALID_ORDERPRICE = 45.50;
	/**
	 * invalid orderPrice
	 *
	 * @var float $INVALID_ORDERPRICE
	 **/
	protected $INVALID_ORDERPRICE = -23;

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
		// create and insert a CheqoutOrder to own the test ProductOrder
		$this->cheqoutOrder = new CheqoutOrder(null, $this->email->getEmailId(), $this->billingAddress->getAddressId(), $this->shippingAddress->getAddressId(), "12", "date");
		$this->cheqoutOrder->insert($this->getPDO());
		// create the test Product
		$this->product = new Product(null,"Title", 8.99, "Descriptive description", 150, .75);
		$this->product->insert($this->getPDO());
	}

	/**
	 * test inserting a valid ProductOrder and verifying that the actual MySQL data matches
	 **/
	public function testInsertValidProductOrder() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productOrder");

		// create a new ProductOrder and insert it into MySQL
		$productOrder = new ProductOrder($this->cheqoutOrder->getOrderId(), $this->product->getProductId(), $this->VALID_QUANTITY, $this->VALID_SHIPPINGCOST, $this->VALID_ORDERPRICE);
		$productOrder->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductOrder = ProductOrder::getProductOrderByOrderIdAndProductId($this->getPDO(), $productOrder->getOrderId(), $productOrder->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("productOrder"));
		$this->assertSame($pdoProductOrder->getQuantity(), $this->VALID_QUANTITY);
		$this->assertSame($pdoProductOrder->getShippingCost(), $this->VALID_SHIPPINGCOST);
		$this->assertSame($pdoProductOrder->getOrderPrice(), $this->VALID_ORDERPRICE);

	}

	/**
	 * test inserting a ProductOrder which is invalid
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProductOrder() {
		// create a product order with non null orderId/productId pair that fail
		$productOrder = new ProductOrder(CheqoutTest::INVALID_KEY, CheqoutTest::INVALID_KEY, $this->VALID_QUANTITY, $this->VALID_SHIPPINGCOST, $this->VALID_ORDERPRICE);
		$productOrder->insert($this->getPDO());
	}

	/**
	 * test creating a ProductOrder and then deleting it
	 **/
	public function testDeleteValidProductOrder() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productOrder");
		// create a new ProductOrder and insert to into MySQL
		$productOrder = new ProductOrder($this->cheqoutOrder->getOrderId(), $this->product->getProductId(), $this->VALID_QUANTITY, $this->VALID_SHIPPINGCOST, $this->VALID_ORDERPRICE);
		$productOrder->insert($this->getPDO());
		// delete the ProductOrder from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productOrder"));
		$productOrder->delete($this->getPDO());
		// grab the data from MySQL and enforce the ProductOrder does not exist
		$pdoProductOrder = ProductOrder::getProductOrderByOrderIdAndProductId($this->getPDO(), $this->cheqoutOrder->getOrderId(), $this->product->getProductId());
		$this->assertNull($pdoProductOrder);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("productOrder"));
	}

	/**
	 * test inserting a ProductOrder and retrieving it from MySQL
	 **/
	public function testGetValidProductOrderByOrderIdAndProductId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productOrder");
		// create a new ProductOrder and insert to into MySQL
		$productOrder = new ProductOrder($this->cheqoutOrder->getOrderId(), $this->product->getProductId(), $this->VALID_QUANTITY, $this->VALID_SHIPPINGCOST, $this->VALID_ORDERPRICE);
		$productOrder->insert($this->getPDO());
		// grab the data from MySQL and enforce the fields match our expectations
		$pdoProductOrder = ProductOrder::getProductOrderByOrderIdAndProductId($this->getPDO(), $this->cheqoutOrder->getOrderId(), $this->product->getProductId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("productOrder"));
		$this->assertEquals($pdoProductOrder->getOrderId(), $this->cheqoutOrder->getOrderId());
		$this->assertEquals($pdoProductOrder->getProductId(), $this->product->getProductId());
		$this->assertEquals($pdoProductOrder->getQuantity(), $this->VALID_QUANTITY);
		$this->assertEquals($pdoProductOrder->getShippingCost(), $this->VALID_SHIPPINGCOST);
		$this->assertEquals($pdoProductOrder->getOrderPrice(), $this->VALID_ORDERPRICE);
	}
	/**
	 * test grabbing a ProductOrder that does not exist
	 **/
	public function testGetInvalidProductOrderByOrderIdAndProductId() {
		// grab an order id and product id that exceeds the maximum allowable range for order id and profile id
		$productOrder = ProductOrder::getProductOrderByOrderIdAndProductId($this->getPDO(), CheqoutTest::INVALID_KEY, CheqoutTest::INVALID_KEY);
		$this->assertNull($productOrder);
	}

	/**
	 * test inserting a ProductOrder, editing it, and then updating it
	 **/
	public function testUpdateValidProductOrder() {
		// count the number of rows and save that number in $numRows
		$numRows = $this->getConnection()->getRowCount("productOrder");

		// create a new ProductOrder and insert into db using MySQL
		$productOrder = new ProductOrder($this->cheqoutOrder->getOrderId(), $this->product->getProductId(), $this->VALID_QUANTITY, $this->VALID_SHIPPINGCOST, $this->VALID_ORDERPRICE);
		$productOrder->insert($this->getPDO());

		// edit the ProductOrder and update it in the db
		$productOrder->setQuantity($this->VALID_QUANTITY);
		$productOrder->update($this->getPDO());

		// grab the data from db and enforce the fields match our expectations
		$pdoProductOrder = ProductOrder::getProductOrderByOrderIdAndProductId($this->getPDO(), $productOrder->getOrderId(), $productOrder->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("productOrder"));
		$this->assertEquals($pdoProductOrder->getOrderId(), $this->cheqoutOrder->getOrderId());
		$this->assertEquals($pdoProductOrder->getProductId(), $this->product->getProductId());
		$this->assertEquals($pdoProductOrder->getQuantity(), $this->VALID_QUANTITY);
		$this->assertEquals($pdoProductOrder->getShippingCost(), $this->VALID_SHIPPINGCOST);
		$this->assertEquals($pdoProductOrder->getOrderPrice(), $this->VALID_ORDERPRICE);
	}

}