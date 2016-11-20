<?php
//php to process the login
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    { 
		if (!empty($_POST['email']) && !empty($_POST['password']))
		{
			include_once 'Functions.php';
			$con = Open();
			$email = mysqli_real_escape_string($con,trim(strip_tags($_POST['email'])));
			$password = mysqli_real_escape_string($con,trim(strip_tags($_POST['password'])));
			
				$query = "SELECT usr_fname, usr_lname, usr_id, usr_password, usr_salt FROM tblUser WHERE usr_email = '$email'";
				if ($result = mysqli_query($con, $query))
				{
					if (mysqli_num_rows($result) > 0)
					{
						while($row = mysqli_fetch_assoc( $result)) 
						{
							$encryptedpassword = GetEncryptedPassword(GetHashedString($password),$row['usr_salt']);
							$encryptedpassword = mb_convert_encoding($encryptedpassword,"utf8");
							if ($encryptedpassword == $row['usr_password'])
							{
								// Set session variables
								session_start();
								setcookie('u_name', $row['usr_fname'], time() + (86400 * 30), "/");
								QuickQuery("INSERT INTO tblSession (ses_session,ses_usr_id,ses_date)VALUES('".session_id()."',".$row['usr_id'].",NOW())");
							}
						}	
					}
				}
			
			mysqli_close($con);
		}
		else
		{
			if (empty($_POST['email'])) { echo "email empty\n";};
			if (empty($_POST['password'])) { echo "password empty";};
		}	
	}
?>
