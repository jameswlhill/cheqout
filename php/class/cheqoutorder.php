<?php
/**
 * CheqoutOrder class
 *
 * this is the order class, with the primary key of orderId,
 * references the emailId and stripeId of the user who placed the order,
 * the addressId of whatever address was stored to be used for shipping.
 * creates the datetime of the order placement.
 *
 * @author Kyla Carroll <kylacarroll43@gmail.com>
 */

class cheqoutOrder {
	//the auto-incrementing id associated with each order. this is the primary key
	private $orderId;
	//referenced foreign key for email
	private $emailId;
	//referenced foreign key for address
	private $addressId;
	//referenced stripeId for payment
	private $stripeId;
	//generated date time of order
	private $orderDateTime;

	/**
	 * accessor method for orderId
	 *
	 * @return int value of orderId
	 */
	public function getOrderId() {
		return ($this->orderId);
	}

	/**
	 * mutator method for order Id
	 *
	 * @param int $newOrderId new value of orderId
	 * @throws InvalidArgumentException if $newOrderId is not an integer
	 * @throws RangeException if $newOrderId is not a positive int
	 */
	public function setOrderId($newOrderId) {
		if ($newOrderId === null) {
			return;
		}
		$newOrderId = filter_var($newOrderId, FILTER_VALIDATE_INT);
		if ($newOrderId === false) {
			throw (new InvalidArgumentException("order ID is invalid"));
		}
		if($newOrderId <= 0) {
			throw(new RangeException("order Id is not positive"));
		}
		//store the new Order Id
		$this->orderId = intval($newOrderId);
	}

	/**
	 * accessor method for emailId
	 *
	 * @return int value of emailId
	 */
	public function getEmailId() {
		return ($this->emailId);
	}

	/**
	 * mutator method for email Id
	 *
	 * @param int $newEmailId new value of emailId
	 * @throws InvalidArgumentException if $newEmailId is not an integer
	 * @throws RangeException if $newEmailId is not a positive int
	 */
	public function setEmailId($newEmailId) {
		if ($newEmailId === null) {
			return;
		}
		$newEmailId = filter_var($newEmailId, FILTER_VALIDATE_INT);
		if ($newEmailId === false) {
			throw (new InvalidArgumentException("email ID is invalid"));
		}
		if($newEmailId <= 0) {
			throw(new RangeException("email Id is not positive"));
		}
		//store the new email Id
		$this->emailId = intval($newEmailId);
	}

	/**
	 * accessor method for addressId
	 *
	 * @return int value of addressId
	 */
	public function getAddressId() {
		return ($this->addressId);
	}
	/**
	 * mutator method for addressId
	 *
	 * @param int $newAddressId new value for addressId
	 * @throw UnexpectedValueException if $newAddressId is not a valid integer
	 */
	public function setAddressId($newAddressId) {
		if ($newAddressId === null) {
			return;
		}
		$newAddressId = filter_var($newAddressId, FILTER_VALIDATE_INT);
		if($newAddressId === false) {
			throw (new UnexpectedValueException("address ID is invalid"));
		}
		//store the new address Id
		$this->addressId = intval($newAddressId);
	}
	/**
	 * accessor method for stripeId
	 *
	 * @return string value of stripeId
	 */
	public function getStripeId() {
		return ($this->stripeId);
	}

	/**
	 * mutator method for stripeId
	 *
	 * @param int $newStripeId
	 * @throw  InvalidArgumentException if $newStripeId is not a string
	 * @throws RangeException if $newStripeId is more than 25 char
	 */
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
	 */
	public function getOrderDateTime() {
		return ($this->orderDateTime);
	}

	/**
	 * mutator method for oderDateTime
	 *
	 * @param string $newOrderDateTime string value of date and time of order
	 * @throw InvalidArgumentException if $newOrderDateTime is not a string
	 */
	public function setOrderDateTime($newOrderDateTime) {
		if ($newOrderDateTime === null) {
			return;
		}
		$newOrderDateTime = filter_var($newOrderDateTime, FILTER_SANITIZE_STRING);
		if ($newOrderDateTime === false) {
			throw (new InvalidArgumentException("order date/time is not valid"));
		}
		//store Order Date/Time
		$this->orderDateTime = $newOrderDateTime;
	}
	/**
	 * constructor magic method for Order
	 *
	 * @param int $newOrderId new value of orderId
	 * @param int $newEmailId new value of emailId
	 * @param int $newAddressId new value of addressId
	 * @param string $newStripeId new value of stripeId
	 * @param string $newOrderDateTime new value of orderDateTime
	 * @throw UnexpectedValueException if any params are not valid
	 */
	public function __construct($newOrderId, $newEmailId, $newAddressId, $newStripeId, $newOrderDateTime) {
		try {
			$this->setOrderId($newOrderId);
			$this->setEmailId($newEmailId);
			$this->setAddressId($newAddressId);
			$this->setStripeId($newStripeId);
			$this->setOrderDateTime($newOrderDateTime);
		} catch (UnexpectedValueException $exception) {
			throw (new UnexpectedValueException("unable to create order", 0, $exception));
		}
	}
	/////// PDO FUNCTIONS ////////
	/**
	 * inserts this order into mySQL
	 *
	 * @param PDO $pdo references the PDO connection
	 * @throw PDOException when anything goes wrong in the PDO connection
	 */
	public function insert(PDO &$pdo) {
		if($this->orderId !== null) {
			throw (new UnexpectedValueException("unable to insert order; order already exists"));
		}
		$query = "INSERT INTO cheqoutOrder(emailId, addressId, stripeId, orderDateTime) VALUES (:emailId, :addressId, :stripId, :orderDateTime)";
		$statement = $pdo->prepare($query);

		$parameters = array("emailId" => $this->emailId, "addressId" => $this->addressId, "stripeId" => $this->stripeId, "orderDateTime" => $this->orderDateTime);
		$statement->execute($parameters);

		$this->orderId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this order from mySQL
	 *
	 * @param PDO $pdo references the pdo connection
	 * @throws PDOException when anything goes wrong with the PDO connection
	 */
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
	 */
	public function update(PDO &$pdo) {
		if($this->orderId === null) {
			throw (new PDOException("cannot update order that does not exist"));
		}
		$query = "UPDATE cheqoutOrder SET emailId = :emailId, addressId = :addressId, stripeId = :stripeId, orderDateTime = :orderDateTime WHERE orderId = :orderId";
		$statement = $pdo->prepare($query);

		$parameters = array("emailId" => $this->emailId, "addressId" => $this->addressId, "stripeId" => $this->stripeId, "orderDateTime" => $this->orderDateTime);
		$statement->execute($parameters);
	}

	/**
	 * get all orders
	 *
	 * @param PDO $pdo references the pdo connection
	 * @return mixed SplFixedArray of orders or null if none
	 * @throws PDOException when anything goes wrong in mySQL
	 */
	public static function getAllOrders(PDO &$pdo) {
		// create query template
		$query = "SELECT orderId, emailId, addressId, stripeId, orderDateTime FROM cheqoutOrder";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of orders
		$orders = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$order = new cheqoutOrder($row["orderId"], $row["emailId"], $row["addressId"], $row["stripeId"], $row["orderDateTime"]);
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
}