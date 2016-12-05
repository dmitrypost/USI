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
					$query = "UPDATE tblProjectHistory SET pjh_approved = TRUE WHERE pjh_id = $Value";
					$query2 = "
					UPDATE tblProject SET 
						pjt_body = (SELECT pjh_body FROM tblProjectHistory WHERE pjh_id = $Value), 
						pjt_description = (SELECT pjh_description FROM tblProjectHistory WHERE pjh_id = $Value)	WHERE pjt_id = $ProjectId";
					$query3 = "
					UPDATE tblRole SET rol_rst_id = $NormalRoleId WHERE rol_pjt_id = $ProjectId";
					if (QuickQuery($query) && QuickQuery($query2) && QuickQuery($query3))
					{
						echo "<p class='alert-box success'>The project was approved successfully!</p>";	
					}
					else
					{
						echo "<p class='alert-box error'>There was an issue approving the project!</p>";
					}
					break;
				case 'Deny':
					$ProjectId = GetProjectIdByProjectHistoryId($Value);
					$query = "UPDATE tblProjectHistory SET pjh_approved = FALSE WHERE pjh_id = $Value; ";
					$query2 = "UPDATE tblRole SET rol_rst_id = $RemovedRoleId WHERE rol_pjt_id = $ProjectId";
					if (QuickQuery($query) && QuickQuery($query2))
					{
						echo "<p class='alert-box success'>The project was approved successfully!</p>";	
					}
					else
					{
						echo "<p class='alert-box error'>There was an issue denying the project changes!</p>";
					}
					break;
				case 'Select':
				
					$hidden = ""; //make div visible
					$ProjectId = GetProjectIdByProjectHistoryId($Value);
					$query = "SELECT pjt_name, pjh_body, pjh_description FROM tblProjectHistory INNER JOIN tblProject ON tblProjectHistory.pjh_pjt_id = tblProject.pjt_id WHERE pjh_id = $Value";
					if ($result = mysqli_query($con, $query)){ if (mysqli_num_rows($result) > 0){ while($row = mysqli_fetch_assoc( $result)) {
						$Title = $row['pjt_name'];
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
					$query = "SELECT usr_fname, usr_lname, usr_email, rol_name FROM tblUser INNER JOIN tblRole ON tblUser.usr_id = tblRole.rol_usr_id WHERE rol_pjt_id = $ProjectId AND rol_rst_id = $PendingRemovalRoleId";
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
		  $query = "SELECT pjt_name, pjh_id, pjh_modified, usr_fname FROM tblProjectHistory INNER JOIN tblProject ON tblProjectHistory.pjh_pjt_id = tblProject.pjt_id INNER JOIN tblUser ON tblProjectHistory.pjh_usr_id = tblUser.usr_id WHERE pjh_approved IS NULL";
		  if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
		  while($row = mysqli_fetch_assoc( $result)) {
			  if ($Value == $row['pjh_id'])
			  {
				  echo "<option value=".$row['pjh_id']." selected>".$row['pjt_name']." ON ".$row['pjh_modified']." BY ".$row['usr_fname']."</option>";
			  }
			  else
			  {
				  echo "<option value=".$row['pjh_id'].">".$row['pjt_name']." ON ".$row['pjh_modified']." BY ".$row['usr_fname']."</option>";
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
		</div>
		";
		mysqli_close($con);
	}
	else
	{
		"<p class='alert-box error'>Access Denied!</p>";	
	}
?>
