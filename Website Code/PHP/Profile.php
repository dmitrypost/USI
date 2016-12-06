
<?php
    include_once 'Database.php'; include_once 'Functions.php';
	$con = Open();
	//set uid to 2 for testing purposes if a uid is not posted to the page (only possible in testing)
	if (!isset($_POST['value'])) { $uid = 2; }
	else{ $uid = mysqli_real_escape_string($con,trim(strip_tags($_POST['value']))); }
	//query
	$query = "SELECT usr_fname , usr_lname, usr_email, usr_picture, mgr_name, usr_graduate, usr_pageview, usr_phone, usr_linkedin, usr_id FROM tbluser LEFT JOIN tblmajor ON tbluser.usr_mgr_id = tblmajor.mgr_id WHERE usr_id =".$uid;
	//echo $query;
	if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){while($row = mysqli_fetch_assoc( $result)) {
	//user info found
	echo '<div class="row"><div class="small-12 columns" style="padding-right:0">';
		//name heading
    echo "<h1 id='page-name'>".$row['usr_fname']." ".$row['usr_lname']."</h1></div></div>";
		//picture
	if (!strlen($row['usr_picture']) > 0)
	{ $profilePic = $NoProfilePictureImage; } else { $profilePic = $row['usr_picture']; }
		//major
	if (!($row['mgr_name']))
	{ $major = "Major Not Set"; } else { $major = $row['mgr_name']; }
		//graduate
	if (($row['usr_graduate']))
	{ $grad = "Graduate"; } else { $grad = "Undergraduate"; }
		//
	echo "
	<div class='stafflist'>
		<div class='row'>
			<div class='small-2 large-2 columns'>
				<img src='".$profilePic."' alt='".$NoProfilePictureImage."'>
			</div>
			<div class='small-12 large-5 columns info left'>
				<b>Major:</b> ".$major."
				<br><b>Academic Status:</b> ".$grad."
				<br><b>Contact:</b> <a href='tel:".FormatPhoneNumber($row['usr_phone'])."' title='call number'>".FormatPhoneNumber($row['usr_phone'])."</a>
				<br><b>Email:</b> <a href='mailto:".$row['usr_email']."' >".$row['usr_email']."</a>
				<br><b>LinkedIn:</b> <a href='".$row['usr_linkedin']."' >".$row['usr_linkedin']."</a>
			</div>
		</div>
		<br>
		<div class='row'>
		<hr>
	";
	$query2 = "SELECT rol_name, pjt_name, pjt_description, mgr_name, usr_id , pjt_year, pjt_id FROM tbluser INNER JOIN tblrole ON tbluser.usr_id = tblrole.rol_usr_id INNER JOIN tblproject ON tblrole.rol_pjt_id = tblproject.pjt_id LEFT JOIN tblmajor ON tblproject.pjt_mgr_id = tblmajor.mgr_id WHERE usr_id = $uid AND pjt_description != 'pending'";
	if ($result2 = mysqli_query($con, $query2)){if (mysqli_num_rows($result2) > 0){
		echo "<div class='center'><h4>Projects ".$row['usr_fname']." has participated in:</h4></div>";
		while($row2 = mysqli_fetch_assoc( $result2)) {
		echo "
		<div class='project-preview'>
			<h5><a href='javascript:void(0)' onClick='GoToPage(\"Project\",\"\",".$row2['pjt_id'].",\"\")'>".$row2['pjt_name']."</a> - ".$row2['rol_name']."</h5>
			".$row2['pjt_description']."
			<br><h6>Year: ".$row2['pjt_year']."</h6>
			<br>
		</div>
		";
	}
	} 
	} else {echo 'error';}
	$pageViews = ($row['usr_pageview'] == "") ?  0 : $row['usr_pageview']; 
	echo "
		</div>
	</div>
	<div class='view-count'>Profile views: $pageViews</div>
	";
	//increment pageview
	QuickQuery("UPDATE tbluser SET usr_pageview = $pageViews +1 WHERE usr_id=".$uid);
	}
	} else {echo 'no user found with that id';}
	} else {echo 'error';}


	mysqli_close($con);
?>
</body>
</html>
