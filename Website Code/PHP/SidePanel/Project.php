<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    { 
		
		foreach ($_POST as $key => $val) {
		 	echo '<p>'.$key.'</p>';
		  
			
		}
		
	}
?>