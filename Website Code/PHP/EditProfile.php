
<?php
	include_once 'functions.php';
	$con = Open();
	$ProfileId = 0;
	if (isset($_POST['value']))
	{
		$ProfileId = mysqli_real_escape_string($con,trim(strip_tags($_POST['value'])));
		if (!is_numeric($ProfileId))
		{
			$ProfileId = 0;
		}
	} //submitted profile to be edited; only needed if admin is logged in

	if ($ProfileId == 0)
	{ $ProfileId = getUID(); }//if the owner is logged in and doing the edits to their profile

	if (!isLoggedIn() & !isAdmin())
	{
		//access denied
		//neither an admin or the owner of the profile requested this data
		echo "<p class='accessDenied'>Access denied!</p>";
	}
	else
	{

					echo "
						<div class='row'><div class='small-12 columns' style='padding-right:0'>
							<h1 id='page-name'>Edit Profile</h1></div></div>
						";


							$query = "SELECT usr_id, usr_fname, usr_lname, usr_picture, usr_graduate, usr_mgr_id, usr_phone, usr_email, usr_linkedin, mgr_name FROM tblUser LEFT JOIN tblMajor ON tblUser.usr_mgr_id = tblMajor.mgr_id WHERE usr_id = ".$ProfileId;
							if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){ while($row = mysqli_fetch_assoc( $result)) {
						echo "<input type='hidden' id='hdn_userid' value='".$row['usr_id']."'
						<div id='accordion'><div id='accordion'>
							<h3>Basic Information</h3>
								<div>
									<table width='100%' border='0' cellpadding='2'>
									  <tbody>
										<tr>
												<div id ='editNameBox'>
												First name: <input type='text' class='w300' id='txt_firstName' value=".$row['usr_fname']." maxlength='20'>
												Last name: <input type='text' class='w300' id='txt_lastName' value=".$row['usr_lname']." maxlength='20'>
												</div>
												<div id ='editPicBox'>
												<a class='ProfilePic' >
													<img class='userPic Left' src='".$row['usr_picture']."' alt='No Profile Picture'>
												</a>
												</div>
										</tr>
									  </tbody>
									</table>
								</div>
							<h3>Login Information</h3>
								<div>
										<input type='button' class='button' onClick='GoToPage(\"EditPassword\")' value='Change Password'><br>
										Email: <input type='text' class='w300' id='txt_email' value=".$row['usr_email']." maxlength='30'><br>
								</div>
							<h3>Academic Status</h3>
								<div>
									Major: ".$row['mgr_name']."

										<div id='editmajor'>
											<select class='w300' id='slt_major'>";
												$con2 = open(); $mgrid = $row['usr_mgr_id'];
												$query2 = "SELECT mgr_clg_id, mgr_name, mgr_id FROM tblMajor";
												if ($result2 = mysqli_query($con2, $query2)){if (mysqli_num_rows($result2) > 0 ) { while($row2 = mysqli_fetch_assoc($result2)){
												  if ($mgrid == $row2['mgr_id'])
												  {
													  echo "<option value=".$row2['mgr_id']." selected>".$row2['mgr_name']."</option>";
												  }
												  else
												  {
													  echo "<option value=".$row2['mgr_id'].">".$row2['mgr_name']."</option>";
												  }
												}
												} else { /*no results found */ }
												} else { echo 'error';}
												mysqli_close($con2);
						echo "				</select>
										</div>";
									$grad = $row['usr_graduate'];
									if ($grad)
									{
										echo "
										<input type='radio' name='academicstatus' value='0'> Undergraduate<br>
										<input type='radio' name='academicstatus' value='1' checked> Graduate<br>";
									}
									else
									{
										echo "
										<input type='radio' name='academicstatus' value='0' checked> Undergraduate<br>
										<input type='radio' name='academicstatus' value='1'> Graduate<br>";
									}
									echo "
								</div>
							<h3>Contact Information</h3>
								<div>
									Phone Number: <input type='text' class='w300' id='txt_phone' value=".$row['usr_phone']." maxlength='10'><br>
									LinkedIn: <input type='text' class='w300' id='txt_linkedin' value=".$row['usr_linkedin']."><br>
								</div>
						</div></div>
						";
							}}
							else
							{ /* no results found */
								echo "<p class='alert-box warning'>You must be logged in to do the action requested.</p>";
							}}
							else
							{ /* error */
								echo "<p class='alert-box error'>There was a problem processing the request. Please try again.</p>";
							}
							mysqli_close($con);

						echo "<br><input class='button' type='button' value='Submit' onClick='ProcessProfileChanges()'>
						<img src='/images/pixel.png' onload='ProfileEditLoaded()' width='0' height='0'>
								";

	}
?>
