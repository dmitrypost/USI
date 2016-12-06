<?php
include_once 'Functions.php';
//check to see if session exists else created session won't be in the session table and will deny access to actions requiring logged in user
if (isLoggedIn())
{
	QuickQuery("UPDATE tblsession SET ses_expired = true WHERE ses_session ='".session_id()."'");
	echo "session now expired";
	session_id("");
	// remove all session variables
	session_unset(); 

	// destroy the session 
	session_destroy();
	setcookie("PHPSESSID", "");
	session_write_close();
	
}
else
{
echo "not logged in";	
}
?>