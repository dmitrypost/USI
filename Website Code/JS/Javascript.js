// JavaScript Document

/* exported ToggleVisibility */
function ToggleVisibility(element)
{	"use strict"; //jshint unused:false
	if (document.getElementById(element) === null)
	{
		$(element).toggle();
	}
	else
	{
    	var div = document.getElementById(element);
		div.style.display = div.style.display === "none" ? "block" : "none";
	}
}

window.addEventListener('popstate', function(event) {
    // The popstate event is fired each time when the current history entry changes.
	"use strict"; //jshint unused:false
    //console.log("TEST");
	//console.log("uri"+uri+"|search"+window.location.search+"|hash"+window.location.hash);
    if (uri !== window.location.search)
	{
		getBody(); //tells the page to reload
	}
}, false);

//dropdown menu's
/* exported ToggleDropdown */
function ToggleDropdown(dropdown){
	"use strict";
	//$('li.has-dropdown').addClass('hover');
	if (hasClass(dropdown,'hover'))
	{
		$(dropdown).removeClass('hover');
	}
	else
	{
		$(dropdown).addClass('hover');
	}
}

function hasClass(element, cls) {
	"use strict";
    return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
}

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
	//window.location.hash = urlPath;
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
	if (document.getElementById(element) === null)
	{
		$(element).html(html);
	}
	else
	{
    	document.getElementById(element).innerHTML = html;
	}
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
	var data = "processProfileEdits&firstname=" + $('#txt_firstName').val() + "&lastname=" + $('#txt_lastName').val() + "&email=" + $('#txt_email').val()  + "&major=" + $('#slt_major option:selected').text() + "&gradstatus=" + $('input[name=academicstatus]:checked').val() + "&phone=" + $('#txt_phone').val() + "&linkedin=" + $('#txt_linkedin').val() + "&userid=" + $('#hdn_userid').val();

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
    var data = "ProcessProjectChanges&projectid=" + $("#hdn_ProjectId").val() + "&title=" + $('#txt_title').val() + "&year=" + $('#txt_year').val() + "&major=" + $('#slt_major option:selected').text()  + "&description=" + $("#txt_description").val() + "&body=" + $('#txt_body').val() + "&AddedParticipants=" + getParticipantAdditions();

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
function GoToPage(page,action,value,optional)
{
	"use strict"; //jshint unused:false
	var data = "";
	if ((page !== null) && (page !== "") && (page !== undefined)) {data = data + "Page="+page; }
    if ((action !== null) && (action !== "") && (action !== undefined)) {data = data + "&Action="+action; }
    if ((value !== null) && (value !== "") && (value !== undefined)) {data = data + "&value="+value; }
    if ((optional !== null) && (optional !== "") && (optional !== undefined)) {data = data + "&optional="+optional; }
	//var data = "Page="+page+"&Action="+action+"&value="+value+"&optional="+optional;
	var request = $.ajax({
		url: "Body.php",
		type: "post",
		data: data
	});
	SidePanelPage(data);
	request.done(function (response, textStatus, jqXHR) {
		replaceHtml('BodyPanel',response);
		UpdateAddressBar("/?"+data);
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error("The following error occurred: "+	textStatus, errorThrown	);
	});
}

