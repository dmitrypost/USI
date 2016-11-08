<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    { 
		/*
		foreach ($_POST as $key => $val) {
		 	echo '<p>'.$key.'</p>';
		} */
		
		include_once '/../Functions.php';
		
		$con = Open(); $pageview = 0;
		if (!isset($_POST['pid'])) { $projectID = 1; } else{ $projectID = mysqli_real_escape_string($con,trim(strip_tags($_POST['pid']))); }
		$query = "SELECT usr_id, usr_picture, usr_fname, usr_lname, rol_name FROM tblUser INNER JOIN tblRole ON tblUser.usr_id = tblRole.rol_usr_id WHERE rol_pjt_id =".$projectID;
		
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){ while($row = mysqli_fetch_assoc( $result)) {
			echo "
			<a onClick='showProfile(".$row['usr_id'].")'>
				<img class='userPic' src='".$row['usr_picture']."' alt='No Profile Picture'>
				<div>".$row['usr_fname']." ".$row['usr_lname']."</div>
				<div>".$row['rol_name']."</div>			
			</a>
			";
		}	} else { 
		/*no results found*/
			echo "No participants found for this project";
		}	} else {echo 'error';}
	
	mysqli_close($con);
		
	}
?>