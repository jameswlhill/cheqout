<?php
/**
 * Product class
 *
 * This is a class containing the minimum necessary amount of identifying information about
 * a product from the Cheqout online store.
 *
 * @author James Hill <james@appists.com>
 **/

class Product {
	/**
	 * This is the product id, which is also the primary key
	 *
	 * @var int $productId
	 **/
	protected $productId;
	/**
	 * This is the product title
	 *
	 * @var string $productTitle
	 **/
	protected $productTitle;
	/**
	 * This is the product price
	 *
	 * @var float $productPrice
	 **/
	protected $productPrice;
	/**
	 * This is the product description
	 *
	 * @var string $productDescription
	 **/
	protected $productDescription;
	/**
	 * This is the product inventory
	 *
	 * @var int $productInventory
	 **/
	protected $productInventory;
	/**
	 * This is the multiplier for a product on sale
	 *
	 * @var float $productSale
	 **/
	protected $productSale;

	/**
	 * Magic method __construct() for Product class
	 *
	 * @param int $newProductId for product id
	 * @param string $newProductTitle
	 * @param float $newProductPrice for product price
	 * @param string $newProductDescription for product description
	 * @param int $newProductInventory for product inventory
	 * @param int $newProductSale for product sale multiplier
	 * @throws UnexpectedValueException in case any of the methods throw an exception
	 **/
	public function __construct($newProductId, $newProductTitle, $newProductPrice, $newProductDescription, $newProductInventory, $newProductSale) {
		//attempt to set new field values
		try {
			$this->setProductId($newProductId);
			$this->setProductTitle($newProductTitle);
			$this->setProductPrice($newProductPrice);
			$this->setProductDescription($newProductDescription);
			$this->setProductInventory($newProductInventory);
			$this->setProductSale($newProductSale);
		} catch(UnexpectedValueException $exception) {
			//rethrow to handle exceptions outside the constructor
			throw(new UnexpectedValueException("unable to construct Product object", 0, $exception));
		}
	}

	/**
	 * Getter method for product id
	 *
	 * @return int value of product id
	 **/
	public function getProductId() {
		return ($this->productId);
	}

	/**
	 * Setter method for product id
	 *
	 * @param int $newProductId new value for product id
	 * @throws UnexpectedValueException if $newProductId is not an integer
	 **/
	public function setProductId($newProductId) {
		//base case, if product id is null this is a new database entry without a current id
		if($newProductId === null) {
			$this->productId = null;
			return;
		}

		//verify new product id is a valid integer
		$newProductId = filter_var($newProductId, FILTER_VALIDATE_INT);
		if($newProductId === false) {
			throw(new UnexpectedValueException("product id not a valid integer"));
		}

		//verify product id is positive
		if($newProductId <= 0) {
			throw(new RangeException("product id is not positive"));
		}

		//if no exception thrown, use intval for added security and store the new id
		$this->productId = intval($newProductId);
	}

	/**
	 * Getter method for product title
	 *
	 * @return string title of product
	 **/
	public function getProductTitle() {
		return ($this->productTitle);
	}

	/**
	 * Setter method for product title
	 *
	 * @param string $newProductTitle
	 * @throws UnexpectedValueException if $newProductTitle is not valid
	 **/
	public function setProductTitle($newProductTitle) {
		//validate $newProductTitle as a valid string
		$newProductTitle = filter_var($newProductTitle, FILTER_SANITIZE_STRING);
		if($newProductTitle === false) {
			throw(new UnexpectedValueException("product title is not a valid string"));
		}

		//if it passes without exception, store the new string
		$this->productTitle = $newProductTitle;
	}

	/**
	 * Getter method for product price
	 *
	 * @return float $productPrice
	 **/
	public function getProductPrice() {
		return ($this->productPrice);
	}

	/**
	 * Setter method for product price
	 *
	 * @param float $newProductPrice
	 * @throws UnexpectedValueException if $newProductPrice is not valid
	 **/
	public function setProductPrice($newProductPrice) {
		$newProductPrice = filter_var($newProductPrice, FILTER_VALIDATE_FLOAT);
		if($newProductPrice === false) {
			throw(new UnexpectedValueException("product price not a valid float value"));
		}

		//if $newProductPrice is valid, store in $productPrice via floatval() for added security
		$this->productPrice = floatval($newProductPrice);
	}

