// JavaScript Document

// This is a function constructor:
function replaceHtml(element,html) {
	"use strict";
    document.getElementById(element).innerHTML = html;
}



/* exported goToPage */
function goToPage(page)
{
	"use strict"; //jshint unused:false
    var request;
	request = $.ajax({
		url: "admin.php",
		type: "post",
		data: "page="+ page
	});
	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		replaceHtml('BodyPanel', response);              
	});
	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error("The following error occurred: "+textStatus, errorThrown);
	});	
	return false;	
}