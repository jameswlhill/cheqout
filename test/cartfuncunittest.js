/**
 * Created by jameshill on 5/26/15.
 */

// open a new window with the controller under scrutiny
module("tabs", {
	setup: function() {
		F.open("../controllers/cartcontroller.php");
	}
});

// global variables for POST values
var INVALID_PRODUCTID = "I haz profile id?";
var INVALID_QUANTITY = "FuncUnit tests fail!";
var VALID_PRODUCTID = "1";
var VALID_QUANTITY = "25";

/**
* test filling in only valid POST data
**/
function testValidFields() {
	// fill in the form values
	F("#productId").type(VALID_PRODUCTID);
	F("#quantity").type(VALID_QUANTITY);

	// click the button once all the fields are filled in
	F("#orderSubmit").click();

	// assert we got the success message from the AJAX call
	F(".alert").visible(function() {
		// create a regular expression that evaluates the successful text
		var successRegex = /Order \(id = \d+\) submitted!/;

		// ok() to assert truthiness
		ok(F(this).hasClass("alert-success"), "successful order happy colors");
		ok(successRegex.test(F(this).html()), "your order was a success!");
	});
}

/**
 * test filling in invalid form data
 **/
function testInvalidFields() {
	// fill in the form values
	F("#productId").type(INVALID_PRODUCTID);
	F("#quantity").type(INVALID_QUANTITY);

	// click the button once all the fields are filled in
	F("#orderSubmit").click();

	// assert we got the success message from the AJAX call
	F(".alert").visible(function() {
		ok(F(this).hasClass("alert-danger"), "unsuccessful unhappy order colors");
		ok(F(this).html().indexOf("Cannot add or update a child row") >= 0, "no order for you");
	});
}

// the test function *MUST* be called in order for the test to execute
test("test valid fields", testValidFields);
test("test invalid fields", testInvalidFields);