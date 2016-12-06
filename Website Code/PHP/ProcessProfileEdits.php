<?php
	ini_set('display_errors', 1);
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		foreach ($_POST as $key => $val) {
		  echo '<br>'.$key.':'.$_POST[$key];
		}	
		
		include_once './PHP/Functions.php';
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
							$query = "UPDATE tbluser SET usr_email = '".$email."' WHERE usr_id =".$usrid;
							if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
    						{
								QuickQuery($query);
							}
							else
							{
								echo "<p class='alert-box error'>The email is not a valid email. Please try again.</p>";	
							}
						break;
					default:
						//a userid returned already belongs to another user. Show to user the email belongs to another user.
						echo "<p class='alert-box warning'>The email entered is already in use. Please try again with a different email.</p>";
						break;	
				}
				//processing of all other feilds 
				$query = "UPDATE tbluser SET usr_fname = '$fname',usr_lname = '$lname',usr_phone = '$phone',usr_graduate = $gradS,usr_mgr_id=".GetMajorIdByName($major).", usr_linkedin ='$linkD' WHERE usr_id =$usrid";
				if (mysqli_query($con, $query))
				{
					//updates executed correctly
					echo "<p class='alert-box success'>Changes have been processed and are in effect.</p>";	
				}
				else
				{
					echo "<p class='alert-box error'>There was an error processing the updates. Please try again.</p>";	
				}
			}
			else
			{
				//trying to make changes to a user profile while not logged in as that user or not logged in as an admin
				echo "<p class='alert-box error'>Access Denied!</p>";		
				break;
			}
						
		}
		mysqli_close($con);
	}
?>
