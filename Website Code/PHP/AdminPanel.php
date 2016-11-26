<?php
	include_once 'Functions.php';
	PageTitle("Admin Panel");
	if (isAdmin())
	{
		
	}
	else
	{
		"<p class='alert-box error'>Access Denied!</p>";	
	}
?>