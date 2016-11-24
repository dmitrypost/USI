// JavaScript Document

//shows the login div containing the login form
/* exported showLogin */
function showLogin()
{
	"use strict";
	document.getElementById('loginDiv').style.visibility='visible';
	return false;	
}

//shows the login div containing the login form
/* exported HideLogin */
function HideLogin()
{
	"use strict";
	document.getElementById('loginDiv').style.visibility='hidden';
	return false;	
}

//variable for holding current page
var uri = "/";

function UpdateAddressBar(urlPath)
{
	"use strict";
	uri = urlPath;
	window.history.pushState({"html":"","pageTitle":""},"", urlPath);		
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
		getSidePanel();
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
		UpdateAddressBar("/euid="+euid);
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
		UpdateAddressBar("/?pjs");
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
		SPProject(pid);
		UpdateAddressBar("/?pid="+pid);
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
	return false;		
}

/* exported SPProject */
function SPProject(pid)
{
	"use strict"; //jshint unused:false
	var request = $.ajax({url:"SidePanel.php",type: "post", data: "pid=" + pid });
    request.done(function (response, textStatus, jqXHR) {
        replaceHtml('SidePanel', response);              //replaces the link with either the logged in user link or login link
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
		UpdateAddressBar("/?register");
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
		UpdateAddressBar("/?mid="+mid);
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
		UpdateAddressBar("/?cid="+cid);
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
	return false;		
}




/* exported ProcessRegistration */
function ProcessRegistration()
{
	"use strict"; //jshint unused:false
	var request;
	var data = "registerForm&firstname=" + $('#firstname').val() + "&lastname=" + $('#lastname').val() + "&email=" + $('#email').val() + "&password=" + $('#password').val() + "&college=" + $("#slt_college option:selected").text() + "&major=" + $('#slt_major option:selected').text();
	
	request = $.ajax({
		url: "Body.php",
		type: "post",
		data: data
	});
	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		//replaceHtml('BodyPanel',response);
		replaceHtml('BodyPanel',response);
		UpdateAddressBar("/?registerForm=");
	});
	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error("The following error occurred: "+	textStatus, errorThrown	);
	});
}

/* exported ProcessProfileChanges */
function ProcessProfileChanges()
{
	"use strict"; //jshint unused:false
	var request;
	var data = "processProfileEdits&firstname=" + $('#txt_firstName').val() + "&lastname=" + $('#txt_lastName').val() + "&email=" + $('#txt_email').val()  + "&major=" + $('#slt_major option:selected').text() + "&gradstatus=" + $('#rdo_graduate input:radio:checked').val() + "&phone=" + $('txt_phone').val() + "&linkedin=" + $('txt_linkedin').val() + "&userid=" + $('#hdn_userid').val();
	
	request = $.ajax({
		url: "Body.php",
		type: "post",
		data: data
	});
	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		//replaceHtml('BodyPanel',response);
		replaceHtml('BodyPanel',response);
		UpdateAddressBar("/?processProfileEdits");
	});
	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error("The following error occurred: "+	textStatus, errorThrown	);
	});
}

/* exported ProcessProjectChanges */
function ProcessProjectChanges()
{
	"use strict"; //jshint unused:false
	var request;
	var data = "ProcessProjectChanges&firstname=" + $('#txt_firstName').val() + "&lastname=" + $('#txt_lastName').val() + "&email=" + $('#txt_email').val()  + "&major=" + $('#slt_major option:selected').text() + "&gradstatus=" + $('#rdo_graduate input:radio:checked').val() + "&phone=" + $('txt_phone').val() + "&linkedin=" + $('txt_linkedin').val() + "&userid=" + $('#hdn_userid').val();
	
	request = $.ajax({
		url: "Body.php",
		type: "post",
		data: data
	});
	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		//replaceHtml('BodyPanel',response);
		replaceHtml('BodyPanel',response);
		UpdateAddressBar("/?ProcessProjectChanges&value=");
	});
	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error("The following error occurred: "+	textStatus, errorThrown	);
	});
}

