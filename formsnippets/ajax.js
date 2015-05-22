// document ready event
$(document).ready(
	// inner function for the ready() event
	function() {

		// tell the validator to validate this form
		$("#address").validate({
			// setup the formatting for the errors
			errorClass: "label-danger",
			errorLabelContainer: "#outputArea",
			wrapper: "li",

			// rules define what is good/bad input
			rules: {
				// each rule starts with the input's name (NOT id)
				attention: {
					maxlength: 100,
					required: true
				},
				street1: {
					maxlength: 128,
					required: true
				},
				street2: {
					maxlength: 128,
					required: false
				},
				city: {
					maxlength: 128,
					required: true
				},
				state: {
					maxlength: 64,
					required: true
				},
				zip: {
					min: 1,
					max: 99999-9999,
					required: true,
					maxlength: 10
				},
				label: {
					maxlength: 20,
					required: false
				}
			},

			// error messages to display to the end user
			messages: {
				attention: {
					maxlength: "Your Attention line is too long! Like this message!",
					required: true
				},
				street1: {
					maxlength: "We need Street 1 to be a little...smaller...Please?",
					required: true
				},
				street2: {
					maxlength: "You don't need to fill it out, but if you do, LESS! PLEASE!",
					required: false
				},
				city: {
					maxlength: "Less. Much less.",
					required: true
				},
				state: {
					maxlength: "There aren't even states with this many PEOPLE!",
					required: true
				},
				zip: {
					min: "We need a few numbers at least...",
					max: "The ZIP CODE IS TOO HIGH!",
					required: true,
					maxlength: "Too long! Sorry!"
				},
				label: {
					maxlength: "We only allow twenty characters to live here. My bad.",
					required: false
				}
			},

			// setup an AJAX call to submit the form without reloading
			submitHandler: function(form) {
				$(form).ajaxSubmit({
					// GET or POST
					type: "POST",
					// where to submit data
					url: "addressinsert.php",
					// TL; DR: reformat POST data
					data: $(form).serialize(),
					// success is an event that happens when the server replies
					success: function(ajaxOutput) {
						// clear the output area's formatting
						$("#outputArea").css("display", "");
						// write the server's reply to the output area
						$("#outputArea").html(ajaxOutput);
						// reset the form if it was successful
						// this makes it easier to reuse the form again
						if($(".alert-success").length >= 1) {
							$(form)[0].reset();
						}
					}
				});
			}
		});
	});

// document ready event
$(document).ready(
	// inner function for the ready() event
	function() {
		// tell the validator to validate this form ID
		$("#account-update").validate({
			// setup the formatting for the errors
			errorClass: "label-danger",
			errorLabelContainer: "#emailOutputArea",
			wrapper: "li",
			// rules define what is good/bad input
			rules: {
				// each rule starts with the inputs name (NOT id)
				activationcode: {
					min: 32,
					maxlength: 32,
					required: true
				},
				newemail: {
					maxlength: 128,
					required: true
				},
				emailcheck: {
					maxlength: 128,
					required: true
				}
			},
			// error messages to display to the end user
			messages: {
				activationcode: {
					min: "Activation code must be copy/pasted directly from the email.",
					maxlength: "Activation code must be copy/pasted directly from the email.",
					required: "Activation code is required."
				},
				newemail: {
					maxlength: "Your E-Mail is WAY too long.",
					required: "You DO have an E-Mail...right?"
				},
				emailcheck: {
					maxlength: "Your E-Mail is WAY too long.",
					required: "We need your E-Mail twice...sorry =("
				}
			},

			// setup an AJAX call to submit the form without reloading
			submitHandler: function(form) {
				$(form).ajaxSubmit({
					// GET or POST
					type: "POST",
					// where to submit data
					url: "accountupdateinsert.php",
					// TL; DR: reformat POST data
					data: $(form).serialize(),
					// success is an event that happens when the server replies
					success: function(ajaxOutput) {
						// clear the output area's formatting
						$("#emailOutputArea").css("display", "");
						// write the server's reply to the output area
						$("#emailOutputArea").html(ajaxOutput);


						// reset the form if it was successful
						// this makes it easier to reuse the form again
						if($(".alert-success").length >= 1) {
							$(form)[0].reset();
						}
					}
				});
			}
		});
	});
