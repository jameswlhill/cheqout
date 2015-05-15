<?php
/**
 * CheqoutOrder class
 *
 * this is the order class, with the primary key of orderId,
 * references the emailId and stripeId of the user who placed the order,
 * the shippingAddressId of whatever address was stored to be used for shipping.
 * creates the datetime of the order placement.
 *
 * @author Kyla Carroll <kylacarroll43@gmail.com>
 */

class CheqoutOrder {
	/**
	 * the order id, an auto-incrementing integer assigned when the order is placed
	 * @var int $orderId
	 */
	protected $orderId;
	/**
	 * the email Id of the user who made a purchase, this is a foreign key
	 * @var int $emailId
	 */
	protected $emailId;
	/**
	 * the address Id of the billing address put in by the user, this is used for stripe's API and is a foreign key
	 * @var int $billingAddressId
	 **/
	protected $billingAddressId;
	/**
	 * the address Id of the shipping address put in by the user, this is a foreign key
	 * @var int $shippingAddressId
	 **/
	protected $shippingAddressId;
	/**
	 * the users stripe Id used for purchase, provided via stripe's API, this is a foreign key
	 * @var string $stripeId
	 **/
	protected $stripeId;
	/**
	 * the generated date time of order placement
	 * @var string $orderDateTime
	 **/
	protected $orderDateTime;

	/**
	 * constructor magic method for Order
	 *
	 * @param int $newOrderId new value of orderId
	 * @param int $newEmailId new value of emailId
	 * @param int $newShippingAddressId new value of shippingAddressId
	 * @param string $newStripeId new value of stripeId
	 * @param string $newOrderDateTime new value of orderDateTime
	 * @throw UnexpectedValueException if any params are not valid
	 */
	public function __construct($newOrderId, $newEmailId, $newBillingAddressId, $newShippingAddressId, $newStripeId, $newOrderDateTime) {
		try {
			$this->setOrderId($newOrderId);
			$this->setEmailId($newEmailId);
			$this->setShippingAddressId($newShippingAddressId);
			$this->setBillingAddressId($newBillingAddressId);
			$this->setStripeId($newStripeId);
			$this->setOrderDateTime($newOrderDateTime);
		} catch (UnexpectedValueException $exception) {
			throw (new UnexpectedValueException("unable to create order", 0, $exception));
		}
	}

	/**
	 * accessor method for orderId
	 *
	 * @return int value of orderId
	 **/
	public function getOrderId() {
		return ($this->orderId);
	}

	/**
	 * mutator method for order Id
	 *
	 * @param int $newOrderId new value of orderId
	 * @throws InvalidArgumentException if $newOrderId is not an integer
	 **/
	public function setOrderId($newOrderId) {
		if ($newOrderId === null) {
			return;
		}
		$newOrderId = filter_var($newOrderId, FILTER_VALIDATE_INT);
		if ($newOrderId === false) {
			throw (new InvalidArgumentException("order ID is invalid"));
		}

		//store the new Order Id
		$this->orderId = intval($newOrderId);
	}

	/**
	 * accessor method for emailId
	 *
	 * @return int value of emailId
	 **/
	public function getEmailId() {
		return ($this->emailId);
	}

	/**
	 * mutator method for email Id
	 *
	 * @param int $newEmailId new value of emailId
	 * @throws InvalidArgumentException if $newEmailId is not an integer
	 **/
	public function setEmailId($newEmailId) {
		if ($newEmailId === null) {
			return;
		}
		$newEmailId = filter_var($newEmailId, FILTER_VALIDATE_INT);
		if ($newEmailId === false) {
			throw (new InvalidArgumentException("email ID is invalid"));
		}
		if(intval($newEmailId) > 4294967295) {
			throw(new RangeException("email Id too large"));
		}
		//store the new email Id
		$this->emailId = intval($newEmailId);
	}

	/**
	 * accessor method for billingAddressId
	 *
	 * @return int value of billingAddressId
	 **/
	public function getBillingAddressId() {
		return ($this->billingAddressId);
	}
	