	/**
	 * Getter method for product description
	 *
	 * @return string $productDescription
	 **/
	public function getProductDescription() {
		return ($this->productDescription);
	}

	/**
	 * Setter method for product description
	 *
	 * @param string $newProductDescription
	 * @throws UnexpectedValueException if $newProductDescription is not valid
	 **/
	public function setProductDescription($newProductDescription) {
		//validate $newProductDescription as valid string
		$newProductDescription = filter_var($newProductDescription, FILTER_SANITIZE_STRING);
		if($newProductDescription === false) {
			throw(new UnexpectedValueException("product description not a valid string"));
		}

		//if it passes without exception, store the new string
		$this->productDescription = $newProductDescription;
	}

	/**
	 * Getter method for product inventory
	 *
	 * @return int $productInventory
	 **/
	public function getProductInventory() {
		return ($this->productInventory);
	}

	/**
	 * Setter method for product inventory
	 *
	 * @param int $newProductInventory
	 * @throws UnexpectedValueException if $newProductInventory is not valid
	 **/
	public function setProductInventory($newProductInventory) {
		//base case, if product inventory is null this is a new product category without a current value
		if($newProductInventory === null) {
			$this->productInventory = null;
			return;
		}

		//verify new product inventory is a valid integer
		$newProductInventory = filter_var($newProductInventory, FILTER_VALIDATE_INT);
		if($newProductInventory === false) {
			throw(new UnexpectedValueException("new product inventory is not a valid integer"));
		}

		//verify product inventory quantity is a positive number if not null
		if($newProductInventory <= 0) {
			throw(new RangeException("new product inventory is not a positive integer"));
		}

		//if no exception is thrown, use intval for added security and store the new value
		$this->productInventory = intval($newProductInventory);
	}

	/**
	 * Getter method for product sale multiplier
	 *
	 * @return int $productSale
	 **/
	public function getProductSale() {
		return ($this->productSale);
	}

	/**
	 * Setter method for product sale multiplier
	 *
	 * @param float $newProductSale
	 * @throws UnexpectedValueException if $newProductSale is not a valid decimal value
	 **/
	public function setProductSale($newProductSale) {
		//base case, if sale multiplier is null and has not yet been set
		if($newProductSale === null) {
			$this->productSale = null;
			return;
		}

		//verify new product sale multiplier is a valid integer
		$newProductSale = filter_var($newProductSale, FILTER_VALIDATE_FLOAT);
		if($newProductSale === false) {
			throw(new UnexpectedValueException("new product sale multiplier is not a valid value"));
		}

		//verify new sale multiplier is a positive decimal value if not null
		if($newProductSale <= 0) {
			throw(new RangeException("new product sale multiplier is not positive"));
		}

		//if no exception thrown, use floatval for added security and store the new value
		$this->productSale = floatval($newProductSale);
	}

	/**
	 * Magic method __toString() for constructor output
	 *
	 * @return string HTML formatted Product output
	 **/
	public function __toString() {
		//create HTML formatted output table
		$html = "<table border='1' style='width:100%'"
			. "<tr>"
			. "<td>" . "Product ID" . "</td>"
			. "<td>" . "Product Title" . "</td>"
			. "<td>" . "Product Price" . "</td>"
			. "<td>" . "Product Description" . "</td>"
			. "<td>" . "Product Inventory" . "</td>"
			. "<td>" . "Product Sale Multiplier" . "</td>"
			. "</tr>"
			. "<tr>"
			. "<td>" . $this->productId . "</td>"
			. "<td>" . $this->productTitle . "</td>"
			. "<td>" . $this->productPrice . "</td>"
			. "<td>" . $this->productDescription . "</td>"
			. "<td>" . $this->productInventory . "</td>"
			. "<td>" . $this->productSale . "</td>"
			. "</tr>"
			. "</table>";
		return ($html);
	}

