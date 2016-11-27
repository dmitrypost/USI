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
				case 's';
					//echo "search";
					include 'PHP/Search.php';
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
				case 'processProfileEdits':
					include 'PHP/ProcessProfileEdits.php';
					break;
				case 'ProcessProjectChanges':
					include 'PHP/ProcessProjectChanges.php';
					break;
				case 'FileDownload':
					include 'PHP/FileDownload.php';
					break;
				case 'Page':
					switch ($_POST['Page'])
					{
						case 'EditProfile':
							include 'PHP/EditProfile.php';
							break;								
						case 'EditPassword':
							include 'PHP/EditPassword.php';
							break;
						case 'Projects':
							include 'PHP/Projects.php';
							break;	
						case 'Project':
							include 'PHP/Project.php';
							break;
						case 'EditProject':
							include 'PHP/EditProject.php';
							break;
						case 'Profile':
							include 'PHP/Profile.php';
							break;
						case 'AdminPanel':
							include 'PHP/AdminPanel.php';
							break;
						case 'College':
							include 'PHP/College.php';
							break;
						case 'Major':
							include 'PHP/Major.php';
							break;
						case 'PasswordManagement':
							include 'PHP/PasswordManagement.php';
							break;
					}
					break; // case 'Page'
					case 'Action':
						switch ($_POST['Action'])
						{
							case 'SetPassword':
								include 'PHP/PasswordManagement.php';
								break;	
						}
						break; // case 'Action'

			}
			break;//only process first submitted variable
		}
		if ($defaultPage)
		{
			include 'PHP/Default.php';
		}
	}
?>