/**
 * Created by jameshill on 5/26/15.
 */

// open a new window with the controller under scrutiny
module("tabs", {
	setup: function() {
		F.open("../search/activate.php");
	}
});

// global variables for POST values
var VALID_SEARCH = "evil cheney";
var INVALID_SEARCH = "<script></script>";

/**
 * test filling in only valid POST data
 **/
function testValidFields() {
	// fill in the form values
	F("#search").type(VALID_SEARCH);

	// click the button once all the fields are filled in
	F("#searchSubmit").click();

	// assert we got the success message from the AJAX call
	F(".alert").visible(function() {
		// create a regular expression that evaluates the successful text
		var successRegex = /^[a-zA-Z]*$/;

		// ok() to assert truthiness
		ok(F(this).hasClass("alert-success"), "successful search happy colors");
		ok(successRegex.test(F(this).html()), "your search was a success!");
	});
}

/**
 * test filling in invalid form data
 **/
function testInvalidFields() {
	// fill in the form values
	F("#search").type(INVALID_SEARCH);

	// click the button once all the fields are filled in
	F("#searchSubmit").click();

	// assert we got the success message from the AJAX call
	F(".alert").visible(function() {
		ok(F(this).hasClass("alert-danger"), "unsuccessful unhappy search colors");
		ok(F(this).html().indexOf("Cannot add or update a child row") >= 0, "no search for you");
	});
}

// the test function *MUST* be called in order for the test to execute
test("test valid fields", testValidFields);
test("test invalid fields", testInvalidFields);