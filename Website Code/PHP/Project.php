
 <!--this page url is http://localhost/?pid=1-->
<?php
	include_once 'Functions.php';
		
	$con = Open(); $pageview = 0;
	if (!isset($_POST['pid'])) { $projectID = 1; } else{ $projectID = mysqli_real_escape_string($con,trim(strip_tags($_POST['pid']))); }
	$query = "SELECT pjt_id, pjt_picture, pjt_name, pjt_body, pjt_description, pjt_pageview, pjt_year, clg_name, pjt_pageview FROM tblProject INNER JOIN tblcollege ON tblProject.pjt_clg_id = tblcollege.clg_id WHERE pjt_id =".$projectID;
	echo $query;
	if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){ while($row = mysqli_fetch_assoc( $result)) {
		echo "<img src='".$row['pjt_picture']."'>";
		echo "<h1>".$row['pjt_name']."</h1>";
		echo "<div>".$row['pjt_description']."</div>";
		echo "<p>".$row['pjt_body']."<p>";
		echo "<p>".$row['pjt_year']."<p>";
		
		$pageview = $row['pjt_pageview'];
	}	} else { /*no results found*/ }	} else {echo 'error';}
	
	
	echo "<div id='Files'>Project Files</div>";
	$query = "SELECT fle_id, fle_name FROM tblFile WHERE fle_pjt_id = ".$projectID;
	
	if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){ while($row = mysqli_fetch_assoc( $result)) {
		echo "
		<a onClick='DownloadFile(".$row['fle_id'].")'>".$row['fle_name']."</a>";
		echo "<p>".$row['fle_name']."<p>";			
	}	} else { 
	/*no results found*/ 
		echo "No files for this project found";
	}	} else {echo 'error';}
	
	
	
	echo "<p>
	<p>Project views: $pageview
	";
	mysqli_close($con);
	QuickQuery("UPDATE tblProject SET pjt_pageview = pjt_pageview +1 WHERE pjt_id=".$projectID."");
?>
 