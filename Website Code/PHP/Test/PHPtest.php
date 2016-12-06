<h1>PHP TEST PAGE</h1>
<hr>
<?php
	ini_set('display_errors', 1);
	print_r($_SERVER);
	echo "<hr>";
	include_once "./../Functions.php";
	session_start(); //required to get session_id 
		if (is_session_started())
		{
			echo "<br>session started".session_id();
		}
		else 
		{
			echo "<br>session failed to start"; 	
		}
	
?>