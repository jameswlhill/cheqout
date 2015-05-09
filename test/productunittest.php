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
		$pdoProfile = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProduct->getTitle(), $this->VALID_TITLE);
		$this->assertSame($pdoProduct->getPrice(), $this->VALID_PRICE);
		$this->assertSame($pdoProduct->getDescription(), $this->VALID_DESCRIPTION);
		$this->assertSame($pdoProduct->getInventory(), $this->VALID_INVENTORY);
		$this->assertSame($pdoProduct->getSale(), $this->VALID_SALE);
	}
}