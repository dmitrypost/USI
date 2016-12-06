<?php
	ini_set('display_errors', 1);
	echo "got to processing";
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		foreach ($_POST as $key => $val) {
		  echo '<br>'.$key.':'.$_POST[$key];
		}	
		
		include_once './PHP/Functions.php';
		$con = open(); 
		$UserId = getUID();
		//Page:AddProject title: year:2016 major:Anthropology description: body: AddedParticipants:
		if (isset($_POST['title']) && isset($_POST['projectid']) && isset($_POST['year']) && isset($_POST['major']) && isset($_POST['description']) && isset($_POST['body']) && isset($_POST['AddedParticipants']) && $UserId != 0)
		{
			
			$title = 		mysqli_real_escape_string($con,trim(strip_tags($_POST['title'])));	
			$projectId = 	mysqli_real_escape_string($con,trim(strip_tags($_POST['projectid'])));	
			$year = 		mysqli_real_escape_string($con,trim(strip_tags($_POST['year'])));	
			$major = 		mysqli_real_escape_string($con,trim(strip_tags($_POST['major'])));	
			$majorId = 		GetMajorIdByName($major);
			$description = 	mysqli_real_escape_string($con,trim(strip_tags($_POST['description'])));	
			$body = 		mysqli_real_escape_string($con,trim(strip_tags($_POST['body'])));	
			$AddedParticipants = mysqli_real_escape_string($con,trim(strip_tags($_POST['AddedParticipants'])));	
			
			//update the non-tracked changes
			$query = "UPDATE tblproject SET pjt_year = $year, pjt_mgr_id = $majorId WHERE pjt_id = $projectId";
			
			
			// check to see if there is existing tblprojecthistory that's not approved first
			$ProjectHistoryId = 0;
			
			$query2 = "INSERT INTO tblprojecthistory (pjh_name,pjh_description,pjh_body,pjh_usr_id,pjh_pjt_id,pjh_modified)VALUES('$title','$description','$body',$UserId,$projectId,NOW());";
			
			$query3 = "SELECT pjh_id FROM tblprojecthistory WHERE pjh_pjt_id = $projectId AND pjh_approved IS NULL";
			if ($result = mysqli_query($con, $query3))
			{ 	if (mysqli_num_rows($result) > 0)
				{	while($row = mysqli_fetch_assoc( $result)) 
					{
						$ProjectHistoryId = $row['pjh_id']; // change the query2 only if there is an existing edit pending for approval
						$query2 = "UPDATE tblprojecthistory SET pjh_name = '$title', pjh_description = '$description', pjh_body = '$body',pjh_usr_id = $UserId,pjh_modified = NOW() WHERE pjh_pjt_id = $ProjectHistoryId";
					}
				}
			}
			
			if (QuickQuery($query2) && QuickQuery($query))
			{
				//process the participants...
				if (strlen($AddedParticipants) > 0 )
				{
					//echo $AddedParticipants;
					$Participants = explode("|",$AddedParticipants);
					foreach ($Participants as $key => $val) 
					{
						if (strlen($val) > 0)
						{
							$PData = explode(",",$Participants[$key]);
							$fname = explode(":",$PData[0]); $fname = $fname[1];
							$lname = explode(":",$PData[1]); $lname = $lname[1];
							$email = explode(":",$PData[2]); $email = $email[1];
							$role = explode(":",$PData[3]); $role = $role[1];
							if (ParticipantDataValid($fname,$lname,$email,$role,$projectId))
							{
								// proceed
								if (GetUserIdByEmail($email) != 0) //user already registered
								{
									AddRegisteredParticipant($email,$role,$projectId);
									echo "<p class='alert-box notice'>Participant with the email $email is already registered. Added to project with the role of $role.</p>";		
								}
								else
								{
									AddUnregisteredParticipant($fname,$lname,$email,$role,$projectId);	
									echo "<p class='alert-box notice'>Participant with the email $email is not registered. An email has been sent to them containing login information.</p>";
								}							
							}
							else
							{
								echo "<p class='alert-box error'>Participant '$fname $lname' did not have valid data; participant skipped being added.</p>";	
							}
						}//if
					}//foreach
				}//(strlen($AddedParticipants) > 0 )
				echo "<p class='alert-box success'>Project changes submitted for approval</p>";
			}//if query
			else
			{
				echo "<p class='alert-box error'>There was an error in processing the changes. Please try again.</p>";
				echo $query2;
			}
			
		}
		else
		{
			echo "<p class='alert-box error'>You must be logged in and passing the correct arguments.</p>";
		}
		mysqli_close($con);
	}
?>
