<?php
	include_once 'Functions.php';

	//helper functions for easier formatting of the page
	function FormattedParticipant($ParticipantName,$ParticipantId,$ParticipantRole,$ParticipantEmail)
	{
		return "
		<div class='Participant'>
			$ParticipantName -- $ParticipantRole<br>
			<a href='mailto:$ParticipantEmail'>$ParticipantEmail</a>
			<a onClick='showProfile($ParticipantId)'>
			</a><input type='hidden' value='$ParticipantId'>
		</div><br>";
	}

	function FormattedFile($FileName,$FileId)
	{
		return "
		<div class='File' onClick='FileDownload($FileId)'>
			$FileName
		</div>
		";
	}
<<<<<<< HEAD

	function FormattedEditProjectPage($ProjectId,$ProjectTitle,$ProjectBody,$ProjectDescription,$ProjectMajorId,$ProjectYear,$FormattedParticipantsHTML,$FormattedFilesHTML)
	{
		echo "
		<input type='hidden' id='hdn_ProjectId' value='$ProjectId'>
		<div id='accordion'>
			<h3>Basic Information</h3>
				<div>
					Title<input type='text' id='txt_title' value='$ProjectTitle'>
					Year<input type='text' class='w300' id='txt_year' value='$ProjectYear'>
					Major<br>
					<select id='slt_major'>";
					include_once 'Database.php';
										$con = open();
										$query = "SELECT mgr_id, mgr_name FROM tblMajor ";
										if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
										while($row = mysqli_fetch_assoc( $result)) {
												if ($row['mgr_id'] == $ProjectMajorId)
												{
													echo "<option value=".$row['mgr_id']." selected>".$row['mgr_name']."</option>";
												}
												else
												{
													echo "<option value=".$row['mgr_id'].">".$row['mgr_name']."</option>";
												}
										}
										} else { /*no results found*/ }
										} else {echo 'error';}
							mysqli_close($con); echo "
					</select>
				</div>
			<h3>Description</h3>
				<div>
					Description<input type='text' id='txt_description' value='$ProjectDescription'>
					Project description will be submitted for approval by an administrator.
				</div>
			<h3>Body</h3>
				<div>
					Body<textarea id='txt_body' >$ProjectBody</textarea>
					Project body will be submitted for approval by an administrator.
				</div>
			<h3>Participants</h3>
				<div>
					$FormattedParticipantsHTML
					<hr>
					<div id='participants'>

					</div>
					<input type='hidden' id='hdn_AddingParticipantCount' value='0'>
					<div id='participant' class='hidden'>
						First name<input type='text' class='participant-fname w300'>
						Last name<input type='text' class='participant-lname w300'>
						Email<input type='email' class='participant-email w300'>
						Role<input type='text' class='participant-role w300'>
					</div>
					<button type='button' class='btn btn-default btn-sm' onClick='addParticipantRow()'>
					  <span class='glyphicon glyphicon-plus'></span> Add
					</button><br>
					Removing project participants will require approval by an administrator.
				</div>
			<h3>Files</h3>
				<div>
					$FormattedFilesHTML
					<hr>
					<button type='button' class='btn btn-default btn-sm' onClick=''>
					  <span class='glyphicon glyphicon-plus'></span> Add
					</button>
				</div>
		</div>
		<input class='button' type='button' value='Submit' onClick='ProcessProjectChanges()'>
		<img src='/images/pixel.png' onload='EditProjectLoaded()' width='0' height='0'>
		";
	}

=======
	
