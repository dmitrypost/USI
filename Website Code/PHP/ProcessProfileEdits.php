<?php
	/* page is for processing the posted changes in the edit profile page.
		sends the user id which gets checked against the logged in user id. 
		If they do not match check if the logged in user is an admin. If not access deny.
	*/
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		//display the data retrieved
			echo "data recieved";
		foreach ($_POST as $key => $val) {
		  echo '<br>'.$key.':'.$_POST[$key];
		}	
		
		include_once 'Functions.php';
		$con = open();
		if (isset($_POST['userid']) AND isset($_POST['firstname']) AND isset($_POST['lastname']) AND isset($_POST['email']) AND isset($_POST['gradstatus']) AND isset($_POST['major']) AND isset($_POST['phone']) AND isset($_POST['linkedin'])) 
		{ 
			//get the values out of the submitted data safely
			$usrid = mysqli_real_escape_string($con,trim(strip_tags($_POST['userid']))); 
			$fname = mysqli_real_escape_string($con,trim(strip_tags($_POST['firstname']))); 
			$lname = mysqli_real_escape_string($con,trim(strip_tags($_POST['lastname']))); 
			$email = mysqli_real_escape_string($con,trim(strip_tags($_POST['email']))); 
			$phone = mysqli_real_escape_string($con,trim(strip_tags($_POST['phone']))); 
			$major = mysqli_real_escape_string($con,trim(strip_tags($_POST['major']))); 
			$gradS = mysqli_real_escape_string($con,trim(strip_tags($_POST['gradstatus'])));
			$linkD = mysqli_real_escape_string($con,trim(strip_tags($_POST['linkedin'])));
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
				//processing of all other feilds 
				$query = "UPDATE tblUser SET usr_fname = '".$fname."',usr_lname = '".$lname."',usr_phone = '".$phone."',usr_graduate = ".$gradS.",usr_mgr_id=".GetMajorIdByName($major)." usr_linkedin ='".$linkD."'";
				if (mysqli_query($con, $query))
				{
					//updates executed correctly
					echo "<p class='information'>Changes have been processed and are in effect.</p>";	
				}
				else
				{
					echo "<p class='error'>There was an error processing the updates. Please try again.</p>";	
				}
			}
			else
			{
				//trying to make changes to a user profile while not logged in as that user or not logged in as an admin
				echo "<p class='error'>Access Denied!</p>";		
				break;
			}
						
		}
		mysqli_close($con);
	}
?>
