<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
		include_once 'Functions.php';
		$con = Open();		
		if (isset($_POST['value']))
		{
			$MajorId = mysqli_real_escape_string($con,trim(strip_tags($_POST['value'])));
			PageTitle(GetMajorNameById($MajorId));
			$query = "SELECT usr_id, usr_fname, usr_lname, mgr_name, clg_name FROM tbluser INNER JOIN tblmajor ON tbluser.usr_mgr_id = tblmajor.mgr_id INNER JOIN tblcollege ON tblmajor.mgr_clg_id = tblcollege.clg_id WHERE mgr_id = $MajorId";
			if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
				echo "<h6>Users with this major:</h6>";
				while($row = mysqli_fetch_assoc( $result)) 
				{
						FormattedUserLink($row['usr_id'],$row['usr_fname']." ".$row['usr_lname']);
				}
			} else { echo "no users found with this major";/*no users found*/ }
			} else { echo 'error';}
			echo "<br>";
			//projects that belong to this major
			$query = "SELECT pjt_id, pjt_name FROM tblproject WHERE pjt_mgr_id = $MajorId";
			if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
				echo "<h6>Projects with this major:</h6>";
				while($row = mysqli_fetch_assoc( $result)) 
				{
					FormattedProjectLink($row['pjt_id'],$row['pjt_name']);
				}
			} else { echo "no projects found with this major";/*no users found*/ }
			} else { echo 'error';}
		}
	}
?>