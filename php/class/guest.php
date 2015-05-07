<?php
/**
 * this is the Guest class
 *
 * the guestId class will contain
 * guestId (primary key),
 * emailId (foreign key)
 *
 * @author Tyler Wiegand <tyler dot wiegand at me dot com>
 **/

class Guest {
	/**
	 * unique ID for guest; primary key
	 */
	private $guestId;

	/**
	 * unique foreign key for email Id
	 **/
	private $emailId;

	/**
	 * constructor magic method for the guest
	 *
	 * @param int $newGuestId new value for guest Id
	 * @param int $newGuestId new value for guest address
	 * @param string $newEmailId new value for stripe ID
	 * @throws UnexpectedValueException if any of the parameters are not valid
	 **/
	public function __construct($newEmailId, $newGuestId) {
		try {
			$this->setEmailId($newEmailId);
			$this->setGuestId($newGuestId);
		} catch(UnexpectedValueException $exception) {
			//rethrow to caller
			throw(new UnexpectedValueException('Unable to create Guest Account', 0, $exception));
		}
	}

	/**
	 * toString() magic method
	 *
	 * @return string formatted in HTML for Address class constructor
	 */

	// this allows the class to be Echo'd as a string in HTML format
	public function __toString() {
		//create an HTML formatted Profile
		$html = 		"<p>Guest ID: " . $this->guestId . "<br />"
			. "Email ID: ".	$this->emailId . "<br />"
			. "</p>";
		return($html);
	}
	/**
	 * accessor method for guest id
	 *
	 * @return int value of guest id
	 */

	public function getGuestId() {
		return ($this->guestId);
	}

	/**
	 * mutator method for guest id
	 *
	 * @param int $newGuestId new value of guestId
	 * @throws UnexpectedValueException if $newGuestId is not an integer
	 **/

	public function setGuestId($newGuestId) {
		if($newGuestId === null) {
			return;
		}
		$newGuestId = filter_var($newGuestId, FILTER_VALIDATE_INT);
		if($newGuestId === false) {
			throw(new UnexpectedValueException("Guest Id is an invalid integer"));
		}
		//assign and store the filtered guestId
		$this->guestId = intval($newGuestId);
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
	 * @param int $newEmailId new value of guestId
	 * @throws UnexpectedValueException if $newGuestId is not an integer
	 **/

	public function setEmailId($newEmailId) {
		$newEmailId = filter_var($newEmailId, FILTER_VALIDATE_INT);
		if($newEmailId === false) {
			throw(new UnexpectedValueException("Email Id is an invalid integer"));
		}
		//assign and store the filtered guestId
		$this->emailId = intval($newEmailId);
	}

	/**
	 * inserts this guest into mySQL
	 *
	 * @param PDO $pdo referencing the pdo connection
	 * @throws PDOException when any error occurs in mySQL
	 **/
	public function insert(PDO &$pdo) {
		//don't allow insertion if account already exists
		if($this->guestId !== null) {
			throw(new PDOException("Guest ID already exists."));
		}

		//create the pdo query template
		$query = "INSERT INTO guest(guestId, emailId) VALUES(:guestId, :emailId)";
		$statement = $pdo->prepare($query);

		//match the variables input with the query
		$parameters = array("guestId" => $this->guestId, "emailId" => $this->emailId);
		$statement->execute($parameters);

		//updates the null guestId with the value of the variable
		$this->guestId = intval($pdo->lastInsertId());
	}

	/**
	 * get the guest ID by email ID
	 *
	 * @param PDO $guestPdo references the pdo connection
	 * @param string $emailId account name to search for
	 * @return mixed SplFixedArray of guests found/null if not found
	 * @throws PDOException when mySQL related error occurs
	 **/
	public static function getGuestIdByEmailId(PDO &$guestPdo, $emailId) {
		// sanitize the description before searching
		$emailId = intval($emailId);
		if(empty($emailAddress) === true) {
			throw(new PDOException("Email does not exist"));
		}

		// create query template
		$query = "SELECT guestId, emailId FROM guest WHERE emailId IS :emailId";
		$preparedStatement = $guestPdo->prepare($query);
		$parameters = array("emailId" => $emailId);
		$preparedStatement->execute($parameters);
		try {

			// declare returnAddress so we can return it after we find what we're looking for (IF we do!)
			// but we cant return NOTHING...well, we CAN return NULL but not nothing...ironic...
			$returnGuestId = null;
			// within our preparedStatement variable, change the fetch mode in PDO so it gets it as an
			// associative array (you have to)
			$preparedStatement->setFetchMode(PDO::FETCH_ASSOC);
			// now our preparedStatement isn't what we care about. we want our results (as an array)
			$results   = $preparedStatement->fetch();
			// now if we actually got something, we want to be able to assign it to returnAddress. Remember
			// results are from the PDO statement, returnAddress is what we want the METHOD to output.
			if($results !== false) {
				$returnGuestId = new Guest($results["guestId"], $results["emailId"]);
			}
		} catch(Exception $exception) {
			// exception? NO PROBLEM! Throw it ...away...to someone else.
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		// alright if everything went well we have our address results returned to us. Nice!
		return($returnGuestId);
	}
}