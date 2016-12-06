<?php
	include_once 'Functions.php';
	PageTitle("Project Approvals");
	if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isAdmin()))
    {
		$con = Open();
		$hidden = "hidden";
		$NormalRoleId = GetRoleIdByName("NORMAL");
		$PendingRemovalRoleId = GetRoleIdByName("PENDING REMOVAL");
		$RemovedRoleId = GetRoleIdByName("REMOVED");
		if (isset($_POST['Action']) && isset($_POST['value']))
		{
			$Action = mysqli_real_escape_string($con,trim(strip_tags($_POST['Action']))); 	//action 
			$Value = mysqli_real_escape_string($con,trim(strip_tags($_POST['value']))); 	//ProjectHistoryId
			switch ($Action)
			{
				case 'Approve':	
					$ProjectId = GetProjectIdByProjectHistoryId($Value);
					
					$query2 = "
					UPDATE tblproject SET 
						pjt_body = (SELECT pjh_body FROM tblprojecthistory WHERE pjh_id = $Value), 
						pjt_description = (SELECT pjh_description FROM tblprojecthistory WHERE pjh_id = $Value),
						pjt_name = (SELECT pjh_name FROM tblprojecthistory WHERE pjh_id = $Value) 
					WHERE pjt_id = $ProjectId";
					$query3 = "
					UPDATE tblrole SET rol_rst_id = $NormalRoleId WHERE rol_pjt_id = $ProjectId";
					if (QuickQuery($query2) && QuickQuery($query3))
					{	
						QuickQuery("UPDATE tblprojecthistory SET pjh_approved = TRUE WHERE pjh_id = $Value");
						echo "<p class='alert-box success'>The project was approved successfully!</p>";	
					}
					else
					{
						echo "<p class='alert-box error'>There was an issue approving the project!</p>";
					}
					break;
				case 'Deny':
					$ProjectId = GetProjectIdByProjectHistoryId($Value);
					$query = "UPDATE tblprojecthistory SET pjh_approved = FALSE WHERE pjh_id = $Value; ";
					$query2 = "UPDATE tblrole SET rol_rst_id = $RemovedRoleId WHERE rol_pjt_id = $ProjectId";
					if (QuickQuery($query) && QuickQuery($query2))
					{
						echo "<p class='alert-box success'>The project was denied successfully!</p>";	
					}
					else
					{
						echo "<p class='alert-box error'>There was an issue denying the project changes!</p>";
					}
					break;
				case 'Select':
				
					$hidden = ""; //make div visible
					$ProjectId = GetProjectIdByProjectHistoryId($Value);
					$query = "SELECT pjh_name, pjh_body, pjh_description FROM tblprojecthistory INNER JOIN tblproject ON tblprojecthistory.pjh_pjt_id = tblproject.pjt_id WHERE pjh_id = $Value";
					if ($result = mysqli_query($con, $query)){ if (mysqli_num_rows($result) > 0){ while($row = mysqli_fetch_assoc( $result)) {
						$Title = $row['pjh_name'];
						$Description = $row['pjh_description'];
						$Body = $row['pjh_body'];
					}}}
					$RemovalParticipantsHTML = "
					<table width='100%' border='0' cellpadding='2'>
						<tbody>
							<tr>
								<th scope='col'>First Name</th>
								<th scope='col'>Last Name</th>
								<th scope='col'>Email</th>
								<th scope='col'>Role</th>
							</tr>
							<tr>
								<tr></tr><tr></tr><tr></tr><tr></tr>
							</tr>
							";
					$query = "SELECT usr_fname, usr_lname, usr_email, rol_name FROM tbluser INNER JOIN tblrole ON tbluser.usr_id = tblrole.rol_usr_id WHERE rol_pjt_id = $ProjectId AND rol_rst_id = $PendingRemovalRoleId";
					if ($result = mysqli_query($con, $query)){ if (mysqli_num_rows($result) > 0){ while($row = mysqli_fetch_assoc( $result)) {
						$RemovalParticipantsHTML .= "<tr><td>".$row['usr_fname']."</td><td>".$row['usr_lname']."</td><td>".$row['usr_email']."</td><td>".$row['rol_name']."</td></tr>";
					}}}
					$RemovalParticipantsHTML .= "									
						</tbody>
					</table>
					";
					break;
				default:
					echo "<p class='alert-box error'>The action sent is not recognized!</p>";	
					break;
			}
			
		}//isset action isset value
		
		echo "<select id='slt_selected' class='w100percent' onChange='GoToPage(\"ProjectApprovals\",\"Select\",$(\"#slt_selected\").val(),\"\")'>
				<option></option>";
		  $con = open();
		  $query = "SELECT pjt_id, pjt_name, pjh_id, pjh_modified, usr_fname FROM tblprojecthistory INNER JOIN tblproject ON tblprojecthistory.pjh_pjt_id = tblproject.pjt_id INNER JOIN tbluser ON tblprojecthistory.pjh_usr_id = tbluser.usr_id WHERE pjh_approved IS NULL";
		  if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
		  while($row = mysqli_fetch_assoc( $result)) {
			  if ($Value == $row['pjh_id'])
			  {
				  echo "<option value=".$row['pjh_id']." data='".$row['pjt_id']."' selected>".$row['pjt_name']." ON ".$row['pjh_modified']." BY ".$row['usr_fname']."</option>";
			  }
			  else
			  {
				  echo "<option value=".$row['pjh_id']." data='".$row['pjt_id']."'>".$row['pjt_name']." ON ".$row['pjh_modified']." BY ".$row['usr_fname']."</option>";
			  }
		  }
		  } else { /*no results found*/ }
		  } else {echo 'failed to get project approvals';}
		
		echo "</select>
		<hr>
		<div id='div_PendingChanges' class='$hidden'>
			<h5>Project Title:</h5> $Title<br>
			<h5>Project Description:</h5> $Description<br>
			<h5>Project Body:</h5> $Body<br>
			<h5>Project Participants Pending Removeal:</h5> $RemovalParticipantsHTML<br> 
			<hr>
			<button onClick='GoToPage(\"ProjectApprovals\",\"Approve\",$(\"#slt_selected option:selected\").val(),\"\")' value='Approve'>Approve</button>
			<button onClick='GoToPage(\"ProjectApprovals\",\"Deny\",$(\"#slt_selected option:selected\").val(),\"\")' value='Approve'>Deny</button>
			<button onClick='GoToPage(\"EditProject\",\"\",$(\"#slt_selected option:selected\").attr(\"data\"),\"\")'>Edit</button>
		</div>
		";
		mysqli_close($con);
	}
	else
	{
		echo "<p class='alert-box error'>Access Denied!</p>";	
	}
?>
