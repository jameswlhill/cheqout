<?php
/**
 * Account class for Cheqout
 *
 * The account class contains both the password (hashed) and
 * the salt used to further protect the hashed password.
 * Also present is the activation code used to activate the email
 * attached to the account, if any.
 *
 * @author Kyla Carroll <kylacarroll43@gmail.com
 **/


class Account {
	//Primary Key for the account
	private $accountId;
	//unique emailId attached to the account
	private $emailId;
	//hashed password
	private $accountPassword;
	//salt for password
	private $accountPasswordSalt;
	//unique activation string
	private $accountActivation;
	//account creation date
	private $accountCreateDateTime;

	/**
	 * accessor method for account id
	 *
	 * @return int value of account id
	 */

	public function getAccountId() {
		return ($this->accountId);
	}

	/**
	 * mutator method for account id
	 *
	 * @param int $newAccountId new value of accountId
	 * @throws UnexpectedValueException if $newProfileId is not an integer
	 **/

	public function setAccountId($newAccountId) {
		if($newAccountId === null) {
			return;
		}
		$newAccountId = filter_var($newAccountId, FILTER_VALIDATE_INT);
		if($newAccountId === false) {
			throw(new UnexpectedValueException("accountId is an invalid integer"));
		}
		//assign and store the filtered accountId
		$this->accountId = intval($newAccountId);
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
	 * mutator method for emailId
	 *
	 * @param string $newEmailId new value of emailId
	 * @throws UnexpectedValueException if $newEmailId is not a valid integer
	 **/
	public function setEmailId($newEmailId) {
		$newEmailId = filter_var($newEmailId, FILTER_VALIDATE_INT);
		if($newEmailId === false) {
			throw(new UnexpectedValueException("emailId is not valid integer"));
		}
		//assign and store the email
		$this->emailId = $newEmailId;
	}

	/**
	 * accessor method for account Password
	 *
	 * @return string value of account password
	 */
	public function getAccountPassword() {
		return ($this->accountPassword);
	}

	/** mutator method for account password
	 *
	 * @param string $newAccountPassword new value of account password
	 * @throws UnexpectedValueException if $newAccountPassword is not valid
	 **/
	public function setAccountPassword($newAccountPassword) {
		$newAccountPassword = filter_var($newAccountPassword, FILTER_SANITIZE_STRING);
		if($newAccountPassword === false) {
			throw(new UnexpectedValueException("password is not valid"));
		}
		//assign and store Account name
		$this->accountPassword = $newAccountPassword;
	}

	/**
	 * accessor method for account Password salt
	 *
	 * @return string value of account pw salt
	 */
	public function getAccountPasswordSalt() {
		return ($this->accountPasswordSalt);
	}

	/** mutator method for account password salt
	 *
	 * @param string $newAccountPasswordSalt new value of account password salt
	 * @throws UnexpectedValueException if $newAccountPasswordSalt is not valid
	 **/
	public function setAccountPasswordSalt($newAccountPasswordSalt) {
		$newAccountPasswordSalt = filter_var($newAccountPasswordSalt, FILTER_SANITIZE_STRING);
		if($newAccountPasswordSalt === false) {
			throw(new UnexpectedValueException("salt invalid"));
		}
		//assign and store Account name
		$this->accountPasswordSalt = $newAccountPasswordSalt;
	}

	/**
	 * accountCreateDateTime accessor method
	 *
	 * @return string date of account creation
	 */
	public function getAccountCreateDateTime() {
		return ($this->accountCreateDateTime);
	}

	/**
	 * mutator method for account creation date
	 *
	 * @param string $newAccountCreateDateTime new value of account creation date
	 * @throws UnexpectedValueException if $newAccountCreateDateTime is not valid
	 */
	public function setAccountCreateDateTime($newAccountCreateDateTime) {
		$newAccountCreateDateTime = filter_var($newAccountCreateDateTime, FILTER_SANITIZE_STRING);
		if($newAccountCreateDateTime === false) {
			throw(new UnexpectedValueException("account creation date invalid"));
		}
		//assign and store account date
		$this->accountCreateDateTime = $newAccountCreateDateTime;
	}

	/**
	 * accessor method for account activation code
	 *
	 * @return string value of account activation code
	 */
	public function getAccountActivation() {
		return ($this->accountActivation);
	}

	/** mutator method for account activation
	 *
	 * @param string $newAccountActivation new value of account activation code
	 * @throws UnexpectedValueException if $newAccountActivation is not valid
	 **/
	public function setAccountActivation($newAccountActivation) {
		$newAccountActivation = filter_var($newAccountActivation, FILTER_SANITIZE_STRING);
		if($newAccountActivation === false) {
			throw(new UnexpectedValueException("account activation invalid"));
		}
		//assign and store Account name
		$this->accountActivation = $newAccountActivation;
	}

	/**
	 * constructor magic method for the account
	 *
	 * @param int $newAccountId new value for account id
	 * @param int $newEmailId new value for emailId
	 * @param string $newAccountPassword new value for password
	 * @param string $newAccountPasswordSalt new value for account pw salt
	 * @param string $newAccountCreateDateTime new value for account create date
	 * @param string $newAccountActivation new value for activation key
	 *
	 * @throws UnexpectedValueException if any of the parameters are not valid
	 **/
	public function __construct($newAccountId, $newEmailId, $newAccountPassword, $newAccountPasswordSalt, $newAccountCreateDateTime, $newAccountActivation) {
		try {
			$this->setAccountId($newAccountId);
			$this->setEmailId($newEmailId);
			$this->setAccountPassword($newAccountPassword);
			$this->setAccountPasswordSalt($newAccountPasswordSalt);
			$this->setAccountCreateDateTime($newAccountCreateDateTime);
			$this->setAccountActivation($newAccountActivation);
		} catch(UnexpectedValueException $exception) {
			//rethrow to caller
			throw(new UnexpectedValueException("unable to construct account", 0, $exception));
		}
	}

	/**
	 * inserts this account into mySQL
	 *
	 * @param PDO $pdo referencing the pdo connection
	 * @throws PDOException when any error occurs in mySQL
	 **/
	public function insert(PDO &$pdo) {
		//don't allow insertion if account already exists
		if($this->accountId !== null) {
			throw(new PDOException("account already exists"));
		}

		//create the pdo query template
		$query = "INSERT INTO account(emailId, accountPassword, accountPasswordSalt, accountCreateDateTime, activation) VALUES(:emailId, :accountPassword, :accountPasswordSalt, :accountCreateDateTime, :activation)";
		$statement = $pdo->prepare($query);

		//match the variables input with the query
		$parameters = array("emailId" => $this->emailId, "accountPassword" => $this->accountPassword, "accountCreateDateTime" => $this->accountCreateDateTime, "accountActivation" => $this->accountActivation);
		$statement->execute($parameters);

		//updates the null accountId with the value of the variable
		$this->accountId = intval($pdo->lastInsertId());
		$this->emailId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes the account from mySQL
	 *
	 * @param PDO $pdo referencing the pdo connection
	 * @throws PDOException when any error occurs in mySQL
	 */
	public function delete(PDO &$pdo) {
		//don't allow deletion if account doesn't exist
		if($this->accountId === null) {
			throw(new PDOException("account does not exist"));
		}

		//create the pdo query template
		$query = "DELETE FROM account WHERE accountId = :accountId";
		$statement = $pdo->prepare($query);

		//match the variables input with the query
		$parameters = array("accountId" => $this->accountId);
		$statement->execute($parameters);
	}

	/**
	 * updates this account in mySQL
	 *
	 * @param PDO $pdo referencing the pdo connection
	 * @throws PDOException when any error occurs in mySQL
	 */
	public function update(PDO &$pdo) {
		//make sure account exists
		if($this->accountId === null) {
			throw(new PDOException("unable to update account that does not exist"));
		}
		//query template
		$query = "UPDATE account SET emailId = :emailId, accountPassword = :accountPassword, accountPasswordSalt = :accountPasswordSalt, accountCreateDateTime = :accountCreateDateTime, activation = :accountActivation WHERE accountId = :accountId";
		$statement = $pdo->prepare($query);

		//match the variables to the placeholders in query
		$parameters = array("emailId" => $this->emailId, "accountPassword" => $this->accountPassword, "accountPasswordSalt" => $this->accountPasswordSalt, "accountCreateDateTime" => $this->accountCreateDateTime, "activation" => $this->accountActivation, "accountId" => $this->accountId);
		$statement->execute($parameters);
	}
}