// JavaScript Document

//shows the login div containing the login form
/* exported showLogin */
function showLogin()
{
	"use strict";
	document.getElementById('loginDiv').style.visibility='visible';
	return false;	
}

//clears login information
/* exported clearLogin */
function clearLogin()
{
	"use strict";
	document.getElementById("loginForm").reset();
	return false;	
}

// This is a function constructor:
function replaceHtml(element,html) {
	"use strict";
    document.getElementById(element).innerHTML = html;
}



/* exported getRegisterLoginUserLinks */
function getRegisterLoginUserLinks()
{
	"use strict"; //jshint unused:false
    var request;
	var serializedData = "" ;
	request = $.ajax({
		url: "PHP/GetLoginLinks.php",
		type: "post",
		data: serializedData
	});
	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		var res = response.split("|");
		replaceHtml('login/user', res[0]);              //replaces the link with either the logged in user link or login link
		replaceHtml('register/projects', res[1]);       //replaces the link with either the projects link or register link
	});
	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error("The following error occurred: "+textStatus, errorThrown);
	});	
	return false;	
}

/* exported showProfile , textStatus */
function showProfile(uid)
{
	"use strict"; //jshint unused:false
    var request = $.ajax({url:"Body.php",type: "post", data: "uid=" + uid });
    request.done(function (response, textStatus, jqXHR) { 
		replaceHtml('BodyPanel', response);              //replaces the link with either the logged in user link or login link
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
    return false;
}

/* exported getBody */
function getBody()
{
	"use strict"; //jshint unused:false
    //window.location.search is only the ?= ... part
	var variables = window.location.search;
    var request = $.ajax({ url: "Body.php", type: "post", data: variables.substring(1) });
    request.done(function (response, textStatus, jqXHR) {
        replaceHtml('BodyPanel', response);              //replaces the link with either the logged in user link or login link
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
    return false;
}

/* exported editProfile */
function editProfile(euid)
{
	"use strict"; //jshint unused:false
    var request = $.ajax({url:"Body.php",type: "post", data: "euid=" + euid});
    request.done(function (response, textStatus, jqXHR) {
        replaceHtml('BodyPanel', response);              //replaces the link with either the logged in user link or login link
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
    return false;
}

/* exported editProject */
function editProject(epid)
{
	"use strict"; //jshint unused:false
	var data = "epid=" + epid;
	var request = $.ajax({url:"Body.php",type: "post", data: data });
    request.done(function (response, textStatus, jqXHR) {
        replaceHtml('BodyPanel', response);              //replaces the link with either the logged in user link or login link
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
	return false;	
}

// different than showProject by this link will be to show only the logged in user's projects with the links to edit added
/* exported showProjects */
function showProjects()
{
	"use strict"; //jshint unused:false
	var request = $.ajax({url:"Body.php",type: "post", data: "pjs=" });
    request.done(function (response, textStatus, jqXHR) {
        replaceHtml('BodyPanel', response);              //replaces the link with either the logged in user link or login link
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
	return false;		
}

/* exported showProject */
function showProject(pid)
{
	"use strict"; //jshint unused:false
	var request = $.ajax({url:"Body.php",type: "post", data: "pid=" + pid });
    request.done(function (response, textStatus, jqXHR) {
        replaceHtml('BodyPanel', response);              //replaces the link with either the logged in user link or login link
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
	return false;		
}

/* exported Logout */
function Logout()
{
	"use strict"; //jshint unused:false
	var request = $.ajax({url:"Body.php",type: "post", data: "logout" });
    request.done(function (response, textStatus, jqXHR) {
    	getRegisterLoginUserLinks();
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
	return false;		
}

/* exported showRegister */
function showRegister()
{
	"use strict"; //jshint unused:false
	var request = $.ajax({url:"Body.php",type: "post", data: "register" });
    request.done(function (response, textStatus, jqXHR) {
    	replaceHtml('BodyPanel',response);
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
	return false;		
}


/* exported showMajor */
function showMajor(mid)
{
	"use strict"; //jshint unused:false
	var request = $.ajax({url:"Body.php",type: "post", data: "mid=" + mid });
    request.done(function (response, textStatus, jqXHR) {
        replaceHtml('BodyPanel', response);              //replaces the link with either the logged in user link or login link
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
	return false;		
}

/* exported showCollege */
function showCollege(cid)
{
	"use strict"; //jshint unused:false
	var request = $.ajax({url:"Body.php",type: "post", data: "cid=" + cid });
    request.done(function (response, textStatus, jqXHR) {
        replaceHtml('BodyPanel', response);              //replaces the link with either the logged in user link or login link
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
	return false;		
}