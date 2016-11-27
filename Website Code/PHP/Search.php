<?php

	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
		include_once 'Functions.php';
		PageTitle("Search");
		$con = Open();		
		if (!isset($_POST['s'])) { $Search = "Test"; }
		else
		{
			 $Search = mysqli_real_escape_string($con,trim(strip_tags($_POST['s']))); 
			 echo "<h5>Search term: ".$_POST['s']."</h5>";
		}
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
			FormattedUserLink($row['usr_id'],$row['usr_fname']." ".$row['usr_lname']);			
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
			FormattedProjectLink($row['pjt_id'],$row['pjt_name']);
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
			FormattedProjectLink($row['pjt_id'],$row['pjt_name']);
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
			FormattedProjectLink($row['pjt_id'],$row['pjt_name']);
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
			FormattedCollegeLink($row['clg_id'],$row['clg_name']);
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
			FormattedCollegeLink($row['clg_id'],$row['clg_name']);
		}
		} else { /*no colleges found*/ }
		} else {echo 'error';}
		//go to colleges.php
	
//MAJORS
	//MAJORS BY NAME
		$NoMajors = true;
		$query = "SELECT mgr_id, mgr_name FROM tblMajor WHERE mgr_name LIKE '%$Search%'";
		echo "<div>";
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
			if ($NoMajors) {echo "<h4>Majors</h4>"; } $NoMajors = false;
			while($row = mysqli_fetch_assoc( $result)) {
			$ResultCount = $ResultCount + 1;
			FormattedMajorLink($row['mgr_id'],$row['mgr_name']);
		}
		} else { /*no colleges found*/ }
		} else {echo 'error';}
	
	//MAJORS BY KEYWORD
		$query = "SELECT mgr_id, mgr_name FROM tblMajor INNER JOIN tblKeywordAssociation ON tblMajor.mgr_key_id = tblKeywordAssociation.key_id INNER JOIN tblKeyword ON tblKeywordAssociation.key_kwd_id = tblKeyword.kwd_id WHERE kwd_name LIKE '%$Search%'";
		echo "<div>";
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
			if ($NoMajors) {echo "<h4>Majors</h4>"; } $NoMajors = false;
			while($row = mysqli_fetch_assoc( $result)) {
			$ResultCount = $ResultCount + 1;
			FormattedMajorLink($row['mgr_id'],$row['mgr_name']);
		}
		} else { /*no colleges found*/ }
		} else {echo 'error';}
		//go to majors.php
	
//No results 
		if ($ResultCount == 0){
			echo "<div class='view-count'>No Results Found</div>";	
		}elseif($ResultCount == 1){
			echo "<div class='view-count'>$ResultCount Result Found</div>";
		}else{
			echo "<div class='view-count'>$ResultCount Results Found</div>";
		}
		
		mysqli_close($con);
	}
?>