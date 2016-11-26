<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
		include_once 'Functions.php';
		$con = Open();		
		if (isset($_POST['value']))
		{
			$MajorId = mysqli_real_escape_string($con,trim(strip_tags($_POST['value'])));
			PageTitle(GetMajorNameById($MajorId));
			$query = "SELECT usr_id, usr_fname, usr_lname, mgr_name, clg_name FROM tblUser INNER JOIN tblMajor ON tblUser.usr_mgr_id = tblMajor.mgr_id INNER JOIN tblCollege ON tblMajor.mgr_clg_id = tblCollege.clg_id WHERE mgr_id = $MajorId";
			if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
				echo "<h6>Users with this major:</h6>";
				while($row = mysqli_fetch_assoc( $result)) 
				{
				FormattedUserLink($row['usr_id'],$row['usr_fname']." ".$row['usr_lname']);
				}
			} else { echo "no users found with this major";/*no users found*/ }
			} else {echo 'error';}
			//projects that belong to this major
		}
	}
?>