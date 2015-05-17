<?php
// grab the project test parameters
require_once("cheqouttest.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/class/email.php");
require_once(dirname(__DIR__) . "/php/class/account.php");

/**
 * Full PHPUnit test for the Account class
 *
 * This is a complete PHPUnit test of the Account class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Account
 * @author Kyla Carroll <kylacarroll43@gmail.com>
 **/
class AccountTest extends CheqoutTest {
	/**
	 * valid password
	 * @var string $VALID_PW
	 */
	protected $VALID_PW = "qqqqqqqqq1wwwwwwwww2eeeeeeeee3rrrrrrrrr4tttttttt5yyyyyyyyy6uuuuuuuuu7iiiiiiiii8ooooooooo9ppppppppp0qqqqqqqqq1wwwwwwwww2eeeeeeeee";
	/**
	 * valid password salt
	 * @var int $VALID_PWSALT
	 */
	protected $VALID_PWSALT = "FE0766A6AC18F9EDC1662BA66940D6A03E7EF9C332D049980F3B036CF1E93310";
	/**
	 * valid activation code
	 * @var int $VALID_ACTIVATION
	 */
	protected $VALID_ACTIVATION = "activationactivationactivation32";
	/**
	 * valid account creation date time
	 * @var datetime $VALID_CREATEDATE
	 */
	protected $VALID_CREATEDATE = "0000-00-00 00:00:00";
	/**
	 * valid password change
	 * @var string $VALID_PW2
	 */
	protected $VALID_PW2 = "qqqqqqqqq1wwwwwwwww2eeeeeeeee3rrrrrrrrr4tttttttt5yyyyyyyyy6uuuuuuuuu7iiiiiiiii8ooooooooo9ppppppppp0qqqqqqqqq1wwwwwwwww2eeeeeeeeF";
	/**
	 * email parent object for foreign key relations
	 * @var Email $email
	 */
	protected $email = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();
		//create and insert an Email parent object
		$this->email = new Email(null,"jim@cnm.edu","stripe");
		$this->email->insert($this->getPDO());
	}

	/**
	 * test insert on valid account and verify mySQL data matches
	 **/
	public function testInsertValidAccount() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new Account and insert to into mySQL
		$account = new Account(null, $this->VALID_PW, $this->VALID_PWSALT, $this->VALID_ACTIVATION,
			$this->VALID_CREATEDATE, $this->email->getEmailId());
		$account->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAccount = Account::getAccountByAccountId($this->getPDO(), $account->getAccountId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("account"));
		$this->assertSame($pdoAccount->getAccountPassword(), $this->VALID_PW);
		$this->assertSame($pdoAccount->getAccountPasswordSalt(), $this->VALID_PWSALT);
		$this->assertSame($pdoAccount->getActivation(), $this->VALID_ACTIVATION);
		$this->assertSame($pdoAccount->getAccountCreateDateTime(), $this->VALID_CREATEDATE);
		$this->assertSame($pdoAccount->getEmailId(), $this->email->getEmailId());
	}
	/**
	 * test insert on an invalid account
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidAccount() {
		$email = new Account(CheqoutTest::INVALID_KEY, $this->VALID_PW, $this->VALID_PWSALT, $this->VALID_ACTIVATION,
			$this->VALID_CREATEDATE, $this->email->getEmailId());
		$email->insert($this->getPDO());
	}

	/**
	 * test delete of valid account
	 **/
	public function testDeleteValidAccount() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new account and insert to into mySQL
		$account = new Account(null, $this->VALID_PW, $this->VALID_PWSALT, $this->VALID_ACTIVATION,
			$this->VALID_CREATEDATE, $this->email->getEmailId());

		$account->insert($this->getPDO());

		//run the delete function
		$account->delete($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAccount = Account::getAccountByAccountId($this->getPDO(), $account->getAccountId());
		$this->assertNull($pdoAccount);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("account"));
	}

	/**
	 * test delete of invalid account
	 *
	 * @expectedException PDOException
	 */
	public function testDeleteInvalidAccount() {
		$account = new Account(null, $this->VALID_PW, $this->VALID_PWSALT, $this->VALID_ACTIVATION,
			$this->VALID_CREATEDATE, $this->email->getEmailId());
		$account->delete($this->getPDO());
	}

	/**
	 * test update of password on a valid account
	 **/
	public function testUpdateValidAccount() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new account and insert to into mySQL
		$account = new Account(null, $this->VALID_PW, $this->VALID_PWSALT, $this->VALID_ACTIVATION,
			$this->VALID_CREATEDATE, $this->email->getEmailId());
		$account->insert($this->getPDO());

		// update the shipping address id field
		$account->setAccountPassword($this->VALID_PW2);
		$account->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAccount = Account::getAccountByAccountId($this->getPDO(), $account->getAccountId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("account"));
		$this->assertSame($pdoAccount->getAccountPassword(), $this->VALID_PW2);
		$this->assertSame($pdoAccount->getAccountPasswordSalt(), $this->VALID_PWSALT);
		$this->assertSame($pdoAccount->getActivation(), $this->VALID_ACTIVATION);
		$this->assertSame($pdoAccount->getAccountCreateDateTime(), $this->VALID_CREATEDATE);
		$this->assertSame($pdoAccount->getEmailId(), $this->email->getEmailId());
	}
	/**
	 * test update with invalid shipping address
	 *
	 * @expectedException RangeException
	 */
	public function testUpdateInvalidAccount() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new account and insert to into mySQL
		$account = new Account(null, $this->VALID_PW, $this->VALID_PWSALT, $this->VALID_ACTIVATION,
			$this->VALID_CREATEDATE, $this->email->getEmailId());
		$account->insert($this->getPDO());

		//update the password field
		$account->setAccountPassword(CheqoutTest::INVALID_STRING);
		$account->update($this->getPDO());
	}

	/**
	 * test getting account by account id
	 **/
	public function testGetValidAccountByAccountId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");

		// create a new address and insert to into mySQL
		$account = new Account(null, $this->VALID_PW, $this->VALID_PWSALT, $this->VALID_ACTIVATION,
			$this->VALID_CREATEDATE, $this->email->getEmailId());
		$account->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAccount = Account::getAccountByAccountId($this->getPDO(), $account->getAccountId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("account"));
		$this->assertSame($pdoAccount->getAccountPassword(), $this->VALID_PW);
		$this->assertSame($pdoAccount->getAccountPasswordSalt(), $this->VALID_PWSALT);
		$this->assertSame($pdoAccount->getActivation(), $this->VALID_ACTIVATION);
		$this->assertSame($pdoAccount->getAccountCreateDateTime(), $this->VALID_CREATEDATE);
		$this->assertSame($pdoAccount->getEmailId(), $this->email->getEmailId());
	}
	/**
	 * test grabbing an account that does not exist by account id
	 **/
	public function testGetInvalidAccountByAccountId() {
		// grab an account id that exceeds the maximum allowable account id int
		$account = Account::getAccountByAccountId($this->getPDO(), CheqoutTest::INVALID_KEY);
		$this->assertNull($account);
	}
	/**
	 * test inserting an account and re-grabbing it from mySQL by emailId
	 **/
	public function testGetValidAccountByEmailId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("account");
		// create a new address and insert to into mySQL
		$account = new Account(null, $this->VALID_PW, $this->VALID_PWSALT, $this->VALID_ACTIVATION,
			$this->VALID_CREATEDATE, $this->email->getEmailId());
		$account->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Account::getAccountByEmailId($this->getPDO(), $account->getEmailId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("account"));

		// grab the result
		$pdoAccount = $results;
		$this->assertSame($pdoAccount->getAccountPassword(), $this->VALID_PW);
		$this->assertSame($pdoAccount->getAccountPasswordSalt(), $this->VALID_PWSALT);
		$this->assertSame($pdoAccount->getActivation(), $this->VALID_ACTIVATION);
		$this->assertSame($pdoAccount->getAccountCreateDateTime(), $this->VALID_CREATEDATE);
		$this->assertSame($pdoAccount->getEmailId(), $this->email->getEmailId());
	}
	/**
	 * test grabbing an account that does not exist by email id
	 **/
	public function testGetInvalidAccountByEmailId() {
		// grab an email id that exceeds the maximum allowable address id
		$account = Account::getAccountByEmailId($this->getPDO(), CheqoutTest::INVALID_KEY);
		$this->assertNull($account);
	}

	/**
	 * test breaking password
	 *
	 * @expectedException RangeException
	 **/

	public function testBreakingPassword() {
		new Account(null, CheqoutTest::INVALID_STRING, $this->VALID_PWSALT, $this->VALID_ACTIVATION,
			$this->VALID_CREATEDATE, $this->email->getEmailId());
	}
	/**
	 * test breaking password salt
	 *
	 * @expectedException RangeException
	 **/

	public function testBreakingPasswordSalt() {
		new Account(null, $this->VALID_PW, CheqoutTest::INVALID_STRING, $this->VALID_ACTIVATION,
			$this->VALID_CREATEDATE, $this->email->getEmailId());
	}
	/**
	 * test breaking activation
	 *
	 * @expectedException RangeException
	 **/

	public function testBreakingActivation() {
		new Account(null, $this->VALID_PW, $this->VALID_PWSALT, CheqoutTest::INVALID_STRING,
			$this->VALID_CREATEDATE, $this->email->getEmailId());
	}
	/**
	 * test breaking create date time
	 *
	 * @expectedException RangeException
	 **/

	public function testBreakingDateTime() {
		new Account(null, $this->VALID_PW, $this->VALID_PWSALT, $this->VALID_ACTIVATION,
			CheqoutTest::INVALID_STRING, $this->email->getEmailId());
	}

}
