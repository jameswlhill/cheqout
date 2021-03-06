<?php
/**
 * ProductOrder Class
 *
 * This class is a weak entity composed of elements from the Product and CheqoutOrder classes.
 * It contains pertinent information concerning customer identification and checkout details,
 * such as shipping costs, unit quantities, and total checkout price.
 *
 * @author James Hill <james@appists.com>
 **/

class ProductOrder {
	/**
	 * This is the checkout id referencing $orderId in the CheqoutOrder class. It is one of two
	 * id's which make up the composite primary key for the productOrder table.
	 *
	 * @var int $orderId
	 **/
	protected $orderId;
	/**
	 * This is the product id referencing the $productId in the Product class. It is the second of two
	 * id's constituting the composite primary key for the productOrder table.
	 *
	 * @var int $productId
	 **/
	protected $productId;
	/**
	 * This is the specific quantity of units ordered by the customer
	 *
	 * @var int $quantity
	 **/
	protected $quantity;
	/**
	 * This is the flat-rate shipping cost for the checkout
	 *
	 * @var float $shippingCost
	 **/
	protected $shippingCost;
	/**
	 * This is the checkout total
	 *
	 * @var float $orderPrice
	 **/
	protected $orderPrice;

	/**
	 * Magic method __construct() for ProductOrder class
	 *
	 * @param int $newOrderId for checkout id
	 * @param int $newProductId for product id
	 * @param int $newQuantity for units shipped
	 * @param float $newShippingCost for flat rate shipping charges
	 * @param float $newOrderPrice for checkout price total
	 * @throws UnexpectedValueException in case any of the methods throw an exception
	 **/
	public function __construct($newOrderId, $newProductId, $newQuantity, $newShippingCost, $newOrderPrice) {
		//attempt to set new field values
		try {
			$this->setOrderId($newOrderId);
			$this->setProductId($newProductId);
			$this->setQuantity($newQuantity);
			$this->setShippingCost($newShippingCost);
			$this->setOrderPrice($newOrderPrice);
		} catch(UnexpectedValueException $exception) {
			//rethrow to handle exceptions outside the constructor
			throw(new UnexpectedValueException("unable to construct ProductOrder object", 0, $exception));
		}
	}

	/**
	 * Getter method for checkout id
	 *
	 * @return int value of checkout id
	 **/
	public function getOrderId() {
		return ($this->orderId);
	}

