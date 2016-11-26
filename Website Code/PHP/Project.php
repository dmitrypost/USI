<?php
	include_once 'Functions.php';
	/*
		foreach ($_POST as $key => $val) {
		  echo '<p>'.$key.':'.$_POST[$key].'</p>';
	}*/
	$con = open();
	if (isset($_POST['value'])) {
		 $projectID = mysqli_real_escape_string($con,trim(strip_tags($_POST['value']))); 
		$query = "SELECT pjt_id, pjt_picture, pjt_name, pjt_body, pjt_description, pjt_pageview, pjt_year, mgr_name, pjt_pageview FROM tblProject INNER JOIN tblmajor ON tblProject.pjt_mgr_id = tblmajor.mgr_id WHERE pjt_id =".$projectID;
			
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
			<div class='view-count'>Project views: $pageview</div>
			";
			mysqli_close($con);
			QuickQuery("UPDATE tblProject SET pjt_pageview = pjt_pageview +1 WHERE pjt_id=".$projectID."");
			

		 } else { mysqli_close($con); exit; }
	
	
?>
 