<?php
/**
 * this is the Address class
 *
 * the address class will contain
 * addressId (primary key),
 * emailId (foreign key)
 * addressHidden (0 default for not hidden, 1 for hidden)
 * addressAttention REQUIRED for the Attention line in a postal address
 * 	generated from the name of customer, formatted
 * 	ATTN: firstName lastName OR ATTN: fullName
 * addressStreet1 REQUIRED field, address line 1 in postal address
 * addressStreet2 OPTIONAL field, only included if input received
 * addressCity REQUIRED field, City name in postal address
 * addressState REQUIRED field, 2 digit code selected from drop-down
 * addressCountry REQUIRED field, full name country or abbreviation accepted but sent
 * 	to mySQL as a 2 digit code
 *addressZip REQUIRED field, accepts 5 or 9 digit zip codes but sends a properly formatted
 * 	string "87348-2983" to mySQL
 * addressLabel OPTIONAL field, user can identify quickly whether an address is
 * 	their home, work, wife's work, etc
 *
 * @author Tyler Wiegand <tyler dot wiegand at me dot com>
 **/

class Address {
	/**
	 * unique ID for this address; primary key
	 */
	private $addressId;

	/**
	 * foreign key to correlate the user's UNIQUE emailId
	 */
	private $emailId;

	/**
	 * whether or not the address is hidden from the viewer (modified) or not
	 * this occurs any time the user changes their address
	 */
	private $addressHidden;

	/**
	 * the ATTENTION line "ATTN:" line of the postal address
	 */
	private $addressAttention;

	/**
	 * the required STREET ADDRESS 1 line of the postal address
	 */
	private $addressStreet1;

	/**
	 * the optional STREET ADDRESS 2 line of the postal address
	 */
	private $addressStreet2;

	/**
	 * the required CITY name section of the postal address
	 */
	private $addressCity;

	/**
	 * the required STATE as a 2 digit code
	 */
	private $addressState;

	/**
	 * the required COUNTRY code
	 */
	//private $addressCountry;

	/**
	 * the required ZIP code returned as a 5 or 9 digits for USA only
	 */
	private $addressZip;

	/**
	 * the optional LABEL field to users identification of their address
	 */
	private $addressLabel;

