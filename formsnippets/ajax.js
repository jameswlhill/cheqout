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
				// each rule starts with the inputs name (NOT id)
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
					required: true
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
				profileId: {
					min: "Profile id must be positive",
					required: "Please enter a profile id"
				},
				tweetContent: {
					maxlength: "Tweet is too long.",
					required: "What's on your mind?"
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