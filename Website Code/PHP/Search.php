<h3>search </h3>
<div>
<?php

	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
		include_once 'Database.php';
		$con = Open();		
		if (!isset($_POST['s'])) { $Search = "Test"; }
		else{ $Search = mysqli_real_escape_string($con,trim(strip_tags($_POST['s']))); echo $_POST['s'];}
		$ResultCount = 0; //change if results come up
			

//USERS
	//query to check for user's
		$query = "SELECT usr_id, usr_fname, usr_lname FROM tblUser WHERE (usr_fname LIKE '%$Search%' OR usr_lname LIKE '%$Search%')";
		//link to user's profile
		//echo $query;
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
			echo "<h4>Users</h4>";
			while($row = mysqli_fetch_assoc( $result)) {
			$ResultCount = $ResultCount + 1;
			echo "
			<div class='user-link'>
				<a href='javascript:void(0)' onClick='showProfile(".$row['usr_id'].")'>".$row['usr_fname']." ".$row['usr_lname']."</a>
				<br>
			</div>
			";
			
		}
		} else { /*no users found*/ }
		} else {echo 'error';}
		
	
//PROJECTS
	//PROJECTS BY NAME
		$NoProjects = true;
		//query to check for projects
		$query = "SELECT pjt_id, pjt_name, pjt_description FROM tblProject WHERE pjt_name LIKE '%$Search%'";
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
			echo "<h4>Projects</h4>"; $NoProjects = false;
			while($row = mysqli_fetch_assoc( $result)) {
			$ResultCount = $ResultCount + 1;
			echo "
			<div class='project-link'>
				<a href='javascript:void(0)' onClick='showProject(".$row['pjt_id'].")'>".$row['pjt_name']."</a>
				<br>
			</div>
			";
		}
		} else { /*no projects found*/ }
		} else {echo 'error';}
	
	//PROJECTS BY DESCRIPTION
		;echo "<div>";
		$query = "SELECT pjt_id, pjt_name, pjt_description FROM tblProject WHERE pjt_description LIKE '%$Search%'";
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
			if ($NoProjects) {echo "<h4>Projects</h4>"; } $NoProjects = false;
			while($row = mysqli_fetch_assoc( $result)) {
			$ResultCount = $ResultCount + 1;
			echo "
			<div class='project-link'>
				<a href='javascript:void(0)' onClick='showProject(".$row['pjt_id'].")'>".$row['pjt_name']."</a>
				<br>
			</div>
			";
		}
		} else { /*no projects found*/ }
		} else {echo 'error';}
		
		echo "<div>";
	//PROJECTS BY KEYWORD
		$query = "SELECT pjt_id FROM tblProject INNER JOIN tblKeywordAssociation ON tblProject.pjt_key_id = tblKeywordAssociation.key_id INNER JOIN tblKeyword ON tblKeywordAssociation.key_kwd_id = tblKeyword.kwd_id WHERE kwd_name LIKE '%$Search%'";
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
			if ($NoProjects) {echo "<h4>Projects</h4>"; } $NoProjects = false;
			while($row = mysqli_fetch_assoc( $result)) {
			$ResultCount = $ResultCount + 1;
			echo "
			<div class='project-link'>
				<a href='javascript:void(0)' onClick='showProject(".$row['pjt_id'].")'>".$row['pjt_name']."</a>
				<br>
			</div>
			";
		}
		} else { /*no projects found*/ }
		} else {echo 'error';}
		//link to project's page
		
//COLLEGES
	//COLLEGES BY NAME
		$NoColleges = true;
		//query to check for college
		$query = "SELECT clg_id, clg_name FROM tblCollege WHERE clg_name LIKE '%$Search%'";
		echo "<div>";
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
			if ($NoColleges) {echo "<h4>Colleges</h4>"; } $NoColleges = false;
			while($row = mysqli_fetch_assoc( $result)) {
			$ResultCount = $ResultCount + 1;
			echo "
			<div class='college-link'>
				<a href='javascript:void(0)' onClick='showCollege(".$row['clg_id'].")'>".$row['clg_name']."</a>
				<br>
			</div>
			";
		}
		} else { /*no colleges found*/ }
		} else {echo 'error';}
		
		echo "<div>";
	//COLLEGES BY KEYWORD
		$query = "SELECT clg_id FROM tblCollege INNER JOIN tblKeywordAssociation ON tblCollege.clg_key_id = tblKeywordAssociation.key_id INNER JOIN tblKeyword ON tblKeywordAssociation.key_kwd_id = tblKeyword.kwd_id WHERE kwd_name LIKE '%$Search%'";
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
			if ($NoColleges) {echo "<h4>Colleges</h4>"; } $NoColleges = false;
			while($row = mysqli_fetch_assoc( $result)) {
			$ResultCount = $ResultCount + 1;
			echo "
			<div class='college-link'>
				<a href='javascript:void(0)' onClick='showCollege(".$row['clg_id'].")'>".$row['clg_name']."</a>
				<br>
			</div>
			";
		}
		} else { /*no colleges found*/ }
		} else {echo 'error';}
		//go to colleges.php
	
//MAJORS
	//MAJORS BY NAME
		$NoMajors = true;
		$query = "SELECT mgr_id FROM tblMajor WHERE mgr_name LIKE '%$Search%'";
		echo "<div>";
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
			if ($NoMajors) {echo "<h4>Majors</h4>"; } $NoMajors = false;
			while($row = mysqli_fetch_assoc( $result)) {
			$ResultCount = $ResultCount + 1;
			echo "
			<div class='major-link'>
				<a href='javascript:void(0)' onClick='showMajor(".$row['mgr_id'].")'>".$row['mgr_name']."</a>
				<br>
			</div>
			";
		}
		} else { /*no colleges found*/ }
		} else {echo 'error';}
	
	//MAJORS BY KEYWORD
		$query = "SELECT mgr_id FROM tblMajor INNER JOIN tblKeywordAssociation ON tblMajor.mgr_key_id = tblKeywordAssociation.key_id INNER JOIN tblKeyword ON tblKeywordAssociation.key_kwd_id = tblKeyword.kwd_id WHERE kwd_name LIKE '%$Search%'";
		echo "<div>";
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
			if ($NoMajors) {echo "<h4>Majors</h4>"; } $NoMajors = false;
			while($row = mysqli_fetch_assoc( $result)) {
			$ResultCount = $ResultCount + 1;
			echo "
			<div class='major-link'>
				<a href='javascript:void(0)' onClick='showMajor(".$row['mgr_id'].")'>".$row['mgr_name']."</a>
				<br>
			</div>
			";
		}
		} else { /*no colleges found*/ }
		} else {echo 'error';}
		//go to majors.php
	
//No results 
		if ($ResultCount == 0){
			echo '<h7>No Results Found</7>';	
		}elseif($ResultCount == 1){
			echo "<h7>".$ResultCount." Result Found</h7>";
		}else{
			echo "<h7>".$ResultCount." Results Found</h7>";
		}
		
		mysqli_close($con);
	}
?>