	/**
	 * mutator method for billingAddressId
	 *
	 * @param int $newBillingAddressId new value for BillingAddressId
	 * @throw UnexpectedValueException if $newBillingAddressId is not a valid integer
	 **/
	public function setBillingAddressId($newBillingAddressId) {
		if ($newBillingAddressId === null) {
			return;
		}
		$newBillingAddressId = filter_var($newBillingAddressId, FILTER_VALIDATE_INT);
		if($newBillingAddressId === false) {
			throw (new UnexpectedValueException(" billing address ID is invalid"));
		}
		if(intval($newBillingAddressId) > 4294967295) {
			throw(new RangeException("billing address id too large"));
		}
		//store the new address Id
		$this->billingAddressId = intval($newBillingAddressId);
	}

	/**
	 * accessor method for shippingAddressId
	 *
	 * @return int value of shippingAddressId
	 **/
	public function getShippingAddressId() {
		return ($this->shippingAddressId);
	}

	/**
	 * mutator method for shippingAddressId
	 *
	 * @param int $newShippingAddressId new value for shippingAddressId
	 * @throw UnexpectedValueException if $newShippingAddressId is not a valid integer
	 **/
	public function setShippingAddressId($newShippingAddressId) {
		if ($newShippingAddressId === null) {
			return;
		}
		$newShippingAddressId = filter_var($newShippingAddressId, FILTER_VALIDATE_INT);
		if($newShippingAddressId === false) {
			throw (new UnexpectedValueException(" shipping address ID is invalid"));
		}
		if(intval($newShippingAddressId) > 4294967295) {
			throw(new RangeException("shipping id too large"));
		}
		//store the new address Id
		$this->shippingAddressId = intval($newShippingAddressId);
	}

	/**
	 * accessor method for stripeId
	 *
	 * @return string value of stripeId
	 **/
	public function getStripeId() {
		return ($this->stripeId);
	}

	/**
	 * mutator method for stripeId
	 *
	 * @param int $newStripeId
	 * @throw  InvalidArgumentException if $newStripeId is not a string
	 * @throws RangeException if $newStripeId is more than 25 char
	 **/
	public function setStripeId($newStripeId) {
		if ($newStripeId === null) {
			return;
		}
		$newStripeId = filter_var($newStripeId, FILTER_SANITIZE_STRING);
		if ($newStripeId === false) {
			throw (new InvalidArgumentException("Stripe Id is not a valid string"));
		}
		if(strlen($newStripeId) > 25) {
			throw(new RangeException("stripe Id too large"));
		}
		//store Stripe Id
		$this->stripeId = $newStripeId;
	}

	/**
	 * accessor method for orderDateTime
	 *
	 * @return dateTime time of order
	 **/
	public function getOrderDateTime() {
		return ($this->orderDateTime);
	}

