<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Page: Edit Colleges and Majors</title>
<link rel="stylesheet" type="text/css" href="../CSS/foundation2.css">
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
    <style>
	.question{
padding:10px;
background-color: #98d4c6; 
color:black;
text-align:center;
font-size:20px;
border-bottom:black ridge;
border-width:1px;
}
.answer{
background-color:#f2f2f2;
padding:10px;
text-align:left;
font-size: 25px;
border-bottom:black ridge;
border-width:1px;
}

#dropDownFAQs{
	float:left;
	width:100%;
	text-align:center;
	position:relative;
	top:-15px;
}
#dropDownFAQs h3{
	position:relative;
	top:15px;
	color:red;
}
/* .changeCollege{
	
	float:left;
	border-style:solid;
	border-color:red;
}
.changeMajor{
	
	float:left;
	border-style:solid;
	border-color:red;
} */
	</style>
</head>

<body>
<section id ="dropDownFAQs">
<h3>Title</h3>

<div class="question"  onclick="toggle_visibility('one');">
<p>Add</p>
</div>
<div class ="answer" id ="one" hidden>
	<div class = "changeCollege">
	<input type="text"  value="Add College" maxlength="200";>
	<button>Add College</button>
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
	<button>Add Major</button>
	</div>
</div>


<div class="question" onclick="toggle_visibility('two');">
<p>Edit</p>
</div>
<div class ="answer" hidden id ="two">
	<div>
	drop down
	<input type="text"  value="Edit College" maxlength="200";>
	<button>Edit College</button>
	</div>
	<div>
	drop down
	<input type="text"  value="Edit Major" maxlength="200";>
	<button>Edit Major</button>
	</div>
</div>
<div class="question" onclick="toggle_visibility('three');">
<p>Delete</p>
</div>
<div class ="answer" hidden id="three">
	<div>
	drop down
	<button>Delete College</button>
	</div>
	<div>
	drop down
	<button>Delete Major</button>
	</div>
</div>
</section>
</body>
</html>