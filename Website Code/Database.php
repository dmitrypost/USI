<?php
	//connect to database
	$host = gethostbyname ('mysqlsvr.ddns.net');
	$con = mysqli_connect($host, 'user', 'password', 'usiprojectrepository','3301');
	if (!$con)
	{
		die ("connection error: " . mysqli_connect_error());
	}
	
	//quick query is meant for inserts and updates NOT for selects
	function QuickQuery($query)
	{
		$host = gethostbyname ('mysqlsvr.ddns.net');
		$con = mysqli_connect($host, 'user', 'password', 'usiprojectrepository','3301');
		if (mysqli_query($con, $query)) {
			echo "";
		} else {
			echo "Error running query: " . mysqli_error($con);
		}
		mysqli_close($con);
	}
?>
