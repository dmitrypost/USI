<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
		include_once 'Database.php';
		$con = Open();		
		if (!isset($_POST['cid'])) { $CollegeId = "Test"; }
		else{ $CollegeId = mysqli_real_escape_string($con,trim(strip_tags($_POST['cid'])));}
		$query = "SELECT mgr_id, mgr_name, clg_name FROM tblMajor INNER JOIN tblCollege ON tblMajor.mgr_clg_id = tblCollege.clg_id WHERE clg_id = $CollegeId";
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
			$Title = True; //variable to make sure we show the college name once.
			while($row = mysqli_fetch_assoc( $result)) {
			if ($Title) { echo "<h3>".$row['clg_name']."</h3>"; $Title = False;}
			echo "
			<div class='major-link'>
				<a href='javascript:void(0)' onClick='showMajor(".$row['mgr_id'].")'>".$row['mgr_name']."</a>
				<br>
			</div>
			";
		}
		} else { /*no users found*/ }
		} else {echo 'error';}
	}
?>