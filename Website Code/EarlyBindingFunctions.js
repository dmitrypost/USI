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
    var request;
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
		var res = response.split("|");
		console.log(res[0]);
		console.log(res[1]);
		replaceHtml('login/user', res[0]);              //replaces the link with either the logged in user link or login link
		replaceHtml('register/projects', res[1]);       //replaces the link with either the projects link or register link
	});
	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		console.error("The following error occurred: "+textStatus, errorThrown);
	});	
	return false;	
}

//function that adds to browsing history 
function AddToHistory(newUrl)
{
    //not implamented
    return false;
}


//function makes a call to php to get the logged in user's profile
function showProfile(uid)
{
    var request = $.ajax({url:"Body.php",type: "post", data: "uid=" + uid })
    request.done(function (response, textStatus, jqXHR) {
        console.log('request done');
        replaceHtml('BodyPanel', response);              //replaces the link with either the logged in user link or login link
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
    return false;
}

//function that calls php body to get relative information based on url
function getBody()
{
    //window.location.search is only the ?= ... part
    var request = $.ajax({ rl: "Body.php", type: "post", data: window.location.search })
    request.done(function (response, textStatus, jqXHR) {
        console.log('request done');
        replaceHtml('BodyPanel', response);              //replaces the link with either the logged in user link or login link
    });
    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error("The following error occurred: " + textStatus, errorThrown);
    });
    return false;
}


