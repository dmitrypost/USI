<?php
/*
	
*/
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    { 
		$defaultPage = true;
		foreach ($_POST as $key => $val) {
		  //echo '<p>'.$key.'</p>';
		  $defaultPage = false;
		  switch ($key)
			{
				case 'euid':
					echo "edit profile";	
					include 'EditProfile.php';		
					break;	
				case 'uid':
					//echo "profile";
					include 'Profile.php';
					break;
				case 'epid':
					echo "edit project";
					include 'EditProject.php';
					break;
				case 'pid';
					echo "project";
					include 'Project.php';
					break;
				case 's';
					echo "search";
					include '../Search.php';
					break;
				case 'pjs':
					echo "user projects page";
					include 'Projects.php';
					break;	
				case 'logout':
					include 'Logout.php';
					break;		
			}
			
		}
		if ($defaultPage)
		{
			echo "default landing page";
		}
	}
?>