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
					$ProjectDescription = $row['pjh_description'];
					$ProjectBody = $row['pjh_body'];
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
							FormattedEditProjectPage($ProjectId,$ProjectTitle,$ProjectBody,$ProjectDescription,$ProjectMajorId,$ProjectYear, FormatParticipants($ProjectId),FormatFiles($ProjectId),FALSE);
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
		}
		else
		{
			echo "<p class='alert-box error'>There was an issue retrieving the project details. Please try again.</p>";
		}

	}
?>