	/**
	 * the is the constructor for the Address class.
	 * @param int $newAddressId newAddressId
	 * @param string $newAddressLabel newAddressLabel
	 * @param string $newAddressAttention newAddressAttention
	 * @param string $newAddressStreet1 newAddressStreet1
	 * @param string $newAddressCity newAddressCity
	 * @param string $newAddressState newAddressState
	 * @param string $newAddressZip newAddressZip
	 * @param string $newAddressStreet2 newAddressStreet2
	 * @param int $newAddressHidden newAddressHidden
	 * @throws UnexpectedValueException if any parameters don't meet expectation (see mutator methods)
	 */
	public function __construct($newAddressId, $newAddressAttention, $newAddressStreet1,
										 $newAddressCity, $newAddressState, $newAddressZip,
										 $newAddressStreet2="", $newAddressLabel="", $newAddressHidden=0) {
		try {
			$this->setAddressId($newAddressId);
			$this->setAddressLabel($newAddressLabel);
			$this->setAddressAttention($newAddressAttention);
			$this->setAddressStreet1($newAddressStreet1);
			$this->setAddressStreet2($newAddressStreet2);
			$this->setAddressCity($newAddressCity);
			$this->setAddressState($newAddressState);
			$this->setAddressZip($newAddressZip);
			$this->setAddressHidden($newAddressHidden);

		} catch(UnexpectedValueException $exception) {
			// RE-Throw to the construct requester
			throw(new UnexpectedValueException("Unable to create Address.", 0, $exception));
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
		$html = 		"<p>Address ID: " . $this->addressId . "<br />"
			. "Address Label: ".	$this->addressLabel . "<br />"
			. "Attention: ".	$this->addressAttention . "<br />"
			. "Street 1: ".	$this->addressStreet1 . "<br />"
			. "Street 2: ".	$this->addressStreet2 . "<br />"
			. "City: ".	$this->addressCity . "<br />"
			. "State: ".	$this->addressState . "<br />"
			. "Zip: ".	$this->addressZip . "<br />"
			. "Hidden: ".	$this->addressHidden . "<br />"

			. "</p>";
		return($html);
	}

	/**
	 * accessor method to $addressId
	 *
	 * @return int value of $addressId
	 */
	public function getAddressId() {
		return($this->$addressId);
	}

	/**
	 * mutator method for $addressId
	 *
	 * @param int $newAddressId - new value of $addressId
	 * @throws UnexpectedValueException if $addressId is NOT INT
	 */
	public function setAddressId($newAddressId) {
		// verify the value of Address is a valid int
		if($newAddressId === null) {
			$this->addressId = null;
			return;
		}
		$newAddressId = filter_var($newAddressId, FILTER_VALIDATE_INT);
		if($newAddressId === false) {
			throw(new UnexpectedValueException("Address ID is not a valid integer."));
		}
		//convert addressId into an int (just for safesies)
		//THEN store it into THIS object's addressId
		$this->addressId = intval($newAddressId);
	}

	/**
	 * accessor method to $emailId
	 *
	 * @return int value of $emailId
	 */
	public function getEmailId() {
		return($this->$emailId);
	}

	/**
	 * mutator method for $emailId
	 *
	 * @param int $newEmailId - new value of $emailId
	 * @throws UnexpectedValueException if $emailId is NOT INT
	 */
	public function setEmailId($newEmailId) {
		// verify the value of emailId is a valid int
		if($newEmailId === null) {
			$this->emailId = null;
			return;
		}
		$newEmailId = filter_var($newEmailId, FILTER_VALIDATE_INT);
		if($newEmailId === false) {
			throw(new UnexpectedValueException("E-MAIL ID is not a valid integer."));
		}
		//convert emailId into an int (just for safesies)
		//THEN store it into THIS object's emailId
		$this->addressId = intval($newEmailId);
	}

	/**
	 * accessor method to $addressHidden
	 *
	 * @return int value of $addressHidden
	 */
	public function getAddressHidden() {
		return($this->$addressHidden);
	}

	/**
	 * mutator method for $addressHidden
	 *
	 * @param int $newAddressHidden - new value of $addressHidden
	 * @throws UnexpectedValueException if $addressHidden is NOT INT
	 */
	public function setAddressHidden() {
		$newAddressHidden = 1;
		$this->addressHidden = intval($newAddressHidden);
	}

	/**
	 * mutator method for $addressVisible
	 *
	 * @param int $newAddressHidden - new value of $addressHidden
	 * @throws UnexpectedValueException if $addressHidden is NOT INT
	 */
	public function setAddressVisible() {
		$newAddressHidden = 0;
		$this->addressHidden = intval($newAddressHidden);
	}

	/**
	 * accessor method to addressAttention
	 *
	 * @return string value of addressAttention
	 */
	public function getAddressAttention() {
		return($this->addressAttention);
	}

	/**
	 * mutator method for addressAttention
	 *
	 * @param string $newAddressAttention new value of addressAttention
	 * @throws UnexpectedValueException if $addressAttention is not a string
	 */
	public function setAddressAttention($newAddressAttention) {
		// verify the value of addressAttention is a valid string
		$newAddressAttention = filter_var($newAddressAttention, FILTER_SANITIZE_STRING);
		if($newAddressAttention === false) {
			throw(new UnexpectedValueException('Address ATTN: line is not a valid string.'));
		}
		//store the $newAddressAttention string
		$this->addressAttention = $newAddressAttention;
	}

	/**
	 * accessor method to addressStreet1
	 *
	 * @return string value of addressStreet1
	 */
	public function getAddressStreet1() {
		return($this->addressStreet1);
	}

	/**
	 * mutator method for addressStreet1
	 *
	 * @param string $newAddressStreet1 new value of addressStreet1
	 * @throws UnexpectedValueException if $addressStreet1 is not a string
	 */
	public function setAddressStreet1($newAddressStreet1) {
		// verify the value of addressStreet1 is a valid string
		$newAddressStreet1 = filter_var($newAddressStreet1, FILTER_SANITIZE_STRING);
		if($newAddressStreet1 === false) {
			throw(new UnexpectedValueException('Street 1 line is not a valid string.'));
		}
		// store the $newAddressStreet1 string
		$this->addressStreet1 = $newAddressStreet1;
	}

	/**
	 * accessor method to addressStreet2
	 *
	 * @return string value of addressStreet2
	 */
	public function getAddressStreet2() {
		return($this->addressStreet2);
	}

	/**
	 * mutator method for addressStreet2
	 *
	 * @param string $newAddressStreet2 new value of addressStreet2
	 * @throws UnexpectedValueException if $addressStreet2 is not a string
	 */
	public function setAddressStreet2($newAddressStreet2) {
		// verify the value of addressStreet2 is a valid string
		$newAddressStreet2 = filter_var($newAddressStreet2, FILTER_SANITIZE_STRING);
		if($newAddressStreet2 === false) {
			throw(new UnexpectedValueException('Street 2 line is not a valid string.'));
		}
		// store the $newAddressStreet2 string
		$this->addressStreet2 = $newAddressStreet2;
	}
	/**
	 * accessor method to addressCity
	 *
	 * @return string value of addressCity
	 */
	public function getAddressCity() {
		return($this->addressCity);
	}

	/**
	 * mutator method for addressCity
	 *
	 * @param string $newAddressCity new value of addressCity
	 * @throws UnexpectedValueException if $addressCity is not a string
	 */
	public function setAddressCity($newAddressCity) {
		// verify the value of addressCity is a valid string
		$newAddressCity = filter_var($newAddressCity, FILTER_SANITIZE_STRING);
		if($newAddressCity === false) {
			throw(new UnexpectedValueException('City entry is not a valid string.'));
		}
		// store the $newAddressCity string
		$this->addressCity = $newAddressCity;
	}
	/**
	 * accessor method to addressState
	 *
	 * @return string value of addressState
	 */
	public function getAddressState() {
		return($this->addressState);
	}

	/**
	 * mutator method for addressState
	 *
	 * @param string $newAddressState new value of addressState
	 * @throws UnexpectedValueException if $addressState is not a string
	 */
	public function setAddressState($newAddressState) {
		// verify the value of addressState is a valid string
		$newAddressState = filter_var($newAddressState, FILTER_SANITIZE_STRING);
		if($newAddressState === false) {
			throw(new UnexpectedValueException('State entry not a valid string.'));
		}
		// store the $newAddressState string
		$this->addressState = $newAddressState;
	}
	/**
	 * accessor method to addressCountry, commented out until needed
	 *
	 * @return string value of addressCountry
	 */
	/*
	public function getAddressCountry() {
		return($this->addressCountry);
	}
	*/

	/*
	 * mutator method for addressCountry
	 *
	 * @param string $newAddressCountry new value of addressCountry
	 * @throws UnexpectedValueException if $addressCountry is not a string
	 */
	/*
	public function setAddressCountry($newAddressCountry) {
		// verify the value of addressCountry is a valid string
		$newAddressCountry = filter_var($newAddressCountry, FILTER_SANITIZE_STRING);
		if($newAddressCountry === false) {
			throw(new UnexpectedValueException('Country entry is not a valid string.'));
		}
		// store the $newAddressCountry string
		$this->addressCountry = $newAddressCountry;
	}
	*/
	/*
	 * accessor method to addressZip
	 *
	 * @return string value of addressZip
	 */
	/*
	public function getAddressZip() {
		return($this->addressZip);
	}
	*/

	/**
	 * mutator method for addressZip
	 *
	 * @param string $newAddressZip new value of addressZip
	 * @throws UnexpectedValueException if $addressZip is not a string
	 */
	public function setAddressZip($newAddressZip) {
		// verify the value of addressZip is a valid string
		$newAddressZip = filter_var($newAddressZip, FILTER_SANITIZE_STRING);
		if($newAddressZip === false) {
			throw(new UnexpectedValueException('Zip code is not a valid string.'));
		}
		// store the $newAddressZip string
		$this->addressZip = $newAddressZip;
	}

	/**
	 * accessor method to addressLabel
	 *
	 * @return string value of addressLabel
	 */
	public function getAddressLabel() {
		return($this->addressLabel);
	}

	/**
	 * mutator method for addressLabel
	 *
	 * @param string $newAddressLabel new value of addressLabel
	 * @throws UnexpectedValueException if $addressLabel is not a string
	 */
	public function setAddressLabel($newAddressLabel) {
		// verify the value of addressLabel is a valid string
		$newAddressLabel = filter_var($newAddressLabel, FILTER_SANITIZE_STRING);
		if($newAddressLabel === false) {
			throw(new UnexpectedValueException('Address Label line is not a valid string.'));
		}
		// store the $newAddressLabel string
		$this->addressLabel = $newAddressLabel;
	}


	////////////////////PDO SECTION///////////////////
	/**
	 * This function allows the address class to insert values
	 * into the mySQL database table "address." It utilizes the PDO
	 * class built into PHP. @see php.net PDO class.
	 *
	 * @param PDO $insertParameters pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function insert(PDO &$insertParameters) {
		// ensure that you don't attempt to pass an address ID directly to database
		// address ID is an auto_incremental value!
		if($this->addressId !== null) {
			throw(new PDOException("This address ID has already been created!"));
		}

		// First step in the process to send an SQL command from PHP
		$query = "INSERT INTO address(addressId, addressLabel, addressAttention, addressStreet1, addressStreet2, addressCity, addressState, addressZip, addressHidden)
					 				 VALUES(:addressId, :addressLabel, :addressAttention, :addressStreet1, :addressStreet2, :addressCity, :addressState, :addressZip, :addressHidden)";

		// turn $unpreparedStatement into $preparedStatement with the contents of $query and the prepare PDO method
		$preparedStatement = $insertParameters->prepare($query);

		// create an array filled with
		$insertParameters = array("addressId" => $this->addressId,
			"addressLabel" => $this->addressLabel,
			"addressAttention" => $this->addressAttention,
			"addressStreet1" => $this->addressStreet1,
			"addressStreet2" => $this->addressStreet2,
			"addressCity" => $this->addressCity,
			"addressState" => $this->addressState,
			"addressZip" => $this->addressZip,
			"addressHidden" => $this->addressHidden);

			// take the parameters given and stick them into the :denoted places in $query
			// the prepared statement now executes with inserted parameters
			$preparedStatement->execute($insertParameters);

		// FINALLY, we can catch up to a full object with the addressId that
		// we just generated automagically within mySQL
		// "please tell me what box i just stuck all my junk into, please mySQL??"
		// remember, you're just telling the OBJECT what the ID is,
		// NOT mySQL; hence, "catch up" to the autointeger mySQL created
		$this->addressId = intval($insertParameters->lastInsertId());
	}

	/**
	 * deletes function for the ADMINs to manually delete an address entry
	 *
	 * @param PDO $adminDeleteParameters pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function adminDelete(PDO &$adminDeleteParameters) {
		if($this->addressId === null) {
			throw(new PDOException("How you gonna delete somethin' that ain't THERE?"));
		}
		$query = "DELETE FROM addressId, addressLabel, addressAttention, addressStreet1,
					 addressStreet2, addressCity, addressState, addressZip, addressHidden
					 WHERE addressId = :addressId";
		$preparedStatement = $adminDeleteParameters->prepare($query);
		$parameters = array("addressId" => $this->addressId);
		$preparedStatement->execute($parameters);
	}

	/**
	 * edit function (simulated) for the USERs to HIDE an address entry
	 *
	 * @param PDO $userDeleteParameters pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function userDelete(PDO &$userDeleteParameters) {
		if($this->addressId === null) {
			throw(new PDOException("How you gonna delete somethin' that ain't THERE?"));
		}
		$query = "UPDATE address SET addressHidden = 1 WHERE addressId = :addressId";
		$preparedStatement = $userDeleteParameters->prepare($query);
		$parameters = array("addressId" => $this->addressId);
		$preparedStatement->execute($parameters);
	}

	/**
	 * gets the address by addressId
	 *
	 * @param PDO $getAddressParameters pointer to PDO connection, by reference
	 * @param int $addressId to search for
	 * @return mixed Address found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getAddressByAddressId(PDO &$getAddressParameters, $addressId) {
		$addressId = filter_var($addressId, FILTER_VALIDATE_INT);
		if($addressId === false) {
			throw(new PDOException("Address ID given is not valid."));
		}
		if($addressId <= 0) {
			throw(new PDOException("Address ID's must be above 0."));
		}

		// template for our mySQL statement. we put the :addressId in from the $addressId arg later on...
		$query = "SELECT 	addressId, addressLabel, addressAttention, addressStreet1, addressStreet2, addressCity,
								addessState, addressZip, addressHidden FROM address WHERE addressId = :addressId";
		// prepare the statement. PDO does it!
		$preparedStatement = $getAddressParameters->prepare($query);
		// lets give some parameters for our statement. or arguments. ARGUE WITH STATEMENT!
		$parameters = array("addressId" => $addressId);
		// so we've just given $parameters something to chew on, and it's addressId, which came from our array
		// that contains a relational array. this is so we can match it up to :addressId. It's a PDO thing!
		// now we can tell PDO through the execute method to send our preparedStatement with parameters as the argument!
		// MAGIC!
		$preparedStatement->execute($parameters);
		// now our preparedStatement has the same stuff it had it in before, we just used it in combination
		// with parameters to do the execute. it's still there!


		try {

			// declare returnAddress so we can return it after we find what we're looking for (IF we do!)
			// but we cant return NOTHING...well, we CAN return NULL but not nothing...ironic...
			$returnAddress = null;
			// within our preparedStatement variable, change the fetch mode in PDO so it gets it as an
			// associative array (you have to)
			$preparedStatement->setFetchMode(PDO::FETCH_ASSOC);
			// now our preparedStatement isn't what we care about. we want our results (as an array)
			$results   = $preparedStatement->fetch();
			// now if we actually got something, we want to be able to assign it to returnAddress. Remember
			// results are from the PDO statement, returnAddress is what we want the METHOD to output.
			if($results !== false) {
				$returnAddress = new Address($results["addressId"], $results["addressLabel"], $results["addressAttention"],
					$results["addressStreet1"], $results["addressStreet2"], $results["addressCity"], $results["addressState"],
					$results["addressZip"], $results["addressHidden"]);
			}
		} catch(Exception $exception) {
			// exception? NO PROBLEM! Throw it ...away...to someone else.
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		// alright if everything went well we have our address results returned to us. Nice!
		return($returnAddress);
	}


}
