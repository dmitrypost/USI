<?php
	/* page is for processing the posted changes in the edit profile page.
		sends the user id which gets checked against the logged in user id. 
		If they do not match check if the logged in user is an admin. If not access deny.
	*/
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		//display the data retrieved
		/*	echo "data recieved";
		foreach ($_POST as $key => $val) {
		  echo '<br>'.$key.':'.$_POST[$key];
		}	*/
		
		include_once 'Functions.php';
		$con = open();
		if (isset($_POST['userid']) AND isset($_POST['firstname']) AND isset($_POST['lastname']) AND isset($_POST['email']) AND isset($_POST['password']) AND isset($_POST['gradstatus']) AND isset($_POST['major']) AND isset($_POST['phone']) AND isset($_POST['linkedin'])) 
		{ 
			//get the values out of the submitted data safely
			$usrid = mysqli_real_escape_string($con,trim(strip_tags($_POST['userid']))); 
			$fname = mysqli_real_escape_string($con,trim(strip_tags($_POST['firstname']))); 
			$lname = mysqli_real_escape_string($con,trim(strip_tags($_POST['lastname']))); 
			$email = mysqli_real_escape_string($con,trim(strip_tags($_POST['email']))); 
			$passw = mysqli_real_escape_string($con,trim(strip_tags($_POST['password']))); 
			$phone = mysqli_real_escape_string($con,trim(strip_tags($_POST['phone']))); 
			$major = mysqli_real_escape_string($con,trim(strip_tags($_POST['major']))); 
			$gradS = mysqli_real_escape_string($con,trim(strip_tags($_POST['gradstatus'])));
			if (($usrid == getUID()) || isAdmin())
			{
				//processing of email change
				switch (GetUserIdByEmail($email))
				{
					case $usrid:
						//no changes to email made... 
								
						break;
					case 0:
						//email not in use ... update email to submitted email
							$query = "UPDATE tblUser SET usr_email = '".$email."' WHERE usr_id =".$usrid;
						break;
					default:
						//a userid returned already belongs to another user. Show to user the email belongs to another user.
						echo "<p class='warrning'>The email entered is already in use. Please try again with a different email.</p>";
						break;	
				}
				//processing of all other feilds -password
				$query = "UPDATE tblUser SET usr_fname = '".$fname."',usr_lname = '".$lname."',usr_phone = '".$phone."',usr_graduate = ".$gradS.",usr_mgr_id=".GetMajorIdByName($major);
				if (mysqli_query($con, $query))
				{
					//updates executed correctly
					
				}
				else
				{
					echo "<p class='error'>There was an error processing the updates. Please try again.</p>";	
				}
				//process password change
				
			}
			else
			{
				//trying to make changes to a user profile while not logged in as that user or not logged in as an admin
				echo "<p class='error'>Access Denied!</p>";		
				break;
			}
			
			
			if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
					//email exists... let user know and quit
				
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
								$query3 = "INSERT INTO tblUser (usr_fname, usr_lname, usr_email, usr_password, usr_mgr_id)VALUES('$fname','$lname','$email','$passw',$mgrId)";
								if (mysqli_query($con, $query3))
								{
									//query ran properly
									echo "<p class='information'>Registration completed successfully. You may now login with the registered email and password.";
								}
								else
								{
									//error occured trying to run insert query
									echo "<p class='error'>There was an error processing the submitted data. Please try again.</p>";	
								}
							}	
						}
						else
						{
							//no results. Only possible if user used javascript to input a new major into the select list or submits a major that's not in the database
							echo "<p class='warrning'>The major recieved is not one of the options given in that college. Please try again with an option from the dropdown.</p>";
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
