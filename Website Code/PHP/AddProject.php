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
		foreach ($_POST as $key => $val) {
		  echo '<p>'.$key.':'.$_POST[$key].'</p>';
		}
		//Page:AddProject title: year:2016 major:Anthropology description: body: AddedParticipants:
		if (isset($_POST['title']) && isset($_POST['year']) && isset($_POST['major']) && isset($_POST['description']) && isset($_POST['body']) && isset($_POST['AddedParticipants']))
		{
			$title = mysqli_real_escape_string($con,trim(strip_tags($_POST['title'])));	
			$year = mysqli_real_escape_string($con,trim(strip_tags($_POST['year'])));	
			$major = mysqli_real_escape_string($con,trim(strip_tags($_POST['major'])));	
			$description = mysqli_real_escape_string($con,trim(strip_tags($_POST['description'])));	
			$body = mysqli_real_escape_string($con,trim(strip_tags($_POST['body'])));	
			$AddedParticipants = mysqli_real_escape_string($con,trim(strip_tags($_POST['AddedParticipants'])));	
			$query = "INSERT INTO tblProject (pjt_name,pjt_description,pjt_mgr_id,pjt_year)VALUES()";
			echo "<p class='alert-box error'>Project added and pending approval.</p>";
		}
		else 
		{
			//FormattedEditProjectPage($ProjectId,$ProjectTitle,$ProjectBody,$ProjectDescription,$ProjectMajorId,$ProjectYear,$FormattedParticipantsHTML,$FormattedFilesHTML,$AddEdit)
			FormattedEditProjectPage(0,'','','',0,date("Y"),'','',TRUE);
		}		

	}


?>