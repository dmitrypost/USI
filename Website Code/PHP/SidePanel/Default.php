<?php
ini_set('display_errors', 1);
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		echo "College:<select id='sp_slt_college' onChange='UpdateSPMajorList(this.value)' style='width:100%'>";
	
        include_once './PHP/Functions.php';
        $con = open(); 
		if (!isset($_POST['value'])) { $collegeId = "0"; } else{ $collegeId = mysqli_real_escape_string($con,trim(strip_tags($_POST['value'])));}
        $query = "SELECT clg_id, clg_name FROM tblcollege ";
        if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc( $result)) {
			if ($row['clg_id'] == $collegeId)
			{
				echo "<option value=".$row['clg_id']." selected>".$row['clg_name']."</option>";
			}
			else
			{
            	echo "<option value=".$row['clg_id'].">".$row['clg_name']."</option>";
			}
        }
        } else { /*no results found*/ }
        } else {echo 'error'.$query;}
        mysqli_close($con);
  
		echo "</select>";
		
		/* When the option is changed and makes the dropdown retrieve the majors in college */
		include_once './PHP/Functions.php';
		$con = open(); //if (!isset($_POST['cid'])) { $collegeId = "1"; } else{ $collegeId = mysqli_real_escape_string($con,trim(strip_tags($_POST['cid'])));}
		$query= "SELECT mgr_id, mgr_name FROM tblmajor WHERE mgr_clg_id =$collegeId";
		
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){ while($row = mysqli_fetch_assoc( $result)) {
			echo "
			<div class='major-link'>
				<a href='javascript:void(0)' onClick='GoToPage(\"Major\",\"\",".$row['mgr_id'].",\"\")'>".$row['mgr_name']."</a>
				<br>
			</div>
			";
		}
		} else { /*no results found*/ }	} else {echo 'error';}
		mysqli_close($con);
	}
	
?>