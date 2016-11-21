<!--post registration posting-->
<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		//display the data retrieved
		/*	echo "data recieved";
		foreach ($_POST as $key => $val) {
		  echo '<br>'.$key.':'.$_POST[$key];
		}	*/
		
		include_once 'Functions.php';
		$con = open();
		if (isset($_POST['firstname']) AND isset($_POST['lastname']) AND isset($_POST['email']) AND isset($_POST['password']) AND isset($_POST['college']) AND isset($_POST['major'])) 
		{ 
			//get the values out of the submitted data safely
			$fname = mysqli_real_escape_string($con,trim(strip_tags($_POST['firstname']))); 
			$lname = mysqli_real_escape_string($con,trim(strip_tags($_POST['lastname']))); 
			$email = mysqli_real_escape_string($con,trim(strip_tags($_POST['email']))); 
			$passw = mysqli_real_escape_string($con,trim(strip_tags($_POST['password']))); 
			$colle = mysqli_real_escape_string($con,trim(strip_tags($_POST['college']))); 
			$major = mysqli_real_escape_string($con,trim(strip_tags($_POST['major']))); 
			
			//check to make sure the email is not in use yet...
			$query = "SELECT 1 FROM tblUser WHERE usr_email = '".$email."'";
			if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
					//email exists... let user know and quit
					echo "<p class='warrning'>The email entered is already in use. Please try again with a different email.</p>";
				}
				else
				{
					//email does not exist...Proceed

					//get the id of the major selected
					$mgrId;
					$query2 = "SELECT mgr_id FROM tblMajor INNER JOIN tblCollege ON tblMajor.mgr_clg_id = tblCollege.clg_id WHERE mgr_name = '".$major."' AND clg_name ='".$colle."'";
					
					if ($result2 = mysqli_query($con, $query2))
					{
						if (mysqli_num_rows($result2) > 0)
						{
							while($row2 = mysqli_fetch_assoc($result2)) 
							{
								$mgrId = $row2['mgr_id'];
								//now that we have everything we need we can go ahead and do an insert into tblUser for this newly registered user
								$query3 = "INSERT INTO tblUser (usr_fname, usr_lname, usr_email, usr_mgr_id)VALUES('$fname','$lname','$email', $mgrId)";
								if (mysqli_query($con, $query3))
								{
									//query ran properly
									if (SetPassword($passw,GetUserIdByEmail($email)))
									{
										echo "<p class='alert-box information'>Registration completed successfully. You may now login with the registered email and password.";
									}
									else
									{
										echo "<p class='alert-box error'>User has been created, however, password was not successfully set. Please contact an administrator for assitance.";
									}
								}
								else
								{
									//error occured trying to run insert query
									echo "<p class='alert-box error'>There was an error processing the submitted data. Please try again.</p>";	
								}
							}	
						}
						else
						{
							//no results. Only possible if user used javascript to input a new major into the select list or submits a major that's not in the database
							echo "<p class='alert-box warning'>The major recieved is not one of the options given in that college. Please try again with an option from the dropdown.</p>";
						}
					}
					else
					{
						//error occured.
						echo "<p class='error'>There was an error processing the submitted registration information. Please try again.</p>";
					}
				}
			}
			else 
			{ 	
				//error occured.
				echo "<p class='error'>There was an error validating the email. Please try again.</p>";
			}
		} else { /* submitted data doesn't contain the expected data. Should not happen. */ }
		
	}
?>
