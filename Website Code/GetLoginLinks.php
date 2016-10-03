<?php
	if (($_SERVER['REQUEST_METHOD'] == 'POST') )
    { 
		if(!isset($_COOKIE['s'])) 
		{
    		echo "Cookie named '" . $cookie_name . "' is not set!";
		} else {
			echo "Cookie '" . $cookie_name . "' is set!<br>";
			echo "Value is: " . $_COOKIE[$cookie_name];
		}
		if (!empty($_POST['fname']))
		{
			$firstname = mysqli_real_escape_string($con,trim(strip_tags($_POST['fname'])));
			echo('<a href="javascript:void(0)" onClick="showProfile()">'.$firstname.'</a>');	
			echo('|');		
			echo('<a href="javascript:void(0)" onClick="showProjects()">Projects</a>');				
		}
		else
		{
			echo('<a href="javascript:void(0)" onClick="showLogin()">Login</a>');	
			echo('|');		
			echo('<a href="javascript:void(0)" onClick="showRegister()">Register</a>');					
		}
	}
?>