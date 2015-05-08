<?php
/**
 * CheqoutOrder class
 *
 * this is the effing order class, with the primary key of orderId,
 * references the emailId and stripId of the user who placed the order,
 * the addressId of whatever address was stored to be used for shipping.
 * creates the datetime of the order placement.
 *
 * @author Kyla Carroll <kylacarroll43@gmail.com>
 */

class cheqoutOrder {
	//the auto-incrementing id associated with each order
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
	 * @throw UnexpectedValueException if $newOrderId is not a valid integer
	 */
	public function setOrderId() {
		if ($newOrderId === null) {
			return;
		}
		$newOrderId = filter_var($newOrderId, FILTER_VALIDATE_INT);
		if ($newOrderId === false) {
			throw (new UnexpectedValueException("order ID is invalid"));
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
	 */
	public function setEmailId() {
		if ($newEmailId === null) {
			return;
		}
		$newEmailId = filter_var($newEmailId, FILTER_VALIDATE_INT);
		if ($newEmailId === false) {
			throw (new UnexpectedValueException("email ID is invalid"));
		}
		//store the new email Id
		$this->emailId = intval($newEmailId);
	}
}