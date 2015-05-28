<?php
/**
 * Email class for Cheqout
 *
 * This is the email class for Cheqout; the email Id is an auto-incrementing assigned integer,
 * the email address it is assigned to must be unique, and if the email has purchased anything,
 * there will be a stripe Id assigned.
 *
 * @author Kyla Carroll <kylacarroll43@gmail.com>
 **/

class Email {
	/**
	 * The email id is the primary key, an auto-incremented unsigned int
	 **/
	protected $emailId;
	/**
	 * The email address is a unique string no greater than 128 characters
	 **/
	protected $emailAddress;
	/**
	 * The stripe Id will only be present if the email has made a purchase, the stripe API will provide
	 **/
	protected $stripeId;

	/**
	 * constructor magic method for the email
	 *
	 * @param int $newEmailId new value for email Id
	 * @param string $newEmailAddress new value for email address
	 * @param string $newStripeId new value for stripe ID
	 * @throws InvalidArgumentException if any of the parameters are not valid
	 * @throws RangeException if any of the data is out of bounds
	 **/
	public function __construct($newEmailId, $newEmailAddress, $newStripeId) {
		try {
			$this->setEmailId($newEmailId);
			$this->setEmailAddress($newEmailAddress);
			$this->setstripeId($newStripeId);
		} catch(InvalidArgumentException $exception) {

			throw(new InvalidArgumentException("unable to create email", 0, $exception));
		} catch(RangeException $range) {

			throw(new RangeException($range->getMessage(), 0, $range));
		}
	}

	/**
	 * accessor method for email id
	 *
	 * @return int value of email id
	 */

	public function getEmailId() {
		return ($this->emailId);
	}

	/**
	 * mutator method for email id
	 *
	 * @param int $newEmailId new value of emailId
	 * @throws UnexpectedValueException if $newEmailId is not an integer
	 **/

	public function setEmailId($newEmailId) {
		if($newEmailId === null) {
			return;
		}
		$newEmailId = filter_var($newEmailId, FILTER_VALIDATE_INT);
		if($newEmailId === false) {
			throw(new UnexpectedValueException("emailId is an invalid integer"));
		}
		//assign and store the filtered emailId
		$this->emailId = intval($newEmailId);
	}

	/**
	 * accessor method for email address
	 *
	 * @return string value of email address
	 **/
	public function getEmailAddress() {
		return ($this->emailAddress);
	}

	/**
	 * mutator method for email address
	 *
	 * @param string $newEmailAddress new value of email address
	 * @throws UnexpectedValueException if $newEmailAddress is not a valid email
	 * @throws RangeException if email address is too long
	 **/
	public function setEmailAddress($newEmailAddress) {
		$newEmailAddress = filter_var($newEmailAddress, FILTER_SANITIZE_EMAIL);
		if($newEmailAddress === false) {
			throw(new UnexpectedValueException("email is not valid"));
		}
		if(strlen($newEmailAddress) > 128) {
			throw(new RangeException("email address too long"));
		}
		//assign and store the email address
		$this->emailAddress = $newEmailAddress;
	}

	/**
	 * stripeId accessor method
	 *
	 * @return string of stripeId
	 */
	public function getStripeId() {
		return ($this->stripeId);
	}

