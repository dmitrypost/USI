<?php
	echo "<p>";
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    { 
		$defaultPage = true;
		foreach ($_POST as $key => $val) {
		  echo '<p>'.$key.':'.$_POST[$key].'</p>';
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
						}
					break;
				case 'cid';
					include 'PHP/SidePanel/Default.php';
					//only happens upon college select change
					break;
			}
			
		}
		if ($defaultPage)
		{
			
			include "PHP/SidePanel/Default.php";
		}
	}
	
?>