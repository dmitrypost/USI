// JavaScript Document

//shows the login div containing the login form
function showLogin()
{
	console.log('clicked');
	document.getElementById('loginDiv').style.visibility='visible'
	return false;	
}

//clears login information
function clearLogin()
{
	console.log('clearLogin function called');
	document.getElementById("loginForm").reset();
	return false;	
}

// This is a function constructor:
function replaceHtml(element,html) {
    document.getElementById(element).innerHTML = html;
}



//function returns either Login & Register Or Loggedin Users Name & Manage buttons
function getRegisterLoginUserLinks()
{
	console.log('called');
	serializedData = "" ;
	request = $.ajax({
		url: "GetLoginLinks.php",
		type: "post",
		data: serializedData
	});
	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		console.log('request done');
		
	});
	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error("The following error occurred: "+textStatus, errorThrown);
	});	
	return false;	
}