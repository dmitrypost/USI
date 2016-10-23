<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
		include_once 'Database.php';
		$con = Open();		
		if (!isset($_POST['mid'])) { $MajorId = "Test"; }
		else{ $MajorId = mysqli_real_escape_string($con,trim(strip_tags($_POST['mid'])));}
		$query = "SELECT usr_id, usr_fname, usr_lname, mgr_name, clg_name FROM tblUser INNER JOIN tblMajor ON tblUser.usr_mgr_id = tblMajor.mgr_id INNER JOIN tblCollege ON tblMajor.mgr_clg_id = tblCollege.clg_id WHERE mgr_id = $MajorId";

		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
			$Title = True; //variable to make sure we show the title once.
			while($row = mysqli_fetch_assoc( $result)) {
			if ($Title) { echo "<h3>".$row['mgr_name']."</h3>".$row['clg_name']."<br><br>"; $Title = False;}
			echo "
			<div class='user-link'>
				<a href='javascript:void(0)' onClick='showProfile(".$row['usr_id'].")'>".$row['usr_fname']." ".$row['usr_lname']."</a>
				<br>
			</div>
			";
		}
		} else { echo "no users found with this major";/*no users found*/ }
		} else {echo 'error';}
	}
?>