<?php
ini_set('display_errors', 1);
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
		$defaultPage = true;
		foreach ($_POST as $key => $val) 
		{
		  $defaultPage = false;
		  switch ($key)
			{
				case 's';
					include './PHP/Search.php';
					break;
				case 'logout':
					include './PHP/Logout.php';
					break;
				case 'login':
					include './PHP/Login.php';
					break;
				case 'register':
					include './PHP/Register.php';
					break;
				case 'registerForm':
					include './PHP/ProcessRegistration.php';
					break;
				case 'processProfileEdits':
					include './PHP/ProcessProfileEdits.php';
					break;
				case 'ProcessProjectChanges':
					echo "fdsaf";
					include './PHP/ProcessProjectChanges.php';
					break;
				case 'Page':
					switch ($_POST['Page'])
					{
						case 'EditProfile':
							include './PHP/EditProfile.php';
							break;
						case 'EditPassword':
							include './PHP/EditPassword.php';
							break;
						case 'Projects':
							include './PHP/Projects.php';
							break;
						case 'Project':
							include './PHP/Project.php';
							break;
						case 'EditProject':
							include './PHP/EditProject.php';
							break;
						case 'AddProject':
							include './PHP/AddProject.php';
							break;
						case 'Profile':
							include './PHP/Profile.php';
							break;
						case 'AdminPanel':
							include './PHP/AdminPanel.php';
							break;
						case 'College':
							include './PHP/College.php';
							break;
						case 'Major':
							include './PHP/Major.php';
							break;
						case 'UserManagement':
							include './PHP/UserManagement.php';
							break;
						case 'AlterHomePage':
							include './PHP/AlterHomePage.php';
							break;
						case 'RunSQL':
							include './PHP/RunSQL.php';
							break;
						case 'AlterCollegeMajor':
							include './PHP/AlterCollegeMajor.php';
							break;
						case 'ProjectApprovals':
							include './PHP/ProjectApprovals.php';
							break;
						case 'FileAction':
							$type = strip_tags($_POST['Type']);
							if ($type == 'Upload')
							{
								include './PHP/FileUpload.php';
							}
							elseif($type == 'Download')
							{
								include './PHP/FileDownload.php';	
							}
							else
							{
								echo "<p class='alert-box error'>Unpermitted Action!</p>$type";
									
							}
							break;
					}
					break; // case 'Page'
				case 'Action':
					switch ($_POST['Action'])
					{
						case 'SetPassword':
							include './PHP/UserManagement.php';
							break;
					}
					break; // case 'Action'

			}
			//break;//only process first submitted variable
		}
		if ($defaultPage)
		{
			echo "1";
			include './PHP/Default.php';
		}
	}
	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		include './PHP/FileDownload.php';
	}
?>
