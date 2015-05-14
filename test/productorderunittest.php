<?php
// grab the cheqout base test parameters
require_once("cheqouttest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/class/productorder.php");

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
	protected $VALID_SHIPPINGCOST = 5;
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
		// create and insert a CheqoutOrder to own the test ProductOrder
		$this->cheqoutOrder = new CheqoutOrder(null, "foo@bar.fuz", 34, "L33t", 01-01-01 02:02:02);
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
		$productOrder = new ProductOrder($this->cheqoutOrder, $this->product, $this->VALID_QUANTITY, $this->VALID_SHIPPINGCOST, $this->VALID_ORDERPRICE);
		$productOrder->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductOrder = ProductOrder::getProductOrderByOrderIdAndProductId($this->getPDO(), $productOrder->getOrderId(), $productOrder->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("productOrder"));
		$this->assertSame($pdoProductOrder->getQuantity(), $this->VALID_QUANTITY);
		$this->assertSame($pdoProductOrder->getShippingCost(), $this->VALID_SHIPPINGCOST);
		$this->assertSame($pdoProductOrder->getOrderPrice(), $this->VALID_ORDERPRICE);

	}

	/**
	 * test inserting a Product which is invalid
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProductOrder() {
		// create a product order with non null orderId/productId pair that fail
		$productOrder = new ProductOrder(CheqoutTest::INVALID_KEY, CheqoutTest::INVALID_KEY, $this->VALID_QUANTITY, $this->VALID_SHIPPINGCOST, $this->VALID_ORDERPRICE);
		$productOrder->insert($this->getPDO());
	}

}