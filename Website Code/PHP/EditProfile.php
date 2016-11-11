<div class="row">
    <div class="small-12 columns" style="padding-right:0">
        <h1 id="page-name">Edit Profile Page</h1>
    </div>
</div>
<?php
	include_once 'functions.php';
	$con = Open();
	$query = "SELECT usr_fname, usr_lname, usr_picture, usr_graduate, usr_mgr_id, usr_phone, usr_email, usr_linkedin, mgr_name FROM tblUser LEFT JOIN tblMajor ON tblUser.usr_mgr_id = tblMajor.mgr_id WHERE usr_id = ".getUID();
	if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){ while($row = mysqli_fetch_assoc( $result)) {
echo "
<div id='accordion'>
	<h3>Basic Information</h3>
		<div>
			<h5>Change Legal Name</h5>
			
			<div id='editprofilenames'>
				First name: <input type='text'  value=".$row['usr_fname']." maxlength='20';><br>
				Last name: <input type='text' name='LastName' value=".$row['usr_lname']." maxlength='20'>
			</div>
			<row>
				<a class='ProfilePic' >
					<img class='userPic Left' src='".$row['usr_picture']."' alt='No Profile Picture'>
				</a>
			</row>
		</div>
	<h3>Login Information</h3>
		<div>
			<div id='editpassword'>
				<input type='password' name='password' value='********'>
			</div>
			<div id='editemail'>
        		Email: <input type='text' name='Email' value=".$row['usr_email']." maxlength='30'><br>
      		</div>
		</div>		
	<h3>Academic Status</h3>
		<div>
			Major: ".$row['mgr_name']."
			<h5>Change Major</h5>
    			<div id='editmajor'>
      				<select name='slt_major' id='slt_major'>";		
						$con2 = open();
						$query2 = "SELECT mgr_clg_id, mgr_name FROM tblMajor";
						if ($result2 = mysqli_query($con2, $query2)){if (mysqli_num_rows($result2) > 0 ) { while($row2 = mysqli_fetch_assoc($result2)){
						  echo "<option value=".$row2['mgr_clg_id'].">".$row2['mgr_name']."</option>";
						}
						} else { /*no results found */ }
						} else { echo 'error';}
						mysqli_close($con2);
echo "				</select>
				</div>
			<div id='editstatus'>
      	  		<input type='radio' name='academicstatus>' value='0'>Undergraduate<br>
		    	<input type='radio' name='academicstatus>' value='1'>Graduate<br>
			</div>

		</div>
	<h3>Contact Informatiopn</h3>
		<div>
			<div id='Phone'>
				Phone Number: <input type='text' name='PhoneNumber' value=".$row['usr_phone']." maxlength='10'><br>
			</div>
			<div id='editlinkedin'>
				LinkedIn: <input type='text' name='linkedin' value=".$row['usr_linkedin']."><br>
			</div>
		</div>
</div>
";
echo "";
		
	}} 
	else 
	{ /* no results found */ 
		echo "<p class='warrning'>You must be logged in to do the action requested.</p>";
	}}
	else 
	{ /* error */ 
		echo "<p class='error'>There was a problem processing the request. Please try again.</p>";
	}
	mysqli_close($con);
?>
<br><input class="button" type="button" value="Submit" onClick="ProcessProfileChanges()">
<img src="http://www.w3schools.com/jsref/w3javascript.gif" onload="ProfileEditLoaded()" width="0" height="0">
