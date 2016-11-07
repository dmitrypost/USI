<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    { 
		$defaultPage = true;
		foreach ($_POST as $key => $val) {
		  //echo '<p>'.$key.'</p>';
		  $defaultPage = false;
		  switch ($key)
			{

				case 'pid';
					echo "project";
					include 'PHP/SidePanel/Project.php';
					break;

			}
			
		}
		if ($defaultPage)
		{
			include "PHP/SidePanel/Deafault.php";
		}
	}
?>