	/**
	 * Setter method for checkout id
	 *
	 * @param int $newOrderId new value for checkout id
	 * @throws UnexpectedValueException if $newOrderId is not an integer
	 **/
	public function setOrderId($newOrderId) {
		//verify new checkout id is a valid integer
		$newOrderId = filter_var($newOrderId, FILTER_VALIDATE_INT);
		if($newOrderId === false) {
			throw(new UnexpectedValueException("checkout id not a valid integer"));
		}

		//verify checkout id is positive
		if($newOrderId <= 0) {
			throw(new RangeException("checkout id is not positive"));
		}

		//if no exception thrown, use intval for added security and store the new id
		$this->orderId = intval($newOrderId);
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
	 * Getter method for checkout quantity
	 *
	 * @return int value of checkout quantity
	 **/
	public function getQuantity() {
		return ($this->quantity);
	}

	/**
	 * Setter method for checkout quantity
	 *
	 * @param int $newQuantity
	 * @throws UnexpectedValueException if $newQuantity is not valid
	 **/
	public function setQuantity($newQuantity) {
		//verify checkout quantity is a valid integer
		$newQuantity = filter_var($newQuantity, FILTER_VALIDATE_INT);
		if($newQuantity === false) {
			throw(new UnexpectedValueException("checkout quantity is not a valid integer"));
		}

		//verify quantity is a positive number
		if($newQuantity <= 0) {
			throw(new RangeException("checkout quantity is not a positive integer"));
		}

		//if no exception is thrown, use intval for added security and store the value
		$this->quantity = intval($newQuantity);
	}

	/**
	 * Getter method for shipping cost
	 *
	 * @return float value of shipping cost
	 **/
	public function getShippingCost() {
		return ($this->shippingCost);
	}

	/**
	 * Setter method for shipping cost
	 *
	 * @param float $newShippingCost
	 * @throws UnexpectedValueException if $newShippingCost is not valid
	 **/
	public function setShippingCost($newShippingCost) {
		//validate float value of shipping cost
		$newShippingCost = filter_var($newShippingCost, FILTER_VALIDATE_FLOAT);
		if($newShippingCost === false) {
			throw(new UnexpectedValueException("shipping cost is not a valid float value"));
		}

		//if $newShippingCost is valid, store in $shippingCost via floatval() for added security
		$this->shippingCost = floatval($newShippingCost);
	}

	/**
	 * Getter method for total checkout price
	 *
	 * @return float value of total checkout price
	 **/
	public function getOrderPrice() {
		return ($this->orderPrice);
	}

	/**
	 * Setter method for total checkout price
	 *
	 * @param float $newOrderPrice
	 * @throws UnexpectedValueException if $newOrderPrice is not valid
	 **/
	public function setOrderPrice($newOrderPrice) {
		//validate float value of total checkout price
		$newOrderPrice = filter_var($newOrderPrice, FILTER_VALIDATE_FLOAT);
		if($newOrderPrice === false) {
			throw(new UnexpectedValueException("total checkout price is not a valid float value"));
		}

		//if $newOrderPrice is valid, store in $orderPrice via floatval() for added security
		$this->orderPrice = floatval($newOrderPrice);
	}

	/**
	 * Magic method __toString() for constructor output
	 *
	 * @return string HTML formatted ProductOrder output
	 **/
	public function __toString() {
		//create HTML formatted output table
		$html = "<table border='1' style='width:100%'"
			. "<tr>"
			. "<td>" . "Order ID" . "</td>"
			. "<td>" . "Product ID" . "</td>"
			. "<td>" . "Quantity" . "</td>"
			. "<td>" . "Shipping Cost" . "</td>"
			. "<td>" . "Order Price" . "</td>"
			. "</tr>"
			. "<tr>"
			. "<td>" . $this->orderId . "</td>"
			. "<td>" . $this->productId . "</td>"
			. "<td>" . $this->quantity . "</td>"
			. "<td>" . $this->shippingCost . "</td>"
			. "<td>" . $this->orderPrice . "</td>"
			. "</tr>"
			. "</table>";
		return ($html);
	}

	/**
	 * Insert productOrder into MySQL database
	 *
	 * @param PDO $pdo pointer to pdo connection by reference
	 * @throws PDOException on MySQL errors
	 **/
	public function insert(PDO &$pdo) {
		//make sure initial checkout and product id's in db are not null (because they are being used here as foreign key components of a composite primary key)
		if($this->orderId === null || $this->productId === null) {
			throw(new PDOException("this is not a new ProductOrder"));
		}

		//create query template
		$query = <<< EOF
			INSERT INTO productOrder(orderId, productId, quantity, shippingCost, orderPrice )
			VALUES(:orderId, :productId, :quantity, :shippingCost, :orderPrice )
EOF;
		$statement = $pdo->prepare($query);

		//bind member variables to placeholders in query template
		$parameters = array(
			"orderId" => $this->orderId,
			"productId" => $this->productId,
			"quantity" => $this->quantity,
			"shippingCost" => $this->shippingCost,
			"orderPrice" => $this->orderPrice
		);
		$statement->execute($parameters);
	}

	/**
	 * Deletes a product checkout from MySQL database
	 *
	 * @param PDO $pdo pointer to pdo connection by reference
	 * @throws PDOException when MySQL error occurs
	 **/
	public function delete(PDO &$pdo) {
		//check to see if checkout id and product id are null so that you don't try to delete an entry that doesn't exist
		if($this->orderId === null && $this->productId === null) {
			throw(new PDOException("can't delete a row that doesn't exist"));
		}

		//create delete query template string
		$query = <<< EOF
			DELETE FROM productOrder WHERE productId = :productId AND orderId = :orderId
EOF;
		$statement = $pdo->prepare($query);

		//bind member variables to placeholders
		$parameters = array("productId" => $this->productId, "orderId" => $this->orderId);
		$statement->execute($parameters);

	}

	/**
	 * Update product checkout in MySQL database
	 *
	 * @param PDO $pdo pointer to pdo connection by reference
	 * @throws PDOException when MySQL errors occurs
	 **/
	public function update(PDO &$pdo) {
		//make sure product id and checkout id are not null, since there's no point adding superfluous request traffic
		if($this->orderId === null && $this->productId === null) {
			throw(new PDOException("can't update record that doesn't exist"));
		}

		//create update query template
		$query = "UPDATE productOrder SET
						orderId = :orderId,
						productId = :productId,
						quantity = :quantity,
						shippingCost = :shippingCost,
						orderPrice = :orderPrice
						 WHERE orderId = :orderId AND productId = :productId ";
		$statement = $pdo->prepare($query);

		//bind member variables to template placeholders
		$parameters = array(
			"orderId" => $this->orderId,
			"productId" => $this->productId,
			"quantity" => $this->quantity,
			"shippingCost" => $this->shippingCost,
			"orderPrice" => $this->orderPrice
		);
		$statement->execute($parameters);
	}
	/**
	 * Gets product checkout by composite primary key
	 *
	 * @param PDO $pdo pointer to pdo MySQL connection by reference
	 * @param int $orderId foreign key (one of two which make up primary)
	 * @param int $productId foreign key (one of two which make up primary)
	 * @return mixed ProductOrder object or null if not found
	 * @throws PDOException if MySQL error(s) occur
	 **/
	public static function getProductOrderByOrderIdAndProductId(PDO &$pdo, $orderId, $productId) {
		//validate orderId int and productId int before proceeding with search
		$orderId = filter_var($orderId, FILTER_VALIDATE_INT);
		$productId = filter_var($productId, FILTER_VALIDATE_INT);
		if($orderId === false && $productId === false) {
			throw(new PDOException("checkout id and/or product id are not valid integers"));
		}
		if($orderId <= 0 || $productId <= 0) {
			throw(new PDOException("checkout id and product id must be positive integers"));
		}


		//create query string template and pdo->prepare the query
		$query = "SELECT orderId, productId, quantity, shippingCost, orderPrice FROM productOrder WHERE orderId = :orderId AND productId = :productId";
		$statement = $pdo->prepare($query);

		//bind member variable to pdo placeholder in query template
		$parameters = array("orderId" => $orderId, "productId" => $productId);
		$statement->execute($parameters);

		//retrieve the product checkout from MySQL database
		try {
			$productOrder = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$productOrder = new ProductOrder($row["orderId"], $row["productId"], $row["quantity"], $row["shippingCost"], $row["orderPrice"]);
			}

		} catch(Exception $exception) {
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return ($productOrder);
	}

}
