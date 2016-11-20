// JavaScript Document

//clears out the text "search" from the search box on first focus
$('#ComboSearch').focus(function () { "use strict"; //jshint unused:false
$(this).val(""); });

$('#eml_email').focus(function () { "use strict"; //jshint unused:false
$(this).val(""); });

//Sending login info for processing

	// Variable to hold request
var request;
	// Bind to the submit event of our form
$("#loginForm").submit(function(event)
{
	"use strict"; //jshint unused:false
		// Prevent default posting of form - put here to work in case of errors
		event.preventDefault();
		// Abort any pending request
		if (request) {
			request.abort();
		}
		// setup some local variables
		var $form = $(this);
		// Let's select and cache all the fields
		var $inputs = $form.find("input, select, button, textarea");
		// Serialize the data in the form
		var serializedData = $form.serialize();
		// Let's disable the inputs for the duration of the Ajax request.
		// Note: we disable elements AFTER the form data has been serialized.
		// Disabled form elements will not be serialized.
		$inputs.prop("disabled", true);
		// Fire off the request to /form.php
		request = $.ajax({
			url: "php/login.php",
			type: "post",
			data: serializedData
		});
		// Callback handler that will be called on success
		request.done(function (response, textStatus, jqXHR){
			// Log a message to the console
			/* exported clearLogin */
			console.log(response);
			clearLogin.call();
			getRegisterLoginUserLinks.call();
		});
		// Callback handler that will be called on failure
		request.fail(function (jqXHR, textStatus, errorThrown){
			// Log the error to the console
			console.error(
				"The following error occurred: "+
				textStatus, errorThrown
			);
		});
		// Callback handler that will be called regardless
		// if the request failed or succeeded
		request.always(function () {
			// Reenable the inputs
			$inputs.prop("disabled", false);
		});
		document.getElementById('loginDiv').style.visibility='hidden';
});

// 	calls the function to change the links html
getRegisterLoginUserLinks.call();

//  calls the function to change the body panel to the body of either url based if search parameters included or to default page
getBody.call();