	/**
	 * mutator method for stripe Id
	 *
	 * @param string $newStripeId new value of stripe Id
	 * @throws UnexpectedValueException if $newStripeId is not valid
	 * @throws RangeException if stripe id is too long
	 */
	public function setStripeId($newStripeId) {
		$newStripeId = filter_var($newStripeId, FILTER_SANITIZE_STRING);
		if($newStripeId === false) {
			throw(new UnexpectedValueException("account creation date invalid"));
		}
		if(strlen($newStripeId) > 25) {
			throw(new RangeException("stripeID too long"));
		}
		//assign and store account date
		$this->stripeId = $newStripeId;
	}
/////////////////PDO FUNCTIONS////////////////////////////
	/**
	 * inserts this email into mySQL
	 *
	 * @param PDO $pdo referencing the pdo connection
	 * @throws PDOException when any error occurs in mySQL
	 **/
	public function insert(PDO &$pdo) {
		//don't allow insertion if account already exists
		if($this->emailId !== null) {
			throw(new PDOException("email already exists"));
		}

		//create the pdo query template
		$query = "INSERT INTO email(emailId, emailAddress, stripeId) VALUES(:emailId, :emailAddress, :stripeId)";
		$statement = $pdo->prepare($query);

		//match the variables input with the query
		$parameters = array("emailId" => $this->emailId, "emailAddress" => $this->emailAddress, "stripeId" => $this->stripeId);
		$statement->execute($parameters);

		//updates the null emailId with the value of the variable
		$this->emailId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes the email from mySQL
	 *
	 * @param PDO $pdo referencing the pdo connection
	 * @throws PDOException when any error occurs in mySQL
	 */
	public function delete(PDO &$pdo) {
		//don't allow deletion if account doesn't exist
		if($this->emailId === null) {
			throw(new PDOException("email does not exist"));
		}

		//create the pdo query template
		$query = "DELETE FROM email WHERE emailId = :emailId";
		$statement = $pdo->prepare($query);

		//match the variables input with the query
		$parameters = array("emailId" => $this->emailId);
		$statement->execute($parameters);
	}

	/**
	 * updates this email in mySQL
	 *
	 * @param PDO $pdo referencing the pdo connection
	 * @throws PDOException when any error occurs in mySQL
	 */
	public function update(PDO &$pdo) {
		//make sure account exists
		if($this->emailId === null) {
			throw(new PDOException("unable to update email that does not exist"));
		}
		//query template
		$query = "UPDATE email SET emailAddress = :emailAddress, stripeId = :stripeId WHERE emailId = :emailId";
		$statement = $pdo->prepare($query);

		//match the variables to the placeholders in query
		$parameters = array("emailId" => $this->emailId, "emailAddress" => $this->emailAddress, "stripeId" => $this->stripeId);
		$statement->execute($parameters);
	}
/////////////Get email functions///////////////////
	/**
	 * get all emails
	 *
	 * @param PDO $pdo references the pdo connection
	 * @return mixed SplFixedArray of emails found/null if not found
	 * @throws PDOException when mySQL related error occurs
	 **/
	public static function getAllEmails(PDO &$pdo) {
		// create query template
		$query = "SELECT emailId, emailAddress, stripeId FROM email";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of emails
		$emails = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$email = new email($row["emailId"], $row["emailAddress"], $row["stripeId"]);
				$emails[$emails->key()] = $email;
				$emails->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}

		// count the results in the array and return:
		// 1) null if 0 results
		// 2) the entire array if >= 1 result
		$numberOfEmails = count($emails);
		if($numberOfEmails === 0) {
			return (null);
		} else {
			return ($emails);
		}
	}

