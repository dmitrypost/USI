<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Page: Edit Colleges and Majors</title>
<link rel="stylesheet" type="text/css" href="/../foundation2.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
</head>

<body>
<div id="accordion">
  <h3>Add</h3><!------------------------------------------------------------------>
  <div>
    <h5>College:</h5>
    <input type="text"  value="Add College Here" maxlength="50";>
	<button class="accordianbtns">Add College</button>
    
    <h5>Major:</h5>
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
   </select>
   <input type="text"  value="Add Major Here" maxlength="50";>
	<button class="accordianbtns">Add Major</button>
  </div>
  <h3>Edit</h3><!------------------------------------------------------------------>
  <div>
    <h5>College:</h5>
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
   </select>
   <input type="text"  value="Edit Major Here" maxlength="50";>
	<button class="accordianbtns">Edit College</button>
    <h5>Major:</h5>
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
   </select>
   <input type="text"  value="Edit Major Here" maxlength="50";>
	<button class="accordianbtns">Edit Major</button>
  </div>
  <h3>Delete</h3><!------------------------------------------------------------------>
  <div>
    <h5>College:</h5>
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
   </select>
	<button class="accordianbtns">Delete College</button>
    <h5>Major:</h5>
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
   </select>
	<button class="accordianbtns">Delete Major</button>
  </div>
</div>
</section>
<img src="http://www.w3schools.com/jsref/w3javascript.gif" onload="AlterCollegeMajorLoaded()" width="0" height="0">
</body>
</html>