<?php
	//connect to database
	$host = gethostbyname ('mysqlsvr.ddns.net');
	$con = mysqli_connect($host, 'user', 'password', 'usiprojectrepository','3301');
	if (!$con)
	{
		die ("connection error: " . mysqli_connect_error());
	}
?>
