<?php
/**
 * Account class for Cheqout
 *
 * @author Kyla Carroll <kylacarroll43@gmail.com
 **/


class Account {
	//Primary Key for the account
	private $accountId;
	//unique email attached to the account
	private $emailId;
	//account name specified
	private $email;
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

	public function setAccountId ($newAccountId) {
		if ($newAccountId === null) {
			return;
		}
		$newAccountId = filter_var($newAccountId, FILTER_VALIDATE_INT);
		if ($newAccountId === false) {
			throw(new UnexpectedValueException("accountId is an invalid integer"));
		}
		//assign and store the filtered accountId
		$this->accountId = intval($newAccountId);
	}

	/**
	 * accessor method for email
	 *
	 * @return string value of email
	 **/
	public function getEmail() {
		return ($this->email);
	}

	/**
	 * mutator method for email
	 *
	 * @param string $newEmail new value of email
	 * @throws UnexpectedValueException if $newEmail is not a valid email
	 **/
	public function setEmail($newEmail) {
		$newEmail = filter_var($newEmail, FILTER_SANITIZE_EMAIL);
		if($newEmail === false) {
			throw(new UnexpectedValueException("email is not valid"));
		}
		//assign and store the email
		$this->email = $newEmail;
	}
	/**
	 * accessor method for account name
	 *
	 * @return string value of account name
	 */
	public function getAccountName() {
		return ($this->accountName);
	}

	/** mutator method for account name
	 *
	 * @param string $newAccountName new value of account name
	 * @throws UnexpectedValueException if $newAccountName is not valid
	 **/
	public function setAccountName($newAccountName) {
		$newAccountName = filter_var($newAccountName, FILTER_SANITIZE_STRING);
		if ($newAccountName === false) {
			throw(new UnexpectedValueException("account name is not valid"));
		}
		//assign and store Account name
		$this->accountName = $newAccountName;
	}

	/**
	 * accountDate accessor method
	 *
	 * @return string date of account creation
	 */
	public function getAccountDate() {
		return ($this->accountDate);
	}

	/**
	 * mutator method for account creation date
	 *
	 * @param string $newAccountDate new value of account creation date
	 * @throws UnexpectedValueException if $newAccountDate is not valid
	 */
	public function setAccountDate($newAccountDate) {
		$newAccountDate = filter_var($newAccountDate, FILTER_SANITIZE_STRING);
		if ($newAccountDate === false) {
			throw(new UnexpectedValueException("account creation date invalid"));
		}
		//assign and store account date
		$this->accountDate = $newAccountDate;
	}

	/**
	 * constructor magic method for the account
	 *
	 * @param int $newAccountId new value for account id
	 * @param string $newEmail new value for email
	 * @param string $newAccountName new value for account name
	 * @throws UnexpectedValueException if any of the parameters are not valid
	 **/
	public function __construct($newAccountId, $newEmail, $newAccountName, $newAccountDate) {
		try {
			$this->setAccountId($newAccountId);
			$this->setEmail($newEmail);
			$this->setAccountName($newAccountName);
			$this->setAccountDate($newAccountDate);
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
		$query = "INSERT INTO account(email, accountName, accountDate) VALUES(:email, :accountName, :accountDate)";
		$statement = $pdo->prepare($query);

		//match the variables input with the query
		$parameters = array("email" => $this->email, "accountName" => $this->accountName, "accountDate" => $this->accountDate);
		$statement->execute($parameters);

		//updates the null accountId with the value of the variable
		$this->accountId = intval($pdo->lastInsertId());
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
		$query = "UPDATE account SET email = :email, accountName = :accountName, accountDate = :accountDate WHERE accountId = :accountId";
		$statement = $pdo->prepare($query);

		//match the variables to the placeholders in query
		$parameters = array("email" => $this->email, "accountName" => $this->accountName, "accountDate" => $this->accountDate, "accountId" => $this->accountId);
		$statement->execute($parameters);
	}