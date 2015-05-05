<?php
/**
 * Product class
 *
 * This is a class containing a minimal amount of identifying information about
 * a product from the Cheqout online store. This could be extended to include
 * state variables such as stock availability or production number.
 *
 * @author James Hill <jhill67@cnm.edu>
 **/

class Product {
	/**
	 * This is the product id, which is also the primary key
	 *
	 * @var int $productId
	 **/
	protected $productId;
	/**
	 * This is the product description
	 *
	 * @var string $productDescription
	 **/
	protected $productDescription;
	/**
	 * This is the product price
	 *
	 * @var float $productPrice
	 **/
	protected $productPrice;
	/**
	 * Getter method for product id
	 *
	 * @return int value of product id
	 **/
	public function getProductId() {
		return($this->productId);
	}
	/**
	 * Setter method for product id
	 *
	 * @param int $newProductId new value for product id
	 * @throws UnexpectedValueException if $newProductId is not an integer
	 **/
	public function setProductId($newProductId) {
		//base case, if product id is null this is a new database entry without id
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
	 * Getter method for product description
	 *
	 * @return string $productDescription
	 **/
	public function getProductDescription() {
		return($this->productDescription);
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

		//if it passes without exception, store the new value
		$this->productDescription = $newProductDescription;
	}
	/**
	 * Getter method for product price
	 *
	 * @return float $productPrice
	 **/
	public function getProductPrice() {
		return($this->productPrice);
	}
	/**
	 * Setter method for product price
	 *
	 * @param float $newProductPrice
	 * @throws UnexpectedValueException if $newProductPrice is not valid
	 **/
	public function setProductPrice($newProductPrice) {
		$newProductPrice = filter_var($newProductPrice, FILTER_SANITIZE_NUMBER_FLOAT);
		if($newProductPrice === false) {
			throw(new UnexpectedValueException("product price not a valid float value"));
		}

		//if $newProductPrice is valid, store in $productPrice via floatval() for added security
		$this->productPrice = floatval($newProductPrice);
	}
	/**
	 * Magic method __construct() for Product class
	 *
	 * @param int $newProductId for product id
	 * @param string $newProductDescription for product description
	 * @param float $newProductPrice for product price
	 * @throws UnexpectedValueException in case any of the methods throw an exception
	 **/
	public function __construct($newProductId, $newProductDescription, $newProductPrice) {
		//attempt to set new field values
		try {
			$this->setProductId($newProductId);
			$this->setProductDescription($newProductDescription);
			$this->setProductPrice($newProductPrice);
		} catch(UnexpectedValueException $exception) {
			//rethrow to handle exceptions outside the constructor
			throw(new UnexpectedValueException("unable to construct Product object",0,$exception));
		}
	}
	/**
	 * Magic method __toString() for constructor output
	 *
	 * @return string HTML formatted Product output
	 **/
	public function __toString() {
		//create HTML formatted output table
		$html = "<table border='1' style='width:100%'"
			.		"<tr>"
			.			"<td>" . "Product ID" . "</td>"
			.			"<td>" . "Product Description" . "</td>"
			.			"<td>" . "Product Price" . "</td>"
			.		"</tr>"
			.		"<tr>"
			.			"<td>" . $this->productId . "</td>"
			.			"<td>" . $this->productDescription . "</td>"
			.			"<td>" . $this->productPrice . "</td>"
			.		"</tr>"
			. "</table>";
		return($html);
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
			throw(new PDOException("not a new product id"));
		}

		//create query template
		$query = <<< EOF
			INSERT INTO product(productDescription, productPrice)
			VALUES(:productDescription, :productPrice)
EOF;
		$statement = $pdo->prepare($query);

		//bind member variables to placeholders in query template
		$parameters = array(
			"productDescription" => $this->productDescription,
			"productPrice" => $this->productPrice
		);
		$statement->execute($parameters);

		//update the null product id value with the MySQL-assigned database id
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
			throw(new PDOException("can't delete row, doesn't exist"));
		}

		//create delete query template string
		$query = "DELETE FROM product WHERE productId = :productId";
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
			throw(new PDOException("no update for you!"));
		}

		//create update query template
		$query = "UPDATE product SET productId = :productId,
						productDescription = :productDescription,
						productPrice = :productPrice WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		//bind member variables to template placeholders
		$parameters = array("productId" => $this->productId,
			"productDescription" => $this->productDescription,
			"productPrice" => $this->productPrice
		);
		$statement->execute($parameters);
	}
	/**
	 *Gets product by product id, primary key
	 *
	 *@param PDO $pdo pointer to pdo MySQL connection by reference
	 *@param int $productId primary key to search by
	 *@return mixed Product object or null if not found
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
		$query = "SELECT productId, productDescription, productPrice FROM product WHERE productId = :productId";
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
				$product = new Product($row["productId"], $row["productDescription"], $row["productPrice"]);
			}

		} catch(Exception $exception) {
			throw(new PDOException($exception->getMessage(),0,$exception));
		}
		return($product);
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
		$query = "SELECT productId, productDescription, productPrice FROM product
					WHERE productDescription LIKE :productDescription";
		$statement = $pdo->prepare($query);

		//bind product description to pdo placeholder in query template
		$productDescription = "%$productDescription%";
		$parameters = array("productDescription" => $productDescription);
		$statement->execute($parameters);

		//create array of products found
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch() !== false)) {
			try {
				$product = new Product($row["productId"], $row["productDescription"], $row["productPrice"]);
				$products[$products->key()] = $product;
				$products->next();
			} catch(Exception $exception) {
				//rethrow exception if new Product object cannot be converted to array
				throw(new PDOException($exception->getMessage(),0,$exception));
			}

			//Count the results in the array, null for 0 rows, entire result set for rows >= 1
			$numberOfProducts = count($products);
			if($numberOfProducts === 0) {
				return(null);
			} else {
				return($products);
			}
		}
	}

}

