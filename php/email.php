<?php
/**
 * Email class for Cheqout
 *
 * @author Kyla Carroll <kylacarroll43@gmail.com>
 **/

class Email {
	//Primary Key for the email
	private $emailId;
	//unique email address
	private $emailAddress;
	//stripe ID if they've made a purchase
	private $stripeId;

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
	 **/
	public function setEmailAddress($newEmailAddress) {
		$newEmailAddress = filter_var($newEmailAddress, FILTER_SANITIZE_EMAIL);
		if($newEmailAddress === false) {
			throw(new UnexpectedValueException("email is not valid"));
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
	 */
	public function setStripeId($newStripeId) {
		$newStripeId = filter_var($newStripeId, FILTER_SANITIZE_STRING);
		if($newStripeId === false) {
			throw(new UnexpectedValueException("account creation date invalid"));
		}
		//assign and store account date
		$this->stripeId = $newStripeId;
	}

	/**
	 * constructor magic method for the email
	 *
	 * @param int $newEmailId new value for email Id
	 * @param string $newEmailAddress new value for email address
	 * @param string $newStripeId new value for stripe ID
	 * @throws UnexpectedValueException if any of the parameters are not valid
	 **/
	public function __construct($newEmailId, $newEmailAddress, $newStripeId) {
		try {
			$this->setEmailId($newEmailId);
			$this->setEmailAddress($newEmailAddress);
			$this->setstripeId($newStripeId);
		} catch(UnexpectedValueException $exception) {
			//rethrow to caller
			throw(new UnexpectedValueException("unable to create email", 0, $exception));
		}
	}

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
			throw(new PDOException("account does not exist"));
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
			throw(new PDOException("unable to update account that does not exist"));
		}
		//query template
		$query = "UPDATE email SET emailAddress = :emailAddress, stripeId = :stripeId WHERE emailId = :emailId";
		$statement = $pdo->prepare($query);

		//match the variables to the placeholders in query
		$parameters = array("emailAddress" => $this->emailAddress, "stripeId" => $this->stripeId, "emailId" => $this->emailId);
		$statement->execute($parameters);
	}
}