	/**
	 * Insert product into MySQL database
	 *
	 * @param PDO $pdo pointer to pdo connection by reference
	 * @throws PDOException on MySQL errors
	 **/
	public function insert(PDO &$pdo) {
		//make sure initial product id value in db is null so that you're not inserting a pre-existing row
		if($this->productId !== null) {
			throw(new PDOException("lo siento, not a new product id"));
		}

		//create query template
		$query = <<< EOF
			INSERT INTO product(productTitle, productPrice, productDescription, productInventory, productSale )
			VALUES(:productTitle, :productPrice, :productDescription, :productInventory, :productSale )
EOF;
		$statement = $pdo->prepare($query);

		//bind member variables to placeholders in query template
		$parameters = array(
			"productTitle" => $this->productTitle,
			"productPrice" => $this->productPrice,
			"productDescription" => $this->productDescription,
			"productInventory" => $this->productInventory,
			"productSale" => $this->productSale
		);
		$statement->execute($parameters);

		//update the null php-version product id value with the MySQL-assigned database id
		$this->productId = intval($pdo->lastInsertId());
	}

	/**
	 * Deletes product from MySQL database
	 *
	 * @param PDO $pdo pointer to pdo connection by reference
	 * @throws PDOException when MySQL error occurs
	 **/
	public function delete(PDO &$pdo) {
		//check to see if product id is null so that you don't try to delete an entry that doesn't exist
		if($this->productId === null) {
			throw(new PDOException("can't delete a row that doesn't exist"));
		}

		//create delete query template string
		$query = <<< EOF
			DELETE FROM product WHERE productId = :productId
EOF;
		$statement = $pdo->prepare($query);

		//bind member variables to placeholders
		$parameters = array("productId" => $this->productId);
		$statement->execute($parameters);

	}

	/**
	 * Update product in MySQL database
	 *
	 * @param PDO $pdo pointer to pdo connection by reference
	 * @throws PDOException when MySQL errors occurs
	 **/
	public function update(PDO &$pdo) {
		//make sure product id field is not null, since there's no point adding superfluous request traffic
		if($this->productId === null) {
			throw(new PDOException("can't update record that doesn't exist"));
		}

		//create update query template
		$query = "UPDATE product SET
						productId = :productId,
						productTitle = :productTitle,
						productPrice = :productPrice,
						productDescription = :productDescription,
						productInventory = :productInventory,
						productSale = :productSale
						 WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		//bind member variables to template placeholders
		$parameters = array(
			"productId" => $this->productId,
			"productTitle" => $this->productTitle,
			"productPrice" => $this->productPrice,
			"productDescription" => $this->productDescription,
			"productInventory" => $this->productInventory,
			"productSale" => $this->productSale
		);
		$statement->execute($parameters);
	}

	/**
	 *Gets product by product id, primary key
	 *
	 * @param PDO $pdo pointer to pdo MySQL connection by reference
	 * @param int $productId primary key to search by
	 * @return mixed Product object or null if not found
	 * @throws PDOException if MySQL error(s) occur
	 **/
	public static function getProductByProductId(PDO &$pdo, $productId) {
		//validate productId int before proceeding with search
		$productId = filter_var($productId, FILTER_VALIDATE_INT);
		if($productId === false) {
			throw(new PDOException("product id is not a valid integer"));
		}
		if($productId <= 0) {
			throw(new PDOException("product id must be a positive integer"));
		}

		//create query string template and pdo->prepare the query
		$query = "SELECT productId, productTitle, productPrice, productDescription, productInventory,
				productSale FROM product WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		//bind member variable to pdo placeholder in query template
		$parameters = array("productId" => $productId);
		$statement->execute($parameters);

		//retrieve the product from MySQL database
		try {
			$product = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				var_dump($row);
				$product = new Product($row["productId"], $row["productTitle"], $row["productPrice"], $row["productDescription"], $row["productInventory"], $row["productSale"]);
			}

		} catch(Exception $exception) {
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return ($product);
	}

