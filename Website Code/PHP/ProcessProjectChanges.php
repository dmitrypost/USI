<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		/*foreach ($_POST as $key => $val) {
		  echo '<br>'.$key.':'.$_POST[$key];
		}	*/
		
		include_once 'Functions.php';
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
			
			
			// check to see if there is existing tblProjectHistory that's not approved first
			$ProjectHistoryId = 0;
			
			$query2 = "INSERT INTO tblProjectHistory (pjh_description,pjh_body,pjh_usr_id,pjh_pjt_id,pjh_modified)VALUES('$description','$body',$UserId,$projectId,NOW());";
			
			$query = "SELECT pjh_id FROM tblProjectHistory WHERE pjh_pjt_id = $projectId AND pjh_approved IS NULL";
			if ($result = mysqli_query($con, $query))
			{ 	if (mysqli_num_rows($result) > 0)
				{	while($row = mysqli_fetch_assoc( $result)) 
					{
						$ProjectHistoryId = $row['pjh_id']; // change the query2 only if there is an existing edit pending for approval
						$query2 = "UPDATE tblProjectHistory pjh_description = '$description', pjh_body = '$body',pjh_usr_id = $UserId,pjh_modified = NOW() WHERE pjh_pjt_id = $ProjectHistoryId";
					}
				}
			}
			
			if (QuickQuery($query2))
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
							if (ParticipantDataValid($fname,$lname,$email,$role,$lastProjectId))
							{
								// proceed
								if (GetUserIdByEmail($email) != 0) //user already registered
								{
									AddRegisteredParticipant($email,$role,$lastProjectId);
									echo "<p class='alert-box notice'>Participant with the email $email is already registered. Added to project with the role of $role.</p>";		
								}
								else
								{
									AddUnregisteredParticipant($fname,$lname,$email,$role,$lastProjectId);	
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
			}
			
		}
		else
		{
			echo "<p class='alert-box error'>You must be logged in and passing the correct arguments.</p>";
		}
		mysqli_close($con);
	}
?>
