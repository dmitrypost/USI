<!--script to process the login -->
<?php
	function CreateSessionID(string $email,string $firstname)
	{
		//session salt cookie
		
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    { // Handle the form.

		//connect to database
		$host = gethostbyname ('mysqlsvr.ddns.net');
		$con = mysqli_connect($host, 'user', 'password', 'usiprojectrepository','3301');
		
		if (!$con)
		{
			die ("connection error: " . mysqli_connect_error());
		}
		//login attempt
		$error = FALSE;
		if (!empty($_POST['email']) && !empty($_POST['password']))
		{
			$email = mysqli_real_escape_string($con,trim(strip_tags($_POST['email'])));
			$password = mysqli_real_escape_string($con,trim(strip_tags($_POST['password'])));
		}
		else
		{
			echo("please try again");
			$error = TRUE;
		}
		if (!$error)
		{
			//Define query
			$query = "SELECT usr_fname, usr_lname FROM tblUser WHERE usr_email = '".$email."' AND usr_password = '".$password."'";
			//Execute query
			if ($result = mysqli_query($con, $query))
			{
				//login successful
				while ($row = mysqli_fetch_assoc($result)) 
				{
					//echo $row['usr_fname'] . " " . $row['usr_lname'] ;
					//start creating session cookie so webpage can read cookie to determine if user is logged in or not
					session_start();
					// Set session variables
					$_SESSION["sid"] = CreateSessionID($email,$row['usr_fname']);
					
				}
				
				
			}
			else
			{
				//login failed
			}

		}
		mysqli_close($con);
	}
	else
	{
	}
?>