/* exported SidePanelPage */
function SidePanelPage(data)
{
	"use strict"; //jshint unused:false
	var request = $.ajax({
		url: "SidePanel.php",
		type: "post",
		data: data
	});
	request.done(function (response, textStatus, jqXHR) {
		replaceHtml('SidePanel',response);
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
	FileAction($('#div_profilepictureform'),'','Upload','Profile','ProfilePictureChange',$("#hdn_userid").val(),''); //tells the div_projectpictureform to change into project picture change form
}

/* exported EditProjectLoaded */
function EditProjectLoaded()
{
	"use strict"; //jshint unused:false
	$( "#accordion" ).accordion();
	FileAction($('#div_projectpictureform'),'','Upload','Project','ProjectPictureChange',$("#hdn_ProjectId").val(),''); //tells the div_projectpictureform to change into project picture change form
	FileAction($('#div_fileform'),'','Upload','Project','UploadForm',$("#hdn_ProjectId").val(),''); //tells the div_fileform to to change into fileupload form
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
function UpdateSPMajorList(collgeid)
{
	"use strict"; //jshint unused:false
	var request = $.ajax({url:"SidePanel.php",type: "post", data: "value=" + collgeid });
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

/* exported FileDownload */
function FileDownload(fileid)
{
	"use strict"; //jshint unused:false
	var request = $.ajax({url:"Body.php",type: "post", data: "FileDownload="+fileid});
	request.done(function (response,textStatus,jqXHR) {
		console.log(response);
	});
	request.fail(function (jqXHR, textStatus, errorThrown) {
		console.error("There was an error downloading the file: " + textStatus, errorThrown);
	});
	return false;
}

/* exported addParticipantRow */
function addParticipantRow()
{	"use strict";
	var s = document.getElementById("participant").innerHTML; // HTML string
	var div = document.createElement('div');
	div.innerHTML = s;
	document.getElementById("hdn_AddingParticipantCount").value = parseInt(document.getElementById("hdn_AddingParticipantCount").value) + 1;
	div.id = document.getElementById("hdn_AddingParticipantCount").value;
	document.getElementById("participants").appendChild(div);
}

/* exported getParticipantAdditions */
function getParticipantAdditions()
{	"use strict";
    var Participants = "";
    for (var i = 1; i <= parseInt(document.getElementById("hdn_AddingParticipantCount").value); i++) {
        var fname = $("#participants #" + i + " input.participant-fname").val();
        var lname = $("#participants #" + i + " input.participant-lname").val();
        var email = $("#participants #" + i + " input.participant-email").val();
        var role = $("#participants #" + i + " input.participant-role").val();
        Participants = Participants + '["' + fname + '","' + lname + '","' + email + '","' + role + '",' + $("#hdn_ProjectId").val() +']';
    }
    return Participants;
}

/* exported ProcessProjectAddition */
function ProcessProjectAddition()
{
    "use strict"; //jshint unused:false
    var request;
    var data = "Page=AddProject&title=" + $('#txt_title').val() + "&year=" + $('#txt_year').val() + "&major=" + $('#slt_major option:selected').text() + "&description=" + $("#txt_description").val() + "&body=" + $('#txt_body').val() + "&AddedParticipants=" + getParticipantAdditions();

    request = $.ajax({
        url: "Body.php",
        type: "post",
        data: data
    });
    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR) {
        //replaceHtml('BodyPanel',response);
        replaceHtml('BodyPanel', response);
        UpdateAddressBar("/?Page=AddProject");
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
}

//this function handles all actions for file operations
/* exported FileAction */
function FileAction(divelem,fileelem,type,page,action,value,optional)
{
	"use strict"; //jshint unused:false
	var formData = new FormData();
	formData.append("Page","FileAction");
	formData.append("Type",type);
	if (fileelem === null ) { return; } //make sure this is passed
		if ((page !== null) && (page !== "") && (page !== undefined)) {formData.append("UponPage",page); }
		if ((action !== null) && (action !== "") && (action !== undefined)) {formData.append("Action",action); }
		if ((value !== null) && (value !== "") && (value !== undefined)) {formData.append("value",value); }
		if ((optional !== null) && (optional !== "") && (optional !== undefined)) {formData.append("optional",optional); }
	var next = false;
	var input = document.getElementById(fileelem);
    if (!input) {
      console.log("Um, couldn't find the fileinput element.");
	  next = true;
    }
    else if (!input.files) {
      console.log("This browser doesn't seem to support the `files` property of file inputs.");
    }
    else if (!input.files[0]) {
      console.log("Please select a file before clicking 'Load'");               
    }
    else {
      	var file = input.files[0];
		formData.append("fle_filename",input.files[0].name);
      	var fr = new FileReader();
      	fr.onload = function (event){
			var content = fr.result;
			var blob = new Blob([content], { type: "text/xml"});
			formData.append("fle_userfile", blob);
			
			var request = new XMLHttpRequest();
			request.open("POST", "Body.php");
			request.send(formData);
			request.onreadystatechange = function() {
				if (request.readyState === XMLHttpRequest.DONE) {
					if (request.status === 200) {
						replaceHtml(divelem,request.responseText);
					}
				}
				};
			};
      	fr.readAsDataURL(file);
		fr.loadend = function (event){
			
		};
	}
	if (next)
	{
		var request = new XMLHttpRequest();
		request.open("POST", "Body.php");
		request.send(formData);
		request.onreadystatechange = function() {
			if (request.readyState === XMLHttpRequest.DONE) {
				if (request.status === 200) {
					replaceHtml(divelem,request.responseText);
				}
			}
		};
	}
}

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
/* exported SelectDropdown */
function SelectDropdown()
{	"use strict";
	ToggleList();
	replaceHtml("slt_SelectedUser","");
}
/* exported TableItemSelected */
function TableItemSelected(id,elem)
{	"use strict";
	replaceHtml("slt_SelectedUser","<option value='item' selected>"+$(elem).find("td:first").text()+" "+$(elem).find("td:nth-child(2)").text()+"</select>");
	$("#hdn_SelectedUserId").val(id);
	//console.log($(elem).find("td:first").text()+" "+$(elem).find("td:nth-child(2)").text());
	ToggleList();
}
function ToggleList()
{	"use strict";
	$('.itemconfiguration').toggle();
}
/* exported SetPassword */
function SetPassword()
{	"use strict";//jshint unused:false
	var id = $("#hdn_SelectedUserId").val();
	var pass = $("#pwd_newpassword").val();
	var request = $.ajax({url:"Body.php",type: "post", data: "Action=SetPassword&Id="+id+"&Pass="+pass});
	request.done(function (response,textStatus,jqXHR) {
		//console.log(response);
		replaceHtml('status',response);
	});
	request.fail(function (jqXHR, textStatus, errorThrown) {
		console.error("There was an error downloading the file: " + textStatus, errorThrown);
	});
	return false;
}
