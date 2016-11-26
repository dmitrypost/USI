<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
		include_once 'Functions.php';
		$con = Open();		
		if (isset($_POST['value']))
		{ 
			$CollegeId = mysqli_real_escape_string($con,trim(strip_tags($_POST['value'])));
			PageTitle(GetCollegeNameById($CollegeId));
			$query = "SELECT mgr_id, mgr_name, clg_name FROM tblMajor INNER JOIN tblCollege ON tblMajor.mgr_clg_id = tblCollege.clg_id WHERE clg_id = $CollegeId";
			if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc( $result)) 
				{
					FormattedMajorLink($row['mgr_id'],$row['mgr_name']);
				}
			} else { /*no users found*/ }
			} else {echo 'error';}
		}
		mysqli_close($con);
 	}
 ?> 