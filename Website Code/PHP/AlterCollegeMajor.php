<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Page: Edit Colleges and Majors</title>
<link rel="stylesheet" type="text/css" href="/../foundation2.css">
<script >
	function toggle_visibility(id) {
	"use strict";
       var e = document.getElementById(id);
       if(e.style.display === 'block')
          {
			  e.style.display = 'none';
		  }
       else
          {
			  e.style.display = 'block';
		  }
    }
	</script>
</head>

<body>
<section id ="dropDownFAQs">

<div class="question"  onclick="toggle_visibility('one');">
<p>Add</p>
</div>
<div class ="answer" id ="one" hidden>
	<div class = "changeCollege">
	<input type="text"  value="Add College" maxlength="200";>
	<button class="adminbtns">Add College</button>
	</div>
	<div class = "changeMajor">
	<div id="editprojectcollege">
					<select id ="slt_college" name="slt_college" >
						<?php
										include_once 'Database.php';
										$con = open();
										$query = "SELECT clg_id, clg_name FROM tblCollege ";
										if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
										while($row = mysqli_fetch_assoc( $result)) {
												echo "<option value=".$row['clg_id'].">".$row['clg_name']."</option>";
										}
										} else { /*no results found*/ }
										} else {echo 'error';}
							mysqli_close($con);
								?>
	</div>
	<input type="text"  value="Add Major" maxlength="200";>
	<button class="adminbtns">Add Major</button>
	</div>
</div>


<div class="question" onclick="toggle_visibility('two');">
<p>Edit</p>
</div>
<div class ="answer" hidden id ="two">
	<div>
	<div id="editprojectcollege">
					<select id ="slt_college" name="slt_college" >
						<?php
										include_once 'Database.php';
										$con = open();
										$query = "SELECT clg_id, clg_name FROM tblCollege ";
										if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
										while($row = mysqli_fetch_assoc( $result)) {
												echo "<option value=".$row['clg_id'].">".$row['clg_name']."</option>";
										}
										} else { /*no results found*/ }
										} else {echo 'error';}
							mysqli_close($con);
								?>
	</div>
	<input type="text"  value="Edit College" maxlength="200";>
	<button class="adminbtns">Edit College</button>
	</div>
	<div>
	drop down
	<input type="text"  value="Edit Major" maxlength="200";>
	<button class="adminbtns">Edit Major</button>
	</div>
</div>
<div class="question" onclick="toggle_visibility('three');">
<p>Delete</p>
</div>
<div class ="answer" hidden id="three">
	<div>
	<div id="editprojectcollege">
					<select id ="slt_college" name="slt_college" >
						<?php
										include_once 'Database.php';
										$con = open();
										$query = "SELECT clg_id, clg_name FROM tblCollege ";
										if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
										while($row = mysqli_fetch_assoc( $result)) {
												echo "<option value=".$row['clg_id'].">".$row['clg_name']."</option>";
										}
										} else { /*no results found*/ }
										} else {echo 'error';}
							mysqli_close($con);
								?>
	</div>
	<button class="adminbtns">Delete College</button>
	</div>
	<div>
	drop down
	<button class="adminbtns">Delete Major</button>
	</div>
</div>
</section>
</body>
</html>