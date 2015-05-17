<?php
/**
 * Account class for Cheqout
 *
 * The account class contains both the password (hashed) and
 * the salt used to further protect the hashed password.
 * References emailId for the email used for signup.
 * Also present is the activation code used to activate the email
 * attached to the account, if any.
 * Creates the datetime of the account creation
 *
 * @author Kyla Carroll <kylacarroll43@gmail.com
 **/

class Account {
	//Primary Key for the account
	protected $accountId;
	//hashed password
	protected $accountPassword;
	//salt for password
	protected $accountPasswordSalt;
	//unique activation string
	protected $activation;
	//account creation date
	protected $accountCreateDateTime;
	//unique emailId attached to the account
	protected $emailId;

	/**
	 * constructor magic method for the account
	 *
	 * @param int $newAccountId new value for account id
	 * @param string $newAccountPassword new value for password
	 * @param string $newAccountPasswordSalt new value for account pw salt
	 * @param string $newAccountCreateDateTime new value for account create date
	 * @param string $newActivation new value for activation key
	 * @param int $newEmailId new value for emailId
	 * @throws UnexpectedValueException if any of the parameters are not valid
	 **/
	public function __construct($newAccountId, $newAccountPassword, $newAccountPasswordSalt, $newActivation, $newAccountCreateDateTime, $newEmailId) {
		try {
			$this->setAccountId($newAccountId);
			$this->setAccountPassword($newAccountPassword);
			$this->setAccountPasswordSalt($newAccountPasswordSalt);
			$this->setActivation($newActivation);
			$this->setAccountCreateDateTime($newAccountCreateDateTime);
			$this->setEmailId($newEmailId);
		} catch(UnexpectedValueException $exception) {
			//rethrow to caller
			throw(new UnexpectedValueException("unable to construct account", 0, $exception));
		}
	}


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
	 * @throws RangeException if $newAccountPassword is too long
	 **/
	public function setAccountPassword($newAccountPassword) {
		$newAccountPassword = filter_var($newAccountPassword, FILTER_SANITIZE_STRING);
		if($newAccountPassword === false) {
			throw(new UnexpectedValueException("password is not valid"));
		}
		if(strlen($newAccountPassword) > 128) {
			throw(new RangeException("hashed password too long"));
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
	 * @throws RangeException if $newAccountPasswordSalt is too long
	 **/
	public function setAccountPasswordSalt($newAccountPasswordSalt) {
		$newAccountPasswordSalt = filter_var($newAccountPasswordSalt, FILTER_SANITIZE_STRING);
		if($newAccountPasswordSalt === false) {
			throw(new UnexpectedValueException("salt invalid"));
		}
		if(strlen($newAccountPasswordSalt) > 64) {
			throw(new RangeException("pw salt too long"));
		}
		//assign and store Account name
		$this->accountPasswordSalt = $newAccountPasswordSalt;
	}

	/**
	 * accessor method for account activation code
	 *
	 * @return string value of account activation code
	 */
	public function getActivation() {
		return ($this->activation);
	}

	/** mutator method for account activation
	 *
	 * @param string $newActivation new value of account activation code
	 * @throws UnexpectedValueException if $newActivation is not valid
	 * @throws RangeException if $newActivation is too long
	 **/
	public function setActivation($newActivation) {
		$newActivation = filter_var($newActivation, FILTER_SANITIZE_STRING);
		if($newActivation === false) {
			throw(new UnexpectedValueException("account activation invalid"));
		}
		if(strlen($newActivation) > 32) {
			throw(new RangeException("activation code invalid"));
		}
		//assign and store Account name
		$this->activation = $newActivation;
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
	 * @throws RangeException if $newAccountCreateDateTime is not valid
	 */
	public function setAccountCreateDateTime($newAccountCreateDateTime) {
		$newAccountCreateDateTime = filter_var($newAccountCreateDateTime, FILTER_SANITIZE_STRING);
		if($newAccountCreateDateTime === false) {
			throw(new UnexpectedValueException("account creation date invalid"));
		}
		if(strlen($newAccountCreateDateTime) > 25) {
			throw(new RangeException("create date invalid"));
		}
		//assign and store account date
		$this->accountCreateDateTime = $newAccountCreateDateTime;
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
		$query = "INSERT INTO account(accountPassword, accountPasswordSalt, activation, accountCreateDateTime, emailId) VALUES(:accountPassword, :accountPasswordSalt, :activation, :accountCreateDateTime, :emailId)";
		$statement = $pdo->prepare($query);

		//match the variables input with the query
		$parameters = array("accountPassword" => $this->accountPassword, "accountPasswordSalt" => $this->accountPasswordSalt, "activation" => $this->activation, "accountCreateDateTime" => $this->accountCreateDateTime, "emailId" => $this->emailId);
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
		$query = "UPDATE account SET accountPassword = :accountPassword, accountPasswordSalt = :accountPasswordSalt, activation = :activation, accountCreateDateTime = :accountCreateDateTime, emailId = :emailId WHERE accountId = :accountId";
		$statement = $pdo->prepare($query);

		//match the variables to the placeholders in query
		$parameters = array("emailId" => $this->emailId, "accountPassword" => $this->accountPassword, "accountPasswordSalt" => $this->accountPasswordSalt, "accountCreateDateTime" => $this->accountCreateDateTime, "activation" => $this->activation, "accountId" => $this->accountId);
		$statement->execute($parameters);
	}
	/**
	 * gets all accounts
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @return mixed SplFixedArray of accounts found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getAllAccounts(PDO &$pdo) {
		// create query template
		$query = "SELECT accountId, accountPassword, accountPasswordSalt, activation, accountCreateDateTime, emailId FROM account";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of accounts
		$accounts = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$account = new account($row["accountId"], $row["accountPassword"], $row["accountPasswordSalt"], $row["activation"], $row["accountCreateDateTime"], $row["emailId"]);
				$accounts[$accounts->key()] = $account;
				$accounts->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}

		// count the results in the array and return:
		// 1) null if 0 results
		// 2) the entire array if >= 1 result
		$numberOfAccounts = count($accounts);
		if($numberOfAccounts === 0) {
			return (null);
		} else {
			return ($accounts);
		}
	}
	/**
	 * get account by account id
	 *
	 * @param PDO $pdo references the pdo connection
	 * @param int $accountId to search for
	 * @return mixed Account if found or null if none
	 */
	public static function getAccountByAccountId(PDO &$pdo, $accountId) {
		//validate integer before searching
		$accountId = filter_var($accountId, FILTER_VALIDATE_INT);
		if(empty($accountId) === true) {
			throw(new PDOException("account does not exist"));
		}
		//create the query
		$query = "SELECT accountId, accountPassword, accountPasswordSalt, activation, accountCreateDateTime, emailId
							FROM account WHERE accountId = :accountId";
		$statement = $pdo->prepare($query);

		$parameters = array("accountId" => $accountId);
		$statement->execute($parameters);

		try {
			$account = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if ($row !== false) {
				$account = new account($row["accountId"], $row["accountPassword"], $row["accountPasswordSalt"],
					$row["activation"], $row["accountCreateDateTime"], $row["emailId"]);
			}
		} catch(Exception $exception) {
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return ($account);
	}
	/**
	 * get account by email id
	 *
	 * @param PDO $pdo references pdo connection
	 * @param int $emailId email id to search for
	 * @return mixed Account or null if not found
	 */
	public static function getAccountByEmailId(PDO &$pdo, $emailId) {
		//validate integer before searching
		$emailId = filter_var($emailId, FILTER_VALIDATE_INT);
		if(empty($emailId) === true) {
			throw(new PDOException("account does not exist"));
		}
		//create the query
		$query = "SELECT accountId, accountPassword, accountPasswordSalt, activation, accountCreateDateTime, emailId
						FROM account WHERE emailId = :emailId";
		$statement = $pdo->prepare($query);

		$parameters = array("emailId" => $emailId);
		$statement->execute($parameters);

		try {
			$account = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if ($row !== false) {
				$account = new account($row["accountId"], $row["accountPassword"], $row["accountPasswordSalt"],
					$row["activation"], $row["accountCreateDateTime"], $row["emailId"]);
			}
		} catch(Exception $exception) {
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return ($account);
	}
}