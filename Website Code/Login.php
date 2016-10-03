<!--script to process the login -->
<?php
	function CreateSessionID($email,$firstname)
	{
		include 'Database.php';
		$query = "INSERT ";
		
		session_start();
		//session salt cookie
		
		return 'Dmitry';
		
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    { // Handle the form.
		include 'Database.php';
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
			$query = "SELECT usr_fname, usr_lname, usr_id FROM tblUser WHERE usr_email = '".$email."' AND usr_password = '".$password."'";
			//Execute query
			if ($result = mysqli_query($con, $query))
			{
				//login successful
				while ($row = mysqli_fetch_assoc($result)) 
				{
					//echo $row['usr_fname'] . " " . $row['usr_lname'] ;
					//start creating session cookie so webpage can read cookie to determine if user is logged in or not
					
					// Set session variables
					session_start();
					setcookie('u_name', $row['usr_fname'], time() + (86400 * 30), "/");
					$query = "INSERT INTO tblSession (ses_session,ses_usr_id,ses_date)SET(".session_id().",".$row['usr_id'].",NOW())";
					if ($result = mysqli_query($con, $query2))
					{
					}				
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
