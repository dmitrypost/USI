<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Project Document</title>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../CSS/foundation2.css">
</head>
	<body>
		<div class="row">
        <div class="small-12 columns" style="padding-right:0">
            <h1 id="page-name">Edit Project Page</h1>
        </div>
    </div>
		<div>
			<h5>Title:</h5>
				<div id=editprojecttitle><input type="text"  value="Project Title";>
			</div>
			<h5>Image</h5>
			<div id=editprojectimage><input class="button" type="button" value="Change" onClick="ProcessImageChanges()">
			      <img src="http://www.w3schools.com/jsref/w3javascript.gif" onload="ImageChangesLoaded()" width="0" height="0"><br>
			</div>
			<h5>Description:</h5>
			<div id=editprojectdesc><input type="text"  value="A short description that is attached to the home page when you're project is featured." maxlength="200";>
			</div>
			<h5>Body:</h5>
			<div id=editprojectbody><input type="text"
				value="A more detailed summary of your project. Explain the idea, method, and impacts.";>
			</div>
			<h5>Year:</h5>
			<div id=editprojectyear><input type="text"  value="****" maxlength="4";>
			</div>
			<h5>Change College</h5>
				<div id=editprojectcollege>
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

			<h5>Change Participants:</h5>
			<div id=editprojectparticipants><input type="text" value="John Doe";>
			</div>
			<h5>Upload Files</h5>
			<div id=editprojectupload>
			</div>
		</div>

		<br><input class="button" type="button" value="Submit" onClick="ProcessProjectChanges()">
      <img src="http://www.w3schools.com/jsref/w3javascript.gif" onload="ProjectChangesLoaded()" width="0" height="0">

	</body>
</html>
