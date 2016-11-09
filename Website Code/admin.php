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
				case 'page':	
					switch ($_POST[$key])
					{
						case 'RunSQL':
							include 'PHP/RunSQL.php';		
							break;	
						
					}
					
			}
			break;//only process first submitted variable
		}
		if ($defaultPage)
		{
			include 'PHP/Default.php';
		}
	}
?>