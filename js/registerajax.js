// document ready event
$(document).ready(
	// inner function for the ready() event
	function() {
		// tell the validator to validate this form ID
		$("#register").validate({
			// setup the formatting for the errors
			errorClass: "alert-warning",
			errorLabelContainer: "#registerOutput",
			wrapper: "li",
			// rules define what is good/bad input
			rules: {
				// each rule starts with the inputs name (NOT id)
				email: {
					minlength: 5,
					maxlength: 128,
					required: true
				},
				password: {
					minlength: 4,
					maxlength: 128,
					required: true
				},
				password2: {
					minlength: 4,
					maxlength: 128,
					required: true
				}
			},
			// error messages to display to the end user
			messages: {
				email: {
					minlength: "Your email is too short.",
					maxlength: "Your email is too long.",
					required: "You must enter an email."
				},
				password: {
					minlength: "Your password is too short.",
					maxlength: "Your password is too long.",
					required: "Your password is required."
				},
				password2: {
					minlength: "Your password is too short.",
					maxlength: "Your password is too long.",
					required: "Your password check is required."
				}
			},

			// setup an AJAX call to submit the form without reloading
			submitHandler: function(form) {
				$(form).ajaxSubmit({
					// GET or POST
					type: "POST",
					// where to submit data
					url: "../register/register.php",
					// TL; DR: reformat POST data
					data: $(form).serialize(),
					// success is an event that happens when the server replies
					success: function(ajaxOutput) {
						// clear the output area's formatting
						$("#registerOutput").css("display", "");
						// write the server's reply to the output area
						$("#registerOutput").html(ajaxOutput);


						// reset the form if it was successful
						// this makes it easier to reuse the form again
						if($(".alert-success").length >= 1) {
							$(form)[0].reset();
						}
					}
				});
			}
		});
	})