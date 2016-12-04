<?php
	include_once 'Functions.php';
	PageTitle("Add Project");
	$UserId = getUID();
	if ($UserId == 0)
	{
		echo "<p class='alert-box error'>You must be logged in to add a project.</p>";
	}
	else 
	{
		/*foreach ($_POST as $key => $val) {
		  echo '<p>'.$key.':'.$_POST[$key].'</p>';
		}*/
		//Page:AddProject title: year:2016 major:Anthropology description: body: AddedParticipants:
		if (isset($_POST['title']) && isset($_POST['year']) && isset($_POST['major']) && isset($_POST['description']) && isset($_POST['body']) && isset($_POST['AddedParticipants']))
		{
			$con = Open();
			$title = mysqli_real_escape_string($con,trim(strip_tags($_POST['title'])));	
			$year = mysqli_real_escape_string($con,trim(strip_tags($_POST['year'])));	
			$major = mysqli_real_escape_string($con,trim(strip_tags($_POST['major'])));	
			$majorId = GetMajorIdByName($major);
			$description = mysqli_real_escape_string($con,trim(strip_tags($_POST['description'])));	
			$body = mysqli_real_escape_string($con,trim(strip_tags($_POST['body'])));	
			$AddedParticipants = mysqli_real_escape_string($con,trim(strip_tags($_POST['AddedParticipants'])));	
			
			//add a project into tblproject (not visiable just a place holder
			//add a pending change into project history
			$query = "INSERT INTO tblProject (pjt_name,pjt_description,pjt_mgr_id,pjt_year)VALUES('$title','pending','$majorId','$year');"; $lastProjectId = GetLastProjectId();
			$query2 = "INSERT INTO tblProjectHistory (pjh_description,pjh_body,pjh_usr_id,pjh_pjt_id,pjh_approved,pjh_modified)VALUES('$description','$body',$UserId,$lastProjectId,FALSE,NOW());";
			if (strlen($AddedParticipants) > 0 )
			{
				echo $AddedParticipants;
				$Participants = explode("|",$AddedParticipants);
				foreach ($Participants as $key => $val) {
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
					}
				}
				
			}
			if (true)//QuickQuery($query) && QuickQuery($query2)
			{
				echo "<p class='alert-box success'>Project added and pending approval.</p>";
			}
			else
			{
				echo "<p class='alert-box error'>There was an issue with adding the project. If this persists please contact an administrator</p>";
			}
			mysqli_close($con);
		}
		else 
		{
			//FormattedEditProjectPage($ProjectId,$ProjectTitle,$ProjectBody,$ProjectDescription,$ProjectMajorId,$ProjectYear,$FormattedParticipantsHTML,$FormattedFilesHTML,$AddEdit)
			FormattedEditProjectPage(0,'Title Goes Here','Content about the actual project','Describe the project here',0,date("Y"),'','',TRUE);
		}		

	}
?>