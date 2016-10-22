// JavaScript Document

// This is a function constructor:
function replaceHtml(element,html) {
	"use strict";
    document.getElementById(element).innerHTML = html;
}

/* exported ProcessRegistration */
function ProcessRegistration()
{
	"use strict"; //jshint unused:false
	var request;
	// setup some local variables
	var $form = $("#registerForm");
	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");
	// Serialize the data in the form
	var serializedData = $form.serialize();
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);
	// Fire off the request to /form.php
	request = $.ajax({
		url: "Body.php",
		type: "post",
		data: serializedData
	});
	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		//replaceHtml('BodyPanel',response);
		replaceHtml('BodyPanel',response);
	});
	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error("The following error occurred: "+	textStatus, errorThrown	);
	});

	// Reenables the inputs 
	request.always(function () {
		$inputs.prop("disabled", false);
	});
}