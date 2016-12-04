<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Page: Edit Colleges and Majors</title>
<link rel="stylesheet" type="text/css" href="/../foundation2.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<?php include_once 'Functions.php'; PageTitle("Alter College and Majors");?>
</head>

<body>
<div id="accordion">
  <h4>Add</h4><!------------------------------------------------------------------>
  <div>
    <h5>College:</h5>
    <input type="text" id="txt_addcollege" value="Add College Here" maxlength="50";>
	<button class="accordianbtns" onclick="GoToPage('AlterCollegeMajor','AddCollege', $('#txt_addcollege').val(),'')">Add College</button>
<?php
  include_once 'Functions.php';

  if (isset ($_POST['Action']) && isset ($_POST['value'])){
    $con = open();
    $Action  = mysqli_real_escape_string($con,trim(strip_tags($_POST['Action'])));
    $Value  = mysqli_real_escape_string($con,trim(strip_tags($_POST['value'])));
    if ($Action=="AddCollege") {
    $query = "INSERT INTO tblCollege (clg_name) VALUES ('$Value')";
    if (mysqli_query($con, $query)){
      	echo "<p class='alert-box success'>College added successfully.</p>";
    } else {echo 'error';}
mysqli_close($con);
    }
    elseif ($Action=="EditCollege") {
    $Optional  = mysqli_real_escape_string($con,trim(strip_tags($_POST['Optional'])));

          # code...
    }
  }

 ?>
    <h5>Major:</h5>
   <input type="text"  value="Add Major Here" maxlength="50";>
	<button class="accordianbtns">Add Major</button>

  </div>
  <h4>Edit</h4><!------------------------------------------------------------------>
  <div>
    <h5>College:</h5>
    <select id ="slt_college1">
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
   <input type="text"  id="txt_EditMajor" value="Edit College Here" maxlength="50";>
	<button class="accordianbtns" onclick="GoToPage('AlterCollegeMajor', 'EditMajor', $('#txt_EditMajor').val(), $('#slt_college1 option:selected').val())">Edit College</button>
    <h5>Major:</h5>
    <select id ="slt_major" name="slt_major" >
						<?php
										include_once 'Database.php';
										$con = open();
										$query = "SELECT mgr_id, mgr_name FROM tblMajor ";
										if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
										while($row = mysqli_fetch_assoc( $result)) {
												echo "<option value=".$row['mgr_id'].">".$row['mgr_name']."</option>";
										}
										} else { /*no results found*/ }
										} else {echo 'error';}
							mysqli_close($con);
								?>
   </select>
   <input type="text"  value="Edit Major Here" maxlength="50";>
	<button class="accordianbtns">Edit Major</button>
  </div>
  <h4>Delete</h4><!------------------------------------------------------------------>
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
    <select id ="slt_major" name="slt_major" >
						<?php
										include_once 'Database.php';
										$con = open();
										$query = "SELECT mgr_id, mgr_name FROM tblMajor ";
										if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
										while($row = mysqli_fetch_assoc( $result)) {
												echo "<option value=".$row['mgr_id'].">".$row['mgr_name']."</option>";
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
