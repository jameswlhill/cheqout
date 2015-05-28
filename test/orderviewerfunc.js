/**
 * copied by tyler wiegand on 5/28/15.
 */

// open a new window with the controller under scrutiny
module("tabs", {
	setup: function() {
		F.open("../formsnippets/orderviewer.php");
	}
});

// global variables for POST values
var INVALID_ANYTHING = "7yt8hu3wergsfdbuhiqruegfs8hbjergfiluskhjebrgdlifubhjkbwertsbdfiluhjksnetdghusdgfkjhserliugjsethsrthrthdfghdsetrhsrdghesrthsthgsdfb";
var VALID_ORDERID = "1";

/**
 * test what we assume to be CORRECT
 **/
function testValidFields() {
	// fill in the form values
	F("#orderid").visible().click().type('[ctrl]a[ctrl-up][delete]');
	F("#orderid").type(VALID_ORDERID);

	// click the button once all the fields are filled in
	F("#orderidbutton").click();

	// assert we got the success message from the AJAX call
	F("#order-header").visible(function() {
		// ok() to assert truthiness
		ok(F(this).hasClass("text-info"), "PRETTY GREEN!");
		ok(F(this).html().indexOf("Shipping Cost") >= 0, "It posted!");
	});

	// click the button, no fields this time!
	F("#orderhistory").click();

	// assert we got the success message from the AJAX call
	F("#order-header").visible(function() {
		// ok() to assert truthiness
		ok(F(this).hasClass("text-info"), "PRETTY GREEN!");
		ok(F(this).html().indexOf("Shipping Cost") >= 0, "It posted!");
	});
}

/**
* test what we assume to be WRROOOOOOOOOOONG (lex luthor)
**/
function testInvalidFields() {
	// fill in the form values
	F("#orderid").visible().click().type('[ctrl]a[ctrl-up][delete]');
	F("#orderid").type(INVALID_ANYTHING);

	// click the button once all the fields are filled in
	F("#orderidbutton").click();

	// assert we got the success message from the AJAX call
	F("#orderid-error").visible(function() {
		// ok() to assert truthiness
		ok(F(this).hasClass("label-danger"), "PRETTY RED!");
		ok(F(this).html().indexOf("number is 1 or") >= 0, "It didn't work!!");
	});
}

// the test function *MUST* be called in order for the test to execute
test("test valid fields", testValidFields);
test("test invalid fields", testInvalidFields);