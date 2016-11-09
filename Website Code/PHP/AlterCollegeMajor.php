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

	
	<!--</div>
	<div class = "changeMajor">
	<div id="editprojectcollege">
					
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
					
	</div>
	<button class="adminbtns">Delete College</button>
	</div>
	<div>
	drop down
	<button class="adminbtns">Delete Major</button>
	</div>
</div>-->

<!---------------------------------------------------------------------->
<div id="accordion">
  <h3>Add</h3>
  <div>
    <p>
    Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
    ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
    amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
    odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
    </p>
    <input type="text"  value="Add College" maxlength="200";>
	<button class="adminbtns">Add College</button>
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
  </div>
  <h3>Edit</h3>
  <div>
    <p>
    Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet
    purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
    velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In
    suscipit faucibus urna.
    </p>
  </div>
  <h3>Delete</h3>
  <div>
    <p>
    Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis.
    Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero
    ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis
    lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.
    </p>
    <ul>
      <li>List item one</li>
      <li>List item two</li>
      <li>List item three</li>
    </ul>
  </div>
</div>
</section>
<img src="http://www.w3schools.com/jsref/w3javascript.gif" onload="AlterCollegeMajorLoaded()" width="0" height="0">
</body>
</html>