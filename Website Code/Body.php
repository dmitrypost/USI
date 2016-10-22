<?php
/*
	Body.php
	this php file prevents revealing the existance of addtional php files
	
	if the Index.html page recieves a uid=1 in the url then this page will pull the info and return a user's profile
	uid: profile content to return		example: localhost/?uid=1
	pid: project content to return		example: localhost/?pid=1
	eid: projects content to return		example: localhost/?eid=1
		if eid = 0 then show all projects
	s:   user's search string			example: localhost/?s='USI Project Repository'
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
					echo "edit profile";	
					include 'PHP/EditProfile.php';		
					break;	
				case 'uid':
					//echo "profile";
					include 'PHP/Profile.php';
					break;
				case 'epid':
					echo "edit project";
					include 'PHP/EditProject.php';
					break;
				case 'pid';
					echo "project";
					include 'PHP/Project.php';
					break;
				case 's';
					echo "search";
					include 'Search.php';
					break;
				case 'pjs':
					echo "user projects page";
					include 'PHP/Projects.php';
					break;	
				case 'logout':
					include 'PHP/Logout.php';
					break;		
				case 'register':
					include 'PHP/Register.php';
					break;		
				case 'registerForm':
					include 'PHP/ProcessRegistration.php';
					break;
			}
			break;//only process first submitted variable
		}
		if ($defaultPage)
		{
			echo "default landing page";
		}
	}
?>