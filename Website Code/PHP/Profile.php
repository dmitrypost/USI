<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>User Profile Document</title>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://www.usi.edu/f4/css/foundation.css">
    <link rel="stylesheet" type="text/css" href="../CSS/foundation2.css">
</head>
<body>
<?php
    include_once 'Database.php'; include_once 'Functions.php';
	$con = Open();
	//set uid to 2 for testing purposes if a uid is not posted to the page (only possible in testing)
	if (!isset($_POST['uid'])) { $uid = 2; }
	else{ $uid = mysqli_real_escape_string($con,trim(strip_tags($_POST['uid']))); }
	//query
	$query = "SELECT usr_fname , usr_lname, usr_email, usr_picture, mgr_name, usr_graduate, usr_pageview, usr_phone, usr_linkedin, usr_id FROM tblUser LEFT JOIN tblMajor ON tblUser.usr_mgr_id = tblMajor.mgr_id WHERE usr_id =".$uid;
	//echo $query;
	if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){while($row = mysqli_fetch_assoc( $result)) {
	//user info found
	echo '<div class="row"><div class="small-12 columns" style="padding-right:0">';
		//name heading
    echo "<h1 id='page-name'>".$row['usr_fname']." ".$row['usr_lname']."</h1></div></div>";
		//picture
	if (!($row['usr_picture'] == ""))
	{ $profilePic = $NoProfilePictureImage;	} else { $profilePic = $row['usr_picture']; }
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
				<h6>Major: ".$major."</h6>
				".$grad." student
				<br>Contact: <a href='tel:".$row['usr_phone']."' title='call number'>".$row['usr_phone']."</a>
				<br>Email: <a href='mailto:".$row['usr_email']."' >".$row['usr_email']."</a>
				<br>LinkedIn: <a href='".$row['usr_linkedin']."' >".$row['usr_linkedin']."</a>
			</div>
		</div>
		<br>
		<div class='row'>
	";
	$query2 = "SELECT rol_name, pjt_name, pjt_description, clg_name, usr_id , pjt_year, pjt_id FROM tbluser INNER JOIN tblrole ON tbluser.usr_id = tblrole.rol_usr_id INNER JOIN tblproject ON tblrole.rol_pjt_id = tblproject.pjt_id LEFT JOIN tblcollege ON tblproject.pjt_clg_id = tblcollege.clg_id WHERE usr_id = ". $uid;
	if ($result2 = mysqli_query($con, $query2)){if (mysqli_num_rows($result2) > 0){
		echo "<div class='center'>Projects ".$row['usr_fname']." participated in</div><br>";
		while($row2 = mysqli_fetch_assoc( $result2)) {
		echo "
		<div class='project-preview'>
			<h5><a href='javascript:void(0)' onClick='showProject(".$row2['pjt_id'].")'>".$row2['pjt_name']."</a> - ".$row2['rol_name']."</h5> 
			<br>".$row2['pjt_description']."
			<br>".$row2['pjt_year']."
			<br>
		</div>
		";
	}
	} else {echo 'no projects found for this user';}
	} else {echo 'error';}
	
	
	
	
	echo "
		</div>
	</div>
	<div class='bottom'>pageviews for this user: ".$row['usr_pageview']."</div>
	<div>URL:<a>localhost/?uid=".$row['usr_id']."</a></div>";
	//increment pageview
	QuickQuery("UPDATE tblUser SET usr_pageview = usr_pageview +1 WHERE usr_id=".$uid);
	}
	} else {echo 'no user found with that id';}
	} else {echo 'error';}
	
	
	mysqli_close($con);
?>
</body>
</html>