>>>>>>> origin/master
	function FormatParticipants($ProjectID)
	{
		$con = Open();
		$query = "SELECT usr_fname, usr_lname, usr_id, usr_email, rol_name FROM tblUser INNER JOIN tblRole ON tblUser.usr_id = tblRole.rol_usr_id WHERE rol_pjt_id = $ProjectID";
		$ParticipantsHTML = "";
		if ($result = mysqli_query($con,$query))
		{ if(mysqli_num_rows($result) > 0)
			{while ($row = mysqli_fetch_assoc($result))
				{
					$ParticipantsHTML .= FormattedParticipant($row['usr_fname']." ".$row['usr_lname'],$row['usr_id'],$row['rol_name'],$row['usr_email']);
				}
			}
		}
		mysqli_close($con);
		return $ParticipantsHTML;
	}

	function FormatFiles($ProjectID)
	{
		$con = Open();
		$query = "SELECT fle_id, fle_name FROM tblFile INNER JOIN tblProject ON tblFile.fle_pjt_id = tblProject.pjt_id = $ProjectID";
		$FilesHTML = "";
		if ($result = mysqli_query($con,$query))
		{ if(mysqli_num_rows($result) > 0)
			{while ($row = mysqli_fetch_assoc($result))
				{
					$FilesHTML .= FormattedFile($row['fle_name'],$row['fle_id']);
				}
			}
		}
		mysqli_close($con);
		return $FilesHTML;
	}

	//start writing of the actual page...
	PageTitle("Edit Project");
	$con = Open();

	if (!isset($_POST['value']))
	{
		echo "<p class='alert-box error>No project id was passed.</p>";
	}
	else
	{
		$ProjectId = mysqli_real_escape_string($con,trim(strip_tags($_POST['value'])));
		//variables
		$ProjectTitle; $ProjectDescription; $ProjectBody; $ProjectMajorId;

		$query = "SELECT pjh_description, pjh_body FROM tblProjectHistory WHERE pjh_id =$ProjectId AND pjh_approved = FALSE";
		if ($result = mysqli_query($con,$query))
		{ if(mysqli_num_rows($result) > 0)
			{
				while ($row = mysqli_fetch_assoc($result))
				{
					$ProjectDescription = $row['pjt_description'];
					$ProjectBody = $row['pjt_body'];
				}
				$query2 = "SELECT pjt_name, pjt_mgr_id, pjt_picture, pjt_year FROM tblProject WHERE pjt_id = $ProjectId";
				if ($result2 = mysqli_query($con,$query2))
				{ if (mysqli_num_rows($result2) > 0)
					{
						while ($row2 = mysqli_fetch_assoc($result2))
						{
							$ProjectTitle = $row2['pjt_name'];
							$ProjectMajorId = $row2['pjt_mgr_id'];
							$ProjectYear = $row2['pjt_year'];
							FormattedEditProjectPage($ProjectId, $ProjectTitle,$ProjectBody,$ProjectDescription,$ProjectMajorId,$ProjectYear, FormatParticipants($ProjectId),FormatFiles($ProjectId),FALSE);
						}
					}
					else
					{
						echo "<p class='alert-box information'>There is no project with that id. Please try again.</p>";
					}
				}
				else
				{
					echo "<p class='alert-box error'>There was an issue retrieving the project details. Please try again.</p>";
				}
			}
			else
			{
				//project does not have any pending changes
				$query = "SELECT pjt_name, pjt_description, pjt_body, pjt_mgr_id, pjt_year, pjt_picture FROM tblProject WHERE pjt_id = $ProjectId";
				if ($result = mysqli_query($con,$query))
				{ if (mysqli_num_rows($result) > 0)
					{ while ($row = mysqli_fetch_assoc($result))
						{
							$ProjectTitle = $row['pjt_name']; $ProjectBody = $row['pjt_body']; $ProjectDescription = $row['pjt_description']; $ProjectMajorId = $row['pjt_mgr_id']; $ProjectYear = $row['pjt_year'];
<<<<<<< HEAD
							FormattedEditProjectPage($ProjectId,$ProjectTitle,$ProjectBody,$ProjectDescription,$ProjectMajorId,$ProjectYear, FormatParticipants($ProjectId),FormatFiles($ProjectId));
						}
=======
							FormattedEditProjectPage($ProjectId,$ProjectTitle,$ProjectBody,$ProjectDescription,$ProjectMajorId,$ProjectYear, FormatParticipants($ProjectId),FormatFiles($ProjectId),FALSE);
						}						
>>>>>>> origin/master
					}
					else
					{
						echo "<p class='alert-box information'>There is no project with that id. Please try again.</p>";
					}
				}
				else
				{
					echo "<p class='alert-box error'>There was an issue retrieving the project details. Please try again.</p>";
				}
			}
		}
		else
		{
			echo "<p class='alert-box error'>There was an issue retrieving the project details. Please try again.</p>";
		}

	}
?>
