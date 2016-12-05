<?php
	include_once 'Functions.php';
	PageTitle("Alter College & Majors");
	//creates the options inside the html select control
	function CollegeSelectsHTML($SelectedId)
	{
		$html = "";
		$con = open();
		$query = "SELECT clg_id, clg_name FROM tblCollege ";
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc( $result)) {
			if ($SelectedId = $row['clg_id'])
			{
				$html .= "<option value=".$row['clg_id']." selected>".$row['clg_name']."</option>";
			}
			else
			{
				$html .= "<option value=".$row['clg_id'].">".$row['clg_name']."</option>";
			}
		}}} 
		mysqli_close($con);
		return $html;
	}
	//creates the options inside the html select control 
	function MajorSelectsHTML($SelectedId)
	{
		$html = "";
		$con = open();
		$query = "SELECT mgr_id, mgr_name FROM tblMajor ";
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc( $result)) {
			if ($SelectedId = $row['mgr_id'])
			{
				$html .= "<option value=".$row['mgr_id']." selected>".$row['mgr_name']."</option>";
			}
			else
			{
				$html .= "<option value=".$row['mgr_id'].">".$row['mgr_name']."</option>";
			}
		}}} 
		mysqli_close($con);
		return $html;
	}
	//creates the html for the page
	function PageHTML()
	{
		return "
		<div id='accordion'>
		  <h3>Colleges</h3>
		  <div>
				<h6>Add New College</h6>
					<input type='text' id='txt_newcollege' value='New college name here' maxlength='30' class='w300'>
					<button onclick='GoToPage(\"AlterCollegeMajor\",\"AddCollege\", $(\"#txt_newcollege\").val(),\"\")'>Add</button>
					<hr>
				<h6>Edit Existing College</h6>
					<select id='slt_editcollege'>
						".CollegeSelectsHTML(0)."
					</select>
					<input type='text' id='txt_editcollege' value='Updated college name here' maxlength='30' class='w300'>
					<button onclick='GoToPage(\"AlterCollegeMajor\",\"EditCollege\", $(\"#slt_editcollege\").val(),$(\"#txt_newcollege\").val())'>Update</button>
					<hr>
				<h6>Remove Existing College</h6>
					<select id='slt_removecollege'>
						".CollegeSelectsHTML(0)."
					</select><br>
					<button onclick='GoToPage(\"AlterCollegeMajor\",\"RemoveCollege\", $(\"#slt_removecollege\").val(),\"\")'>Remove</button>				
		  </div>
		  <h3>Majors</h3>
		  <div>
				<h6>Add New Major</h6>
					<select id='slt_college_newmajor'>
						".CollegeSelectsHTML(0)."
					</select>
					<input type='text' id='txt_newmajor' value='New major name here' maxlength='30' class='w300'>
					<button onclick='GoToPage(\"AlterCollegeMajor\",\"AddMajor\", $(\"#slt_college_newmajor\").val(),$(\"#txt_newmajor\").val())'>Add</button>
					<hr>
				<h6>Edit Existing Major</h6>
					<select id='slt_editmajor'>
						".MajorSelectsHTML(0)."
					</select>
					<input type='text' id='txt_editmajor' value='Updated major name here' maxlength='30' class='w300'>
					<button onclick='GoToPage(\"AlterCollegeMajor\",\"EditMajor\", $(\"#slt_editmajor\").val(),$(\"#txt_editmajor\").val())'>Update</button>
					<hr>
				<h6>Remove Existing Major</h6>
					<select id='slt_removemajor'>
						".MajorSelectsHTML(0)."
					</select><br>
					<button onclick='GoToPage(\"AlterCollegeMajor\",\"RemoveMajor\", $(\"#slt_removemajor\").val(),\"\")'>Remove</button>				
		  </div>
		</div>
		";	
	}
	// process the actions passed
	if (isset ($_POST['Action']) && isset ($_POST['value']))
	{
		$con = open();
		$Action  = mysqli_real_escape_string($con,trim(strip_tags($_POST['Action'])));
		$Value  = mysqli_real_escape_string($con,trim(strip_tags($_POST['value'])));
		switch ($Action)
		{
			case 'AddCollege':
				$query = "INSERT INTO tblCollege (clg_name) VALUES ('$Value')";
				echo (QuickQuery($query)) ? "<p class='alert-box success'>College added successfully.</p>" : "<p class='alert-box error'>College failed to be added.</p>";
				break;
			case 'EditCollege':
				if (!isset($_POST['optional'])) { echo "<p class='alert-box error'>Wrong number of arguments passed!</p>"; break; }
				$Optional  = mysqli_real_escape_string($con,trim(strip_tags($_POST['optional'])));
				$query = "UPDATE tblCollege SET clg_name = '$Optional' WHERE clg_id = '$Value'";
				echo (QuickQuery($query)) ? "<p class='alert-box success'>College updated successfully.</p>" : "<p class='alert-box error'>College failed to be updated.</p>";
				break;
			case 'RemoveCollege':
				$query = "DELETE FROM tblCollege WHERE clg_id = $Value";
				echo (QuickQuery($query)) ? "<p class='alert-box success'>College removed successfully.</p>" : "<p class='alert-box error'>College failed to be removed.</p>";
				break;
			case 'AddMajor':
				if (!isset($_POST['optional'])) { echo "<p class='alert-box error'>Wrong number of arguments passed!</p>"; break; }
				$Optional  = mysqli_real_escape_string($con,trim(strip_tags($_POST['optional'])));
				$query = "INSERT INTO tblMajor (mgr_name) VALUES ('$Value')";
				echo (QuickQuery($query)) ? "<p class='alert-box success'>Major added successfully.</p>" : "<p class='alert-box error'>Major failed to be added.</p>";
				break;
			case 'EditMajor':
				if (!isset($_POST['optional'])) { echo "<p class='alert-box error'>Wrong number of arguments passed!</p>"; break; }
				$Optional  = mysqli_real_escape_string($con,trim(strip_tags($_POST['optional'])));
				$query = "UPDATE tblMajor SET mgr_name = '$Optional' WHERE mgr_id = $Value";
				echo (QuickQuery($query)) ? "<p class='alert-box success'>Major updated successfully.</p>" : "<p class='alert-box error'>Major failed to be updated.</p>";
				break;
			case 'RemoveMajor':
				$query = "DELETE FROM tblMajor WHERE mgr_id = $Value";
				echo (QuickQuery($query)) ? "<p class='alert-box success'>Major removed successfully.</p>" : "<p class='alert-box error'>Major failed to be removed.</p>";
				break;
			default:
				echo "<p class='alert-box error'>Action not recognized!</p>";
				break;
		}
  	}
	echo PageHTML(); //displays the page
?>
<img src="../Images/pixel.png" onload="Accordion()" width="0" height="0">