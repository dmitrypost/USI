<?php
	include_once 'Functions.php';
	PageTitle("Admin Panel");
	if (isAdmin())
	{
		echo "<p> There is ".GetNumberOfPendingProjectApprovals()." projects pending approval";
	}
	else
	{
		"<p class='alert-box error'>Access Denied!</p>";	
	}
?>