// document ready event
$(document).ready(
	// inner function for the ready() event
	function() {
		// tell the validator to validate this form
		$("#address").validate({
			// setup the formatting for the errors
			errorClass: "alert alert-danger",
			errorLabelContainer: "#addressOutputArea",
			wrapper: "p",
			// rules define what is good/bad input
			rules: {
				// each rule starts with the input's name (NOT id)
				emailid: {
					maxlength: 100,
					required: true
				},

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
					pattern: /^([0-9]{5}(?:-[0-9]{4})?$)|([0-9]{9})/,
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
					required: "We need Attention. Blame the USPS..."
				},
				street1: {
					maxlength: "We need Street 1 to be a little...smaller...Please?",
					required: "We REALLY NEED at least one street line to be entered..."
				},
				street2: {
					maxlength: "You don't need to fill it out, but if you do, LESS! PLEASE!"
				},
				city: {
					maxlength: "Less. Much less.",
					required: "Please tell us where you City!"
				},
				state: {
					maxlength: "There aren't even states with this many PEOPLE!",
					required: "We need to know your State. Please."
				},
				zip: {
					pattern: "The Zip Code must be formatted with 5 digits or 9 digits. Only.",
					required: "Zip Code must be entered to proceed. Go directly to jail, do not collect $200.",
					maxlength: "Too long! Sorry!"
				},
				label: {
					maxlength: "We only allow twenty characters to live here. My bad."
				}
			}

			//// setup an AJAX call to submit the form without reloading
			//submitHandler: function(form) {
			//	$(form).ajaxSubmit({
			//		// GET or POST
			//		type: "POST",
			//		// where to submit data
			//		url: "addressinsert.php",
			//		// TL; DR: reformat POST data
			//		data: $(form).serialize(),
			//		// success is an event that happens when the server replies
			//		success: function(ajaxOutput) {
			//			// clear the output area's formatting
			//			$("#addressOutputArea").css("display", "");
			//			// write the server's reply to the output area
			//			$("#addressOutputArea").html(ajaxOutput);
			//			// reset the form if it was successful
			//			// this makes it easier to reuse the form again
			//			if($(".alert-success").length >= 1) {
			//				$(form)[0].reset();
			//			}
			//		}
			//	});
			//}
		});
		$("#addressupdate").validate({
			// setup the formatting for the errors
			errorClass: "alert alert-danger",
			errorLabelContainer: "#addressUpdateOutputArea",
			wrapper: "span",
			// rules define what is good/bad input
			rules: {
				// each rule starts with the input's name (NOT id)
				emailid: {
					maxlength: 100,
					required: true
				},

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
					pattern: /^([0-9]{5}(?:-[0-9]{4})?$)|([0-9]{9})/,
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
					required: "We need Attention. Blame the USPS..."
				},
				street1: {
					maxlength: "We need Street 1 to be a little...smaller...Please?",
					required: "We REALLY NEED at least one street line to be entered..."
				},
				street2: {
					maxlength: "You don't need to fill it out, but if you do, LESS! PLEASE!"
				},
				city: {
					maxlength: "Less. Much less.",
					required: "Please tell us where you City!"
				},
				state: {
					maxlength: "There aren't even states with this many PEOPLE!",
					required: "We need to know your State. Please."
				},
				zip: {
					pattern: "The Zip Code must be formatted with 5 digits or 9 digits. Only.",
					required: "Zip Code must be entered to proceed. Go directly to jail, do not collect $200.",
					maxlength: "Too long! Sorry!"
				},
				label: {
					maxlength: "We only allow twenty characters to live here. My bad."
				}
			}

			//// setup an AJAX call to submit the form without reloading
			//submitHandler: function(form) {
			//	$(form).ajaxSubmit({
			//		// GET or POST
			//		type: "POST",
			//		// where to submit data
			//		url: "addressinsert.php",
			//		// TL; DR: reformat POST data
			//		data: $(form).serialize(),
			//		// success is an event that happens when the server replies
			//		success: function(ajaxOutput) {
			//			// clear the output area's formatting
			//			$("#addressOutputArea").css("display", "");
			//			// write the server's reply to the output area
			//			$("#addressOutputArea").html(ajaxOutput);
			//			// reset the form if it was successful
			//			// this makes it easier to reuse the form again
			//			if($(".alert-success").length >= 1) {
			//				$(form)[0].reset();
			//			}
			//		}
			//	});
			//}
		});
		$("#emailchange").validate({
			// setup the formatting for the errors
			errorClass: "alert alert-danger",
			errorLabelContainer: "#emailOutputArea",
			wrapper: "span",
			// rules define what is good/bad input
			rules: {
				// each rule starts with the inputs name (NOT id)
				newemail: {
					minlength: 5,
					maxlength: 128,
					required: true
				},
				emailcheck: {
					minlength: 5,
					maxlength: 128,
					required: true
				}
			},
			// error messages to display to the end user
			messages: {
				newemail: {
					minlength: "Your email must be an actual email",
					maxlength: "Your E-Mail is WAY too long.",
					required: "You DO have an E-Mail...right?"
				},
				emailcheck: {
					minlength: "Your email must be greater than 5 characters",
					maxlength: "Your E-Mail is WAY too long.",
					required: "We need your E-Mail twice...sorry =("
				}
			}

			// setup an AJAX call to submit the form without reloading
			//submitHandler: function(form) {
			//	$(form).ajaxSubmit({
			//		// GET or POST
			//		type: "POST",
			//		// where to submit data
			//		url: "updateemail.php",
			//		// TL; DR: reformat POST data
			//		data: $(form).serialize(),
			//		// success is an event that happens when the server replies
			//		success: function(ajaxOutput) {
			//			// clear the output area's formatting
			//			$("#emailOutputArea").css("display", "");
			//			// write the server's reply to the output area
			//			$("#emailOutputArea").html(ajaxOutput);
			//
			//
			//			// reset the form if it was successful
			//			// this makes it easier to reuse the form again
			//			if($(".alert-success").length >= 1) {
			//				$(form)[0].reset();
			//			}
			//		}
			//	});
			//}
		});
		$("#passwordchange").validate({
		// setup the formatting for the errors
		errorClass: "alert alert-danger",
		errorLabelContainer: "#passwordChangeOutputArea",
		wrapper: "span",
		// rules define what is good/bad input
		rules: {
			// each rule starts with the inputs name (NOT id)
			newpassword: {
				minlength: 4,
				maxlength: 128,
				required: true
			},
			passwordcheck: {
				minlength: 4,
				maxlength: 128,
				required: true
			}
		},
		// error messages to display to the end user
		messages: {
			newpassword: {
				minlength: "Please make your password longer,",
				maxlength: "Your new password is WAY too long.",
				required: "You wanna change your password, or what?"
			},
			passwordcheck: {
				minlength: "Please make your password longer,",
				maxlength: "PASSWORD -- TOO -- LONG -- ERROR -- ERROR",
				required: "We went over this...enter it twice..."
			}
		}

		// setup an AJAX call to submit the form without reloading
		//submitHandler: function(form) {
		//	$(form).ajaxSubmit({
		//		// GET or POST
		//		type: "POST",
		//		// where to submit data
		//		url: "updatepassword.php",
		//		// TL; DR: reformat POST data
		//		data: $(form).serialize(),
		//		// success is an event that happens when the server replies
		//		success: function(ajaxOutput) {
		//			// clear the output area's formatting
		//			$("#passwordChangeOutputArea").css("display", "");
		//			// write the server's reply to the output area
		//			$("#passwordChangeOutputArea").html(ajaxOutput);
		//
		//
		//			// reset the form if it was successful
		//			// this makes it easier to reuse the form again
		//			if($(".alert-success").length >= 1) {
		//				$(form)[0].reset();
		//			}
		//		}
		//	});
		//}
	});
		$("#passwordchangeemail").validate({
		// setup the formatting for the errors
			errorClass: "alert alert-danger",
			errorLabelContainer: "#passwordOutputArea",
			wrapper: "span",
			// rules define what is good/bad input
			rules: {
				// each rule starts with the inputs name (NOT id)
				password: {
					minlength: 4,
					maxlength: 128,
					required: true
				}
			},
			// error messages to display to the end user
			messages: {
				password: {
					minlength: "Your password must be greater than 4 characters.",
					maxlength: "Your password is WAY too long.",
					required: "You DO have a password...right?"
				}
			},
			//setup an AJAX call to submit the form without reloading
			submitHandler: function(form) {
				$(form).ajaxSubmit({
					// GET or POST
					type: "POST",
					// where to submit data
					url: "passwordchangeemail.php",
					// TL; DR: reformat POST data
					data: $(form).serialize(),
					// success is an event that happens when the server replies
					success: function(ajaxOutput) {
						// clear the output area's formatting
						$("#passwordOutputArea").css("display", "");
						// write the server's reply to the output area
						$("#passwordOutputArea").html(ajaxOutput);
						// reset the form if it was successful
						// this makes it easier to reuse the form again
						if($(".alert-success").length >= 1) {
							$(form)[0].reset();
						}
					}
				});
			}});
		$("#emailchangeemail").validate({
			// setup the formatting for the errors
			errorClass: "alert alert-danger",
			errorLabelContainer: "#emailOutputArea",
			wrapper: "span",
			// rules define what is good/bad input
			rules: {
				// each rule starts with the inputs name (NOT id)
				password: {
					minlength: 4,
					maxlength: 128,
					required: true
				}
			},
			// error messages to display to the end user
			messages: {
				password: {
					minlength: "Your password must be greater than 4 characters.",
					maxlength: "Your password is WAY too long.",
					required: "You DO have a password...right?"
				}
			},
			//setup an AJAX call to submit the form without reloading
			submitHandler: function(form) {
				$(form).ajaxSubmit({
					// GET or POST
					type: "POST",
					// where to submit data
					url: "emailchangeemail.php",
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
	})
		// tell the validator to validate this form ID
		//$("#orderbyid").validate({
		//	// setup the formatting for the errors
		//	errorClass: "alert alert-danger",
		//	errorLabelContainer: "#orderOutputArea",
		//	wrapper: "span",
		//	// rules define what is good/bad input
		//	rules: {
		//		// each rule starts with the inputs name (NOT id)
		//		orderid: {
		//			min: 1,
		//			required: true
		//		}
		//	},
		//	// error messages to display to the end user
		//	messages: {
		//		orderid: {
		//			min: "Order number is 1 or higher.",
		//			required: "Please input your Order Id."
		//		}
		//	},
		//
		//	// setup an AJAX call to submit the form without reloading
		//	submitHandler: function(form) {
		//		$(form).ajaxSubmit({
		//			// GET or POST
		//			type: "POST",
		//			// where to submit data
		//			url: "getorderbyorderid.php",
		//			// TL; DR: reformat POST data
		//			data: $(form).serialize(),
		//			// success is an event that happens when the server replies
		//			success: function(ajaxOutput) {
		//				// clear the output area's formatting
		//				$("#orderOutputArea").css("display", "");
		//				// write the server's reply to the output area
		//				$("#orderOutputArea").html(ajaxOutput);
		//
		//
		//				// reset the form if it was successful
		//				// this makes it easier to reuse the form again
		//				if($(".alert-success").length >= 1) {
		//					$(form)[0].reset();
		//				}
		//			}
		//		});
		//	}
		//});


