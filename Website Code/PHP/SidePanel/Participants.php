<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    { 
		/*
		foreach ($_POST as $key => $val) {
		 	echo '<p>'.$key.'</p>';
		} */
		
		include_once '/../Functions.php';
		
		$con = Open();
		if (!isset($_POST['value'])) { $projectID = 1; } else{ $projectID = mysqli_real_escape_string($con,trim(strip_tags($_POST['value']))); }
		$query = "SELECT usr_id, usr_picture, usr_fname, usr_lname, rol_name FROM tblUser INNER JOIN tblRole ON tblUser.usr_id = tblRole.rol_usr_id WHERE rol_pjt_id =".$projectID;
		
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){ while($row = mysqli_fetch_assoc( $result)) {
			echo "<p>
			<row>
			<a class='Participant' >
				<table>
					<tr>
						<td>
							<img class='userPic Left' src='".$row['usr_picture']."' alt='No Profile Picture'>
						</td>
						<td>
							<a onClick='GoToPage(\"Profile\",\"\",".$row['usr_id'].",\"\")'>".$row['usr_fname']." ".$row['usr_lname']."
							<br>".$row['rol_name']."</a>
						</td>
					</tr>
				</table>
			</a>
			</row>
			";
		}	} else { 
		/*no results found*/
			echo "No participants found for this project";
		}	} else {echo 'error';}
	
	mysqli_close($con);
		
	}
?>