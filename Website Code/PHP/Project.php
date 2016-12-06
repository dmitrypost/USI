<?php
	include_once 'Functions.php';
	/*
		foreach ($_POST as $key => $val) {
		  echo '<p>'.$key.':'.$_POST[$key].'</p>';
	}*/
	$con = open();
	if (isset($_POST['value'])) {
		$projectID = mysqli_real_escape_string($con,trim(strip_tags($_POST['value']))); 
		$query = "SELECT pjt_id, pjt_picture, pjt_name, pjt_body, pjt_description, pjt_pageview, pjt_year, mgr_name, pjt_pageview 
			FROM tblproject INNER JOIN tblmajor ON tblproject.pjt_mgr_id = tblmajor.mgr_id 
			WHERE pjt_id =".$projectID;
		$pageview = 0;
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){ while($row = mysqli_fetch_assoc( $result)) {
			echo "<img src='".$row['pjt_picture']."'>";
			echo "<h1>".$row['pjt_name']."</h1>";
			echo "<div>".$row['pjt_description']."</div>";
			echo "<p>".$row['pjt_body']."<p>";
			echo "<p>".$row['pjt_year']."<p>";
			
			$pageview = $row['pjt_pageview'];
		}	} else { /*no results found*/ }	} else {echo 'error';}
		
		$query = "SELECT fle_id, fle_path FROM tblfile WHERE fle_pjt_id = $projectID";
		if ($result = mysqli_query($con, $query))
		{	if (mysqli_num_rows($result) > 0)
			{ 	echo "
				<table width='100%' border='0' cellpadding='2'>
				  <tbody>
					<tr>
					  <th scope='col'>Project Files</th>
					</tr>";
				while($row = mysqli_fetch_assoc( $result)) 
				{
					//echo $row['fle_path']."<br>".GetPath($row['fle_path']).FileNameFromPath(GetPath($row['fle_path']));
					echo "<tr><td><a onClick='FileDownload(".$row['fle_id'].")'>".FileNameFromPath(GetPath($row['fle_path']))."</a></td></tr>";
				}	
				echo "
				  </tbody>
				</table>";
			}	
		} else {echo 'fies error'.$query;}
		if (!is_numeric($pageview)) {$pageview = 0;}
		echo "<p>
		<div class='view-count'>Project views: $pageview</div>
		";
		mysqli_close($con);
		QuickQuery("UPDATE tblproject SET pjt_pageview = $pageview + 1 WHERE pjt_id=".$projectID."");
		

		 } else { mysqli_close($con); exit; }
	
	
?>
 