	/**
	 * Get Product by description
	 *
	 * @param PDO &$pdo pointer to pdo MySQL connection by reference
	 * @param string $productDescription product description string to search for
	 * @return mixed SplFixedArray of Product(s) matching description string
	 * @throws PDOException if any MySQL related errors occur
	 **/
	public static function getProductByProductDescription(PDO &$pdo, $productDescription) {
		//sanitize the search string before attempting any matches
		$productDescription = trim($productDescription);
		$productDescription = filter_var($productDescription, FILTER_SANITIZE_STRING);
		if(empty($productDescription) === true) {
			throw(new PDOException("search invalid"));
		}

		//create MySQL query template
		$query = "SELECT productId, productTitle, productPrice, productDescription, productInventory, productSale FROM product
					WHERE productDescription LIKE :productDescription";
		$statement = $pdo->prepare($query);

		//bind product description to pdo placeholder in query template
		$productDescription = "%$productDescription%";
		$parameters = array("productDescription" => $productDescription);
		$statement->execute($parameters);

		//create array of products found
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"], $row["productTitle"], $row["productPrice"], $row["productDescription"], $row["productInventory"], $row["productSale"]);
				$products[$products->key()] = $product;
				$products->next();
			} catch(Exception $exception) {
				//rethrow exception if new Product object cannot be converted to array
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}

			//Count the results in the array, null for 0 rows, entire result set for rows >= 1
			$numberOfProducts = count($products);
			if($numberOfProducts === 0) {
				return (null);
			} else {
				return ($products);
			}
		}
	}


	/**
	 * Get Product by title
	 *
	 * @param PDO &$pdo pointer to pdo MySQL connection by reference
	 * @param string $productTitle product title string to search for
	 * @return mixed SplFixedArray of Product(s) matching title string
	 * @throws PDOException if any MySQL related errors occur
	 **/
	public static function getProductByProductTitle(PDO &$pdo, $productTitle) {
		//sanitize the search string before attempting any matches
		$productTitle = trim($productTitle);
		$productTitle = filter_var($productTitle, FILTER_SANITIZE_STRING);
		if(empty($productTitle) === true) {
			throw(new PDOException("search invalid"));
		}

		//create MySQL query template
		$query = "SELECT productId, productTitle, productPrice, productDescription, productInventory, productSale FROM product
					WHERE productTitle LIKE :productTitle";
		$statement = $pdo->prepare($query);

		//bind product description to pdo placeholder in query template
		$productTitle = "%$productTitle%";
		$parameters = array("productTitle" => $productTitle);
		$statement->execute($parameters);

		//create array of products found
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"], $row["productTitle"], $row["productPrice"], $row["productDescription"], $row["productInventory"], $row["productSale"]);
				$products[$products->key()] = $product;
				$products->next();
			} catch(Exception $exception) {
				//rethrow exception if new Product object cannot be converted to array
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}

			//Count the results in the array, null for 0 rows, entire result set for rows >= 1
			$numberOfProducts = count($products);
			if($numberOfProducts === 0) {
				return (null);
			} else {
				return ($products);
			}
		}
	}

	/**
	 * Get all products
	 *
	 * @param PDO &$pdo pointer to pdo MySQL connection by reference
	 * @return mixed SplFixedArray of products found or null if not found
	 * @throws PDOException if any MySQL related errors occur
	 **/
	public static function getAllProducts(PDO $pdo) {
		//create query template
		$query = "SELECT productId, productTitle, productPrice, productDescription, productInventory, productSale FROM product";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build array of products
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch() !== false)) {
			try {
				$product = new Product($row["productId"], $row["productTitle"], $row["productPrice"], $row["productDescription"], $row["productInventory"], $row["productSale"]);
				$products[$products->key()] = $product;
				$products->next();
			} catch(Exception $exception) {
				//rethrow exception if new Product object cannot be converted to array
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}

			//Count the results in the array, null for 0 rows, entire result set for rows >= 1
			$numberOfProducts = count($products);
			if($numberOfProducts === 0) {
				return (null);
			} else {
				return ($products);
			}
		}
	}
}