/* exported AjaxProfileChange */
function AjaxProfileChange(control,action,optional)
{
	"use strict"; //jshint unused:false	
	
    var data = "Page=EditProfile&Action=" + action + "&Value=" + GetControlValue(control) + "&Optional=" + optional;
	var request = $.ajax({
		url: "Body.php",
		type: "post",
		data: data
	});
	request.done(function (response, textStatus, jqXHR) {
		var res = response.split("|");
		$(res[0]).append(res[1]);
		//$(control).append(" <b class='Status'>&#10004;</b>");
        $(".Status").fadeOut(1000,function() { $(".Status").remove(); });
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error("The following error occurred: "+	textStatus, errorThrown	);
	});
}

/* exported GoToPage */
function GoToPage(page)
{
	"use strict"; //jshint unused:false	
	var request = $.ajax({
		url: "Body.php",
		type: "post",
		data: "Page="+page
	});
	request.done(function (response, textStatus, jqXHR) {
		replaceHtml('BodyPanel',response);
		UpdateAddressBar("/?Page="+page);
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error("The following error occurred: "+	textStatus, errorThrown	);
	});
}

/* exported GoToPage */
function GoToPage(page,action,value,optional)
{
	"use strict"; //jshint unused:false	
	var request = $.ajax({
		url: "Body.php",
		type: "post",
		data: "Page="+page+"&Action="+action+"&value="+value+"&optional="+optional
	});
	request.done(function (response, textStatus, jqXHR) {
		replaceHtml('BodyPanel',response);
		UpdateAddressBar("/?Page="+page+"&Action="+action);
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error("The following error occurred: "+	textStatus, errorThrown	);
	});
}

function GetControlValue(control)
{
	"use strict"; //jshint unused:false
	if(control !== null)
    { 
		switch (control.type)
		{
			case 'text':	
				return control.value;
			case 'select':
				return control.value;
				
		}
		return "";
	}
}

var $options = null;

/* exported RegistrationFormLoaded */
function RegistrationFormLoaded()
{
	"use strict"; //jshint unused:false
	var $select1 = $( '#slt_college' ),
		$select2 = $( '#slt_major' );
	if ($options === null) {
    	$options = $select2.find( 'option' );
	}
    
	$select1.on( 'change', function() {
		$select2.html( $options.filter( '[value="' + this.value + '"]' ) );
	} ).trigger('change');
}

/* exported ProfileEditLoaded */
function ProfileEditLoaded()
{
	"use strict"; //jshint unused:false
	$( "#accordion" ).accordion();
}

/* exported EditProjectLoaded */
function EditProjectLoaded()
{
	"use strict"; //jshint unused:false
	$( "#accordion" ).accordion();
}

/* exported onEnter */
function onEnter(event,control,action,optional)
{
	"use strict"; //jshint unused:false
	if (event.keyCode === 13) {
		AjaxProfileChange(control,action,optional);
	}
}

/* exported getSidePanel */
function getSidePanel()
{
	"use strict"; //jshint unused:false
    //window.location.search is only the ?= ... part
	var variables = window.location.search;
    var request = $.ajax({ url: "SidePanel.php", type: "post", data: variables.substring(1) });
    request.done(function (response, textStatus, jqXHR) {
        replaceHtml('SidePanel', response);              //replaces the link with either the logged in user link or login link
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
    return false;
}

/* exported UpdateSPMajorList */
function UpdateSPMajorList(cid)
{
	"use strict"; //jshint unused:false
	var request = $.ajax({url:"SidePanel.php",type: "post", data: "cid=" + cid });
    request.done(function (response, textStatus, jqXHR) {
        replaceHtml('SidePanel', response);              //replaces the link with either the logged in user link or login link
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
	return false;	
}

/* exported SubmitPasswordChanges */
function SubmitPasswordChanges()
{
	"use strict"; //jshint unused:false
	var request = $.ajax({url:"Body.php",type: "post", data: "Page=EditPassword&oldpassword=" + $("#pass_current").val() + "&newpassword=" + $("#pass_new").val() + "&repeatedpassword=" + $("#pass_confirm").val() });
    request.done(function (response, textStatus, jqXHR) {
        replaceHtml('BodyPanel', response);              //replaces the link with either the logged in user link or login link
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
	return false;	
}
