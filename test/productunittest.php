<?php
// grab the cheqout base test parameters
require_once("cheqouttest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/class/product.php");

/**
 * Full PHPUnit test for the Product class
 *
 * @see Product
 * @author James Hill <james@appists.com>
 **/
class ProductTest extends CheqoutTest {
	/**
	 * valid product title to use
	 * @var string $VALID_TITLE
	 **/
	protected $VALID_TITLE = "First Valid Title";
	/**
	 * second valid product title to use
	 * @var string $VALID_TITLE2
	 **/
	protected $VALID_TITLE2 = "Updated Valid Title";
	/**
	 * invalid product title to check
	 * @var null $INVALID_TITLE
	 **/
	protected $INVALID_TITLE = null;
	/**
	 * invalid product description to check
	 * @var null $INVALID_DESCRIPTION
	 **/
	protected $INVALID_DESCRIPTION = null;
	/**
	 * valid product price to use
	 * @var float $VALID_PRICE
	 **/
	protected $VALID_PRICE = 7.99;
	/**
	 * valid product description to use
	 * @var string $VALID_DESCRIPTION
	 **/
	protected $VALID_DESCRIPTION = "This is a valid product description string";
	/**
	 * valid current product inventory quantity
	 * @var int $VALID_INVENTORY
	 **/
	protected $VALID_INVENTORY = 200;
	/**
	 * valid sale multiplier to use
	 * @var float $VALID_SALE
	 **/
	protected $VALID_SALE = .8;

