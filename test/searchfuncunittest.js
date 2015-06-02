/**
 * Created by jameshill on 5/26/15.
 */

// open a new window with the controller under scrutiny
module("tabs", {
	setup: function() {
		F.open("../search/index.php");
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
	F("#search").type(VALID_SEARCH + "[enter]");

	// click the button once all the fields are filled in
	F("#searchSubmit").click();

	// assert we got the success message from the AJAX call
	F(".data-row").visible(function() {
		var dataCell = F(this).children()[0];
		ok(isNaN(dataCell.innerHTML) === false, "product cell is an integer");
	});
}

/**
 * test filling in invalid form data
 **/
function testInvalidFields() {
	// fill in the form values
	F("#search").type(INVALID_SEARCH + "[enter]");

	// click the button once all the fields are filled in
	F("#searchSubmit").click();

	// assert we got the success message from the AJAX call
	F("p").visible(function() {
		ok(F(this).hasClass("alert-warning"), "warning alert CSS");
		//ok(F(this).html().indexOf("Cannot add or update a child row") >= 0, "unsuccessful message");
	});
}

// the test function *MUST* be called in order for the test to execute
test("test valid fields", testValidFields);
test("test invalid fields", testInvalidFields);