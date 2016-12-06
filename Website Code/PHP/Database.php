<?php
	function Open()
	{
		//connect to database
		if ($_SERVER['HTTP_HOST'] == "collabra.usi.edu")
		{
			$con = mysqli_connect("localhost", "eproject", "dana123", "usiprojectrepository");
			if (!$con)
			{
				die ("connection error: " . mysqli_connect_error());
			}
			return $con;
		}
		else
		{	//for testing 
			$host = gethostbyname ('mysqlsvr.ddns.net');
			$con = mysqli_connect($host, 'user', 'password', 'usiprojectrepository','3301');
			if (!$con)
			{
				die ("connection error: " . mysqli_connect_error());
			}
			return $con;
		}
	}
	
	//quick query is meant for inserts and updates NOT for selects
	function QuickQuery($query)
	{
		$con = Open();
		if (mysqli_query($con, $query)) {
			mysqli_close($con);
			return TRUE;
		} else {
			//echo "Error running query: " . mysqli_error($con);
			mysqli_close($con);
			return FALSE;
		}
	}
	

?>