	/**
	 * get email by stripe Id
	 *
	 * @param PDO $pdo references the pdo connection
	 * @param string $stripeId stripeId to search for
	 * @return mixed Email or null if none
	 * @throws PDOException when anything goes wrong in mySQL
	 */
	public static function getEmailByStripeId(PDO &$pdo, $stripeId) {
		// sanitize the description before searching
		$stripeId = trim($stripeId);
		$stripeId = filter_var($stripeId, FILTER_SANITIZE_STRING);
		if(empty($stripeId) === true) {
			throw(new PDOException("email has not been assigned a stripe Id"));
		}

		// create query template
		$query = "SELECT emailId, emailAddress, stripeId FROM email WHERE stripeId = :stripeId";
		$statement = $pdo->prepare($query);


		$parameters = array("stripeId" => $stripeId);
		$statement->execute($parameters);

			try {
				$email = null;
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$row = $statement->fetch();
				if ($row !== false) {
					$email = new Email ($row["emailId"], $row["emailAddress"], $row["stripeId"]);
				}
			} catch(Exception $exception) {
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
			return ($email);
		}

	/**
	 * get email by emailId
	 *
	 * @param PDO $pdo references the pdo connection
	 * @param int $emailId emailId to search for
	 * @return mixed Email if found, or null if none found
	 * @throws PDOException when anything goes wrong in mySQL
	 */
	public static function getEmailByEmailId(PDO &$pdo, $emailId) {
		//validate integer before searching
		$emailId = filter_var($emailId, FILTER_VALIDATE_INT);
		if(empty($emailId) === true) {
			throw(new PDOException("email does not exist"));
		}
		//create the query
		$query = "SELECT emailId, emailAddress, stripeId FROM email WHERE emailId = :emailId";
		$statement = $pdo->prepare($query);

		$parameters = array("emailId" => $emailId);
		$statement->execute($parameters);

		try {
			$email = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if ($row !== false) {
				$email = new Email ($row["emailId"], $row["emailAddress"], $row["stripeId"]);
			}
			} catch(Exception $exception) {
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		return ($email);
		}
	/**
	 * get emailId by email address
	 *
	 * @param PDO $pdo references the pdo connection
	 * @param string $emailAddress email address to search for
	 * @return mixed emailId if found, or null if none found
	 * @throws PDOException when anything goes wrong in mySQL
	 */
	public static function getEmailIdByEmailAddress(PDO &$pdo, $emailAddress) {
		//validate integer before searching
		$emailAddress = filter_var($emailAddress, FILTER_SANITIZE_EMAIL);
		if(empty($emailAddress) === true) {
			throw(new PDOException("this email does not exist"));
		}
		//create the query
		$query = "SELECT emailId, emailAddress, stripeId FROM email WHERE emailAddress = :emailAddress";
		$statement = $pdo->prepare($query);

		$parameters = array("emailAddress" => $emailAddress);
		$statement->execute($parameters);

		try {
			$email = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if ($row !== false) {
				$email = new Email ($row["emailId"], $row["emailAddress"], $row["stripeId"]);
			}
		} catch(Exception $exception) {
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return ($email);
	}
	/**
	 * get login data by email address
	 *
	 * this includes a join with the account table to get password
	 * @param PDO $pdo references the pdo connection
	 * @param string $emailAddress the entered email address
	 * @return mixed login details (email/password) if found or null if none found
	 * @throws PDOException when anything goes wrong in mySQL
	 *
	 */
	public static function getLoginDataByEmailAddress(PDO &$pdo, $emailAddress) {
		//validate email before searching
		$emailAddress = filter_var($emailAddress, FILTER_SANITIZE_EMAIL);
		if(empty($emailAddress) === true) {
			throw(new PDOException("Email is not in our records or is invalid"));
		}
		//create the query
		$query = "SELECT emailAddress, accountPassword, accountPasswordSalt FROM email, account WHERE emailAddress = :emailAddress";
		$statement = $pdo->prepare($query);

		$parameters = array("emailAddress" => $emailAddress,);
		$statement->execute($parameters);

		try {
			$login = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$login = array($row["emailAddress"], $row["accountPassword"], $row["accountPasswordSalt"]);
			}
		} catch(Exception $exception) {
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return ($login);
	}
	/**
	 * get orders by email address MADE BY TYLER WIEGAND (not james or kyla)
	 *
	 * @param PDO $pdo references the pdo connection
	 * @param string $input email address to search for
	 * @return mixed emailId if found, or null if none found
	 * @throws PDOException when anything goes wrong in mySQL
	 */
	public static function getOrdersByEmail(PDO &$pdo, $input) {
		//validate integer before searching
		$input = intval($input);
		$input = filter_var($input, FILTER_VALIDATE_INT);
		if(empty($input) === true) {
			throw(new PDOException("Input should be a valid Email ID."));
		}
		//create the query
		$query = "SELECT email.emailAddress,
                    cheqoutOrder.orderId,
                    productOrder.quantity,
                    product.productId,
                    product.productTitle,
                    product.productPrice * product.productSale * productOrder.quantity,
                    shippingCost,
                    orderPrice,
                    address.addressAttention,
                    address.addressLabel,
                    address.addressStreet1,
                    address.addressStreet2,
                    address.addressCity,
                    address.addressState,
                    address.addressZip,
                    cheqoutOrder.orderDateTime
                    FROM email
                    INNER JOIN cheqoutOrder ON email.emailId = cheqoutOrder.emailId
                    INNER JOIN productOrder ON cheqoutOrder.orderId = productOrder.orderId
                    INNER JOIN product ON product.productId = productOrder.productId
                    INNER JOIN address ON address.addressId = cheqoutOrder.shippingAddressId
                    WHERE email.emailId = :input
                    ORDER BY orderDateTime";
		$statement = $pdo->prepare($query);
		$parameters = array("input" => $input);
		$statement->execute($parameters);
		$orders = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$order = array($row["emailAddress"],
									$row["orderId"],
									$row["quantity"],
									$row["productId"],
									$row["productTitle"],
									$row["product.productPrice * product.productSale * productOrder.quantity"],
									$row["shippingCost"],
									$row["orderPrice"],
									$row["addressAttention"],
									$row["addressLabel"],
									$row["addressStreet1"],
									$row["addressStreet2"],
									$row["addressCity"],
									$row["addressState"],
									$row["addressZip"],
									$row["orderDateTime"]);
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