	/**
	 * test inserting a valid Product and verifying that the actual mySQL data matches
	 **/
	public function testInsertValidProduct() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert it into mySQL
		$product = new Product(null, $this->VALID_TITLE, $this->VALID_PRICE, $this->VALID_DESCRIPTION, $this->VALID_INVENTORY, $this->VALID_SALE);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProduct->getTitle(), $this->VALID_TITLE);
		$this->assertSame($pdoProduct->getPrice(), $this->VALID_PRICE);
		$this->assertSame($pdoProduct->getDescription(), $this->VALID_DESCRIPTION);
		$this->assertSame($pdoProduct->getInventory(), $this->VALID_INVENTORY);
		$this->assertSame($pdoProduct->getSale(), $this->VALID_SALE);
	}
	/**
	 * test inserting a Product which is invalid
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProduct() {
		// create a product with a non null productId that fails
		$product = new Product(CheqoutTest::INVALID_KEY, $this->VALID_TITLE, $this->VALID_PRICE, $this->VALID_DESCRIPTION, $this->VALID_INVENTORY, $this->VALID_SALE);
		$product->insert($this->getPDO());
	}
	/**
	 * test inserting a Product, editing it, and then updating it
	 **/
	public function testUpdateValidProduct() {
		// count the number of rows and save that number in $numRows
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert into db using MySQL
		$product = new Product(null, $this->VALID_TITLE, $this->VALID_PRICE, $this->VALID_DESCRIPTION, $this->VALID_INVENTORY, $this->VALID_SALE);
		$product->insert($this->getPDO());

		// edit the Product and update it in the db
		$product->setProductTitle($this->VALID_TITLE2);
		$product->update($this->getPDO());

		// grab the data from db and enforce the fields match our expectations
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProduct->getTitle(), $this->VALID_TITLE2);
		$this->assertSame($pdoProduct->getPrice(), $this->VALID_PRICE);
		$this->assertSame($pdoProduct->getDescription(), $this->VALID_DESCRIPTION);
		$this->assertSame($pdoProduct->getInventory(), $this->VALID_INVENTORY);
		$this->assertSame($pdoProduct->getSale(), $this->VALID_SALE);
	}
	/**
	 * test updating a Product that doesn't exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidProduct() {
		// create a Product and try to update it without actually inserting it
		$product = new Product(null, $this->VALID_TITLE, $this->VALID_PRICE, $this->VALID_DESCRIPTION, $this->VALID_INVENTORY, $this->VALID_SALE);
		$product->update($this->getPDO());
	}
	/**
	 * test creating a Product and then deleting it
	 **/
	public function testDeleteValidProduct() {
		// count the number of rows and save that value in $numRows
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert into db
		$product = new Product(null, $this->VALID_TITLE, $this->VALID_PRICE, $this->VALID_DESCRIPTION, $this->VALID_INVENTORY, $this->VALID_SALE);
		$product->insert($this->getPDO());

		// delete the Product from the db
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$product->delete($this->getPDO());

		// grab the data from MySQL and check that the Profile does not exist
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertNull($pdoProduct);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("product"));
	}
	/**
	 * test deleting a Product that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidProduct() {
		// create a Product and try to delete it without actually inserting it
		$product = new Product(null, $this->VALID_TITLE, $this->VALID_PRICE, $this->VALID_DESCRIPTION, $this->VALID_INVENTORY, $this->VALID_SALE);
		$product->delete($this->getPDO());
	}
	/**
	 * test inserting a Product and then accessing that Product by product id
	 **/
	public function testGetValidProductByProductId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->VALID_TITLE, $this->VALID_PRICE, $this->VALID_DESCRIPTION, $this->VALID_INVENTORY, $this->VALID_SALE);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProduct->getTitle(), $this->VALID_TITLE);
		$this->assertSame($pdoProduct->getPrice(), $this->VALID_PRICE);
		$this->assertSame($pdoProduct->getDescription(), $this->VALID_DESCRIPTION);
		$this->assertSame($pdoProduct->getInventory(), $this->VALID_INVENTORY);
		$this->assertSame($pdoProduct->getSale(), $this->VALID_SALE);
	}
	/**
	 * test grabbing a Product by product id that does not exist
	 **/
	public function testGetInvalidProductByProductId() {
		// grab a product id that exceeds the maximum allowable product id
		$product = Product::getProductByProductId($this->getPDO(), CheqoutTest::INVALID_KEY);
		$this->assertNull($product);
	}
	/**
	 * test inserting a Product and then accessing that Product by product title
	 **/
	public function testGetValidProductByProductTitle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->VALID_TITLE, $this->VALID_PRICE, $this->VALID_DESCRIPTION, $this->VALID_INVENTORY, $this->VALID_SALE);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByProductTitle($this->getPDO(), $product->getProductTitle());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProduct->getTitle(), $this->VALID_TITLE);
		$this->assertSame($pdoProduct->getPrice(), $this->VALID_PRICE);
		$this->assertSame($pdoProduct->getDescription(), $this->VALID_DESCRIPTION);
		$this->assertSame($pdoProduct->getInventory(), $this->VALID_INVENTORY);
		$this->assertSame($pdoProduct->getSale(), $this->VALID_SALE);
	}
	/**
	 * test grabbing a Product by invalid product title
	 **/
	public function testGetInvalidProductByProductTitle() {
		// grab a product title that's null
		$product = Product::getProductByProductTitle($this->getPDO(), $this->INVALID_TITLE);
		$this->assertNull($product);
	}
	/**
	 * test inserting a Product and then accessing that Product by product description
	 **/
	public function testGetValidProductByProductDescription() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->VALID_TITLE, $this->VALID_PRICE, $this->VALID_DESCRIPTION, $this->VALID_INVENTORY, $this->VALID_SALE);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByProductDescription($this->getPDO(), $product->getProductDescription());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProduct->getTitle(), $this->VALID_TITLE);
		$this->assertSame($pdoProduct->getPrice(), $this->VALID_PRICE);
		$this->assertSame($pdoProduct->getDescription(), $this->VALID_DESCRIPTION);
		$this->assertSame($pdoProduct->getInventory(), $this->VALID_INVENTORY);
		$this->assertSame($pdoProduct->getSale(), $this->VALID_SALE);
	}
	/**
	 * test grabbing a Product by invalid product description
	 **/
	public function testGetInvalidProductByProductDescription() {
		// grab a product description that's null
		$product = Product::getProductByProductDescription($this->getPDO(), $this->INVALID_DESCRIPTION);
		$this->assertNull($product);
	}
}