	/**
	 * mutator method for orderDateTime
	 *
	 * @param string $newOrderDateTime string value of date and time of order
	 * @throw UnexpectedValueException if $newOrderDateTime is not a string
	 **/
	public function setOrderDateTime($newOrderDateTime) {
		if ($newOrderDateTime === null) {
			return;
		}
		$newOrderDateTime = filter_var($newOrderDateTime, FILTER_SANITIZE_STRING);
		if ($newOrderDateTime === false) {
			throw (new UnexpectedValueException ("order date/time is not valid"));
		}
		if(strlen($newOrderDateTime) > 25) {
			throw(new RangeException("date/time too large"));
		}
		//store Order Date/Time
		$this->orderDateTime = $newOrderDateTime;
	}
	//////////// PDO FUNCTIONS //////////////////
	/**
	 * inserts this order into mySQL
	 *
	 * @param PDO $pdo references the PDO connection
	 * @throw PDOException when anything goes wrong in the PDO connection
	 **/
	public function insert(PDO &$pdo) {
		if($this->orderId !== null) {
			throw (new PDOException("unable to insert order; order already exists"));
		}
		$query = "INSERT INTO cheqoutOrder(emailId, shippingAddressId, billingAddressId, stripeId, orderDateTime)
						VALUES (:emailId, :shippingAddressId, :billingAddressId, :stripeId, :orderDateTime)";
		$statement = $pdo->prepare($query);

		$parameters = array("emailId" => $this->emailId, "shippingAddressId" => $this->shippingAddressId,
			"billingAddressId" => $this->billingAddressId, "stripeId" => $this->stripeId,
			"orderDateTime" => $this->orderDateTime);
		$statement->execute($parameters);

		$this->orderId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this order from mySQL
	 *
	 * @param PDO $pdo references the pdo connection
	 * @throws PDOException when anything goes wrong with the PDO connection
	 **/
	public function delete(PDO &$pdo) {
		if($this->orderId === null) {
			throw (new PDOException("cannot delete order that does not exist"));
		}
		$query = "DELETE FROM cheqoutOrder WHERE orderId = :orderId";
		$statement = $pdo->prepare($query);

		$parameters = array("orderId" =>$this->orderId);
		$statement->execute($parameters);
	}

	/**
	 * updates this order in mySQL
	 *
	 * @param PDO $pdo references the pdo connection
	 * @throws PDOException when anything goes wrong with the PDO connection
	 **/
	public function update(PDO &$pdo) {
		if($this->orderId === null) {
			throw (new PDOException("cannot update order that does not exist"));
		}
		$query = "UPDATE cheqoutOrder SET emailId = :emailId, shippingAddressId = :shippingAddressId,
					billingAddressId = :billingAddressId, stripeId = :stripeId, orderDateTime = :orderDateTime
					WHERE orderId = :orderId";
		$statement = $pdo->prepare($query);

		$parameters = array("orderId" => $this->orderId, "emailId" => $this->emailId, "shippingAddressId" => $this->shippingAddressId,
							"billingAddressId" => $this->billingAddressId, "stripeId" => $this->stripeId,
							"orderDateTime" => $this->orderDateTime);
		$statement->execute($parameters);
	}
//////////////GET functions/////////////////
	/**
	 * get all orders
	 *
	 * @param PDO $pdo references the pdo connection
	 * @return mixed SplFixedArray of orders or null if none
	 * @throws PDOException when anything goes wrong in mySQL
	 **/
	public static function getAllOrders(PDO &$pdo) {
		// create query template
		$query = "SELECT orderId, emailId, shippingAddressId, billingAddressId, stripeId, orderDateTime FROM cheqoutOrder";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of orders
		$orders = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$order = new cheqoutOrder($row["orderId"], $row["emailId"], $row["shippingAddressId"],
					$row ["billingAddressId"], $row["stripeId"], $row["orderDateTime"]);
				$orders[$orders->key()] = $order;
				$orders->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}

		// count the results in the array and return:
		// 1) null if 0 results
		// 2) the entire array if >= 1 result
		$numberOfOrders = count($orders);
		if($numberOfOrders === 0) {
			return (null);
		} else {
			return ($orders);
		}
	}

	/**
	 * get order by order id
	 *
	 * @param PDO $pdo references the pdo connection
	 * @param int $orderId to search for
	 * @return mixed Order if found or null if none
	 */
	public static function getOrderByOrderId(PDO &$pdo, $orderId) {
		//validate integer before searching
		$orderId = filter_var($orderId, FILTER_VALIDATE_INT);
		if(empty($orderId) === true) {
			throw(new PDOException("order does not exist"));
		}
		//create the query
		$query = "SELECT orderId, emailId, billingAddressId, shippingAddressId, stripeId, orderDateTime
							FROM cheqoutOrder WHERE orderId = :orderId";
		$statement = $pdo->prepare($query);

		$parameters = array("orderId" => $orderId);
		$statement->execute($parameters);

		try {
			$order = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if ($row !== false) {
				$order = new cheqoutOrder($row["orderId"], $row["emailId"], $row["billingAddressId"],
					$row["shippingAddressId"], $row["stripeId"], $row["orderDateTime"]);
			}
		} catch(Exception $exception) {
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return ($order);
		}

	/**
	 * get all orders associated with a single email
	 *
	 * @param PDO $pdo references pdo connection
	 * @param int $emailId email id to search for
	 * @return mixed SplFixedArray of orders associated with the email id
	 */
	public static function getOrderByEmailId(PDO &$pdo, $emailId) {
		//validate integer before searching
		$emailId = filter_var($emailId, FILTER_VALIDATE_INT);
		if(empty($emailId) === true) {
			throw(new PDOException("email has no orders associated"));
		}
		//create the query
		$query = "SELECT orderId, emailId, billingAddressId, shippingAddressId, stripeId, orderDateTime
						FROM cheqoutOrder WHERE emailId = :emailId";
		$statement = $pdo->prepare($query);

		$parameters = array("emailId" => $emailId);
		$statement->execute($parameters);

		try {
			$order = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if ($row !== false) {
				$order = new cheqoutOrder($row["orderId"], $row["emailId"], $row["billingAddressId"],
					$row["shippingAddressId"], $row["stripeId"], $row["orderDateTime"]);
			}
		} catch(Exception $exception) {
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return ($order);
	}
}