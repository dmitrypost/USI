<?php
	include_once 'Functions.php'; //include_once 'Database.php'; //database.php is already included within the functions.php
	if (isLoggedIn())
	{
		$uid = getUID();
		$con = Open();
		$query = "SELECT rol_name, pjt_name, pjt_description, mgr_name, usr_id , pjt_year, pjt_id FROM tbluser INNER JOIN tblrole ON tbluser.usr_id = tblrole.rol_usr_id INNER JOIN tblproject ON tblrole.rol_pjt_id = tblproject.pjt_id INNER JOIN tblMajor ON tblproject.pjt_mgr_id = tblMajor.mgr_id WHERE usr_id = ". $uid;
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc( $result)) {
			echo "";
			echo "
			<div class='project-preview'>
				<h5><a href='javascript:void(0)' onClick='showProject(".$row['pjt_id'].")'>".$row['pjt_name']."</a> - ".$row['rol_name']."<a href='javascript:void(0)' onClick='editProject(".$row['pjt_id'].")'> Edit</a></h5> 
				<br>".$row['pjt_description']."
				<br>".$row['pjt_year']."
				<br>
			</div>
			";
		}
		} else {echo 'no projects found for this user';}
		} else {echo 'error';}
			
		
	
		mysqli_close($con);	
	}
?>
