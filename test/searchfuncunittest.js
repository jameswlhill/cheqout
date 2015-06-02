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
var VALID_SEARCH = "second";
var INVALID_SEARCH = "123456";

/**
 * test filling in only valid POST data
 **/
function testValidFields() {
	// fill in the form values
	F("#search").type(VALID_SEARCH);

	// click the button once all the fields are filled in
	F("#searchSubmit").click();

	// assert we got the success message from the AJAX call
	F(".table").visible(function() {


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
	F(".table").visible(function() {


	});
}

// the test function *MUST* be called in order for the test to execute
test("test valid fields", testValidFields);
test("test invalid fields", testInvalidFields);