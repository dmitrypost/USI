<?php
	include_once 'Functions.php'; //include_once 'Database.php'; //database.php is already included within the functions.php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		if (isset($_POST['value']))
		{
			include_once 'Functions.php';
			$con = Open();
			//$Action  = mysqli_real_escape_string($con,trim(strip_tags($_POST['Action']))); 
			$Value  = mysqli_real_escape_string($con,trim(strip_tags($_POST['value']))); 
			PageTitle("Projects");
			if (isLoggedIn())
			{
				$uid = getUID();
				if ($Value == "Owned")
				{
						$query = "SELECT rol_name, pjt_name, pjt_description, mgr_name, usr_id , pjt_year, pjt_id FROM tbluser INNER JOIN tblrole ON tbluser.usr_id = tblrole.rol_usr_id INNER JOIN tblproject ON tblrole.rol_pjt_id = tblproject.pjt_id INNER JOIN tblMajor ON tblproject.pjt_mgr_id = tblMajor.mgr_id WHERE usr_id =$uid AND pjt_description != 'pending'";
						if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){ while($row = mysqli_fetch_assoc( $result)) {
							FormattedProjectPreview($row['pjt_name'],$row['pjt_description'],$row['pjt_year'],$row['pjt_id'],true);
						}}}	
					
				}
				elseif($Value == "All")
				{
					
						$query = "SELECT * FROM
								(
								SELECT rol_name, pjt_name, pjt_description, pjt_year, pjt_id FROM tblProject INNER JOIN tblrole ON tblrole.rol_pjt_id = tblproject.pjt_id WHERE rol_usr_id = $uid AND pjt_description != 'pending' 
								UNION ALL
								SELECT '' as rol_name , pjt_name, pjt_description, pjt_year, pjt_id FROM tblProject WHERE pjt_description != 'pending'
								) as t
								GROUP BY
								pjt_id";
						if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){ while($row = mysqli_fetch_assoc( $result)) {
							
							FormattedProjectPreview($row['pjt_name'],$row['pjt_description'],$row['pjt_year'],$row['pjt_id'],strlen($row['rol_name'])>0);
						}}}
				}
			}
			else
			{
				$query = "SELECT pjt_name, pjt_description, pjt_year, pjt_id FROM tblproject WHERE pjt_description != 'pending'";
				if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_assoc( $result)) {
					FormattedProjectPreview($row['pjt_name'],$row['pjt_description'],$row['pjt_year'],$row['pjt_id'],false);
				}}}	
			}
			
			mysqli_close($con);
		}
		else
		{
			$con = Open();
			PageTitle("Projects");
			$query = "SELECT pjt_name, pjt_description, pjt_year, pjt_id FROM tblproject WHERE pjt_description != 'pending'";
			if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc( $result)) {
				FormattedProjectPreview($row['pjt_name'],$row['pjt_description'],$row['pjt_year'],$row['pjt_id'],false);
			}}}	
			mysqli_close($con);	
	}}
?>
