/**
 * copied by tyler wiegand on 5/28/15.
 */

// open a new window with the controller under scrutiny
module("tabs", {
	setup: function() {
		F.open("../formsnippets/accountupdateform.php");
	}
});

// global variables for POST values
var INVALID_ANYTHING = "7yt8hu3wergsfdbuhiqruegfs8hbjergfiluskhjebrgdlifubhjkbwertsbdfiluhjksnetdghusdgfkjhserliugjsethsrthrthdfghdsetrhsrdghesrthsthgsdfb";
var VALID_EMAILID = "1";
var VALID_LABEL = "Work";
var VALID_ATTENTION = "Irene Butts";
var VALID_STREET1 = "123 Idiot St";
var VALID_STREET2 = "Apt 27";
var VALID_CITY = "Los Rancheros";
var VALID_STATE = "New Montana";
var VALID_ZIP = "87923";

/**
* test what we assume to be CORRECT
**/
function testValidFields() {
	// fill in the form values
	F("#emailid").type(VALID_EMAILID);
	F("#label").type(VALID_LABEL);
	F("#attention").type(VALID_ATTENTION);
	F("#street1").type(VALID_STREET1);
	F("#street2").type(VALID_STREET2);
	F("#city").type(VALID_CITY);
	F("#state").type(VALID_STATE);
	F("#zip").type(VALID_ZIP);

	// click the button once all the fields are filled in
	F("#submitaddress").click();

	// assert we got the success message from the AJAX call
	F(".alert").visible(function() {
		// ok() to assert truthiness
		ok(F(this).hasClass("alert-success"), "PRETTY GREEN!");
		ok(F(this).html().indexOf("Address (id = ") >= 0, "It posted!");
	});
}

/**
 * test what we assume to be WRROOOOOOOOOOONG (lex luthor)
 **/
function testInvalidFields() {
	// fill in the form values
	F("#emailid").type(INVALID_ANYTHING);
	F("#label").type(INVALID_ANYTHING);
	F("#attention").type(INVALID_ANYTHING);
	F("#street1").type(INVALID_ANYTHING);
	F("#street2").type(INVALID_ANYTHING);
	F("#city").type(INVALID_ANYTHING);
	F("#state").type(INVALID_ANYTHING);
	F("#zip").type(INVALID_ANYTHING);

	// click the button once all the fields are filled in
	F("#submitaddress").click();

	// assert we got the unsuccessful message from the AJAX call
	F("#emailid-error").visible(function() {
		ok(F(this).hasClass("label-danger"), "It's a danger class!");
		ok(F(this).html().indexOf("no more than") >= 0, "EmailId works!");
	});
	F("#label-error").visible(function() {
		ok(F(this).hasClass("label-danger"), "It's a danger class!");
		ok(F(this).html().indexOf("twenty characters") >= 0, "Label works!");
	});
	F("#attention-error").visible(function() {
		ok(F(this).hasClass("label-danger"), "It's a danger class!");
		ok(F(this).html().indexOf("is too long") >= 0, "Attention works!");
	});
	F("#street1-error").visible(function() {
		ok(F(this).hasClass("label-danger"), "It's a danger class!");
		ok(F(this).html().indexOf("to be a little") >= 0, "Street 1 works!");
	});
	F("#street2-error").visible(function() {
		ok(F(this).hasClass("label-danger"), "It's a danger class!");
		ok(F(this).html().indexOf("fill it out") >= 0, "Street 2 works!");
	});
	F("#city-error").visible(function() {
		ok(F(this).hasClass("label-danger"), "It's a danger class!");
		ok(F(this).html().indexOf("Much less") >= 0, "City works!");
	});
	F("#state-error").visible(function() {
		ok(F(this).hasClass("label-danger"), "It's a danger class!");
		ok(F(this).html().indexOf("states with this many") >= 0, "State works!");
	});
	F("#zip-error").visible(function() {
		ok(F(this).hasClass("label-danger"), "It's a danger class!");
		ok(F(this).html().indexOf("a few numbers") >= 0, "Zip works!");
	});
}

// the test function *MUST* be called in order for the test to execute
test("test valid fields", testValidFields);
test("test invalid fields", testInvalidFields);