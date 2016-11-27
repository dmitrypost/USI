<?php
	echo "<p>";
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    { 
		$defaultPage = true;
		foreach ($_POST as $key => $val) {
		  echo '<p>'.$key.':'.$_POST[$key].'</p>';
		}
		
		foreach ($_POST as $key => $val) {
		  $defaultPage = false;
		  switch ($key)
			{
				case 'Page':
					switch ($_POST['Page'])
						{								
							case 'Projects':
								//include 'PHP/ProjectFilter.php';
								break;	
							case 'Project': //if the page is on project sidepanel shall show the participants
								include 'PHP/SidePanel/Participants.php';
								break;
							case 'Profile':
								//include 'PHP/Profile.php';
								break;
							case 'AdminPanel':
								include 'PHP/SidePanel/AdminLinks.php';
								break;
						}
					break;
				case 'value';
					include 'PHP/SidePanel/Default.php';
					//only happens upon college select change
					break;
			}
			break;
		}
		if ($defaultPage)
		{
			
			include "PHP/SidePanel/Default.php";
		}
	}
	
?>