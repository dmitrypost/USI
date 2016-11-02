<?php
/*
	php which uses the first posted key as a determinant on what page to retrieve
	
	add to history upon ajax change of page
	http://stackoverflow.com/questions/824349/modify-the-url-without-reloading-the-page
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
					//echo "edit profile";	
					include 'PHP/EditProfile.php';		
					break;	
				case 'uid':
					//echo "profile";
					include 'PHP/Profile.php';
					break;
				case 'epid':
					//echo "edit project";
					include 'PHP/EditProject.php';
					break;
				case 'pid';
					//echo "project";
					include 'PHP/Project.php';
					break;
				case 's';
					//echo "search";
					include 'PHP/Search.php';
					break;
				case 'pjs':
					//echo "user projects page";
					include 'PHP/Projects.php';
					break;	
				case 'logout':
					include 'PHP/Logout.php';
					break;
				case 'login':
					include 'PHP/Login.php';
					break;
				case 'register':
					include 'PHP/Register.php';
					break;		
				case 'registerForm':
					include 'PHP/ProcessRegistration.php';
					break;
				case 'cid':
					include 'PHP/College.php';
					break;
				case 'mid':
					include 'PHP/Major.php';
					break;
				case 'GetMajorsByCollege':
					include 'PHP/Functions.php';
					echo $_POST['GetMajorsByCollege'];
					echo strip_tags($_POST['GetMajorsByCollege']);
					echo trim(strip_tags($_POST['GetMajorsByCollege']));
					echo GetMajorsByCollege(strip_tags($_POST['GetMajorsByCollege']));
					echo "\n";
					echo StringArrayToHTMLSelectOptions(GetMajorsByCollege(trim(strip_tags($_POST['GetMajorsByCollege']))));
					break;
			}
			break;//only process first submitted variable
		}
		if ($defaultPage)
		{
			include 'PHP/Default.php';
		}
	}
?>