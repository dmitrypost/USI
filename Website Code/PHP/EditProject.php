<?php
	include_once 'Functions.php';
	PageTitle("Edit Project");
	$con = Open();
	if (!isset($_POST['value'])) 
	{ 
		echo "<p class='alert-box error>No project id was passed.</p>";
	}
	else
	{
		$ProjectId = mysqli_real_escape_string($con,trim(strip_tags($_POST['value']))); 
				
		$query = "SELECT pjh_description, pjh_body FROM tblProjectHistory WHERE pjh_id =$ProjectId AND pjh_approved = FALSE";
		if ($result = mysqli_query($con,$query))
		{ if(mysqli_num_rows($result) > 0)
			{
				$query2 = "SELECT pjt_name, pjt_mgr_id, pjt_picture, pjt_year FROM tblProject WHERE pjt_id = $ProjectId";
				if ($result2 = mysqli_query($con,$query2))
				{ if (mysqli_num_rows($result2) > 0)
					{
						
					}
					else
					{
						echo "<p class='alert-box information'>There is no project with that id. Please try again.</p>";		
					}
				}
				else
				{
					echo "<p class='alert-box error'>There was an issue retrieving the project details. Please try again.</p>";	
				}
			}
			else
			{
				//project does not have any pending changes
				$query = "SELECT pjt_name, pjt_description, pjt_body, pjt_mgr_id, pjt_year, pjt_picture FROM tblProject WHERE pjt_id = $ProjectId";	
				if ($result = mysqli_query($con,$query))
				{ if (mysqli_num_rows($result) > 0)
					{
						
					}
					else
					{
						echo "<p class='alert-box information'>There is no project with that id. Please try again.</p>";		
					}
				}
				else
				{
					echo "<p class='alert-box error'>There was an issue retrieving the project details. Please try again.</p>";	
				}
			}
		}
		else
		{
			echo "<p class='alert-box error'>There was an issue retrieving the project details. Please try again.</p>";
		}
		echo "
		<div id='accordion'>
			<h3>Basic Information</h3>	
				<div>
					Title<input type='text' id='txt_title' value='$projectTitle'>
					Major<select id='slt_major'>";
					include_once 'Database.php';
										$con = open();
										$query = "SELECT mgr_id, mgr_name FROM tblMajor ";
										if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
										while($row = mysqli_fetch_assoc( $result)) {
												echo "<option value=".$row['mgr_id'].">".$row['mgr_name']."</option>";
										}
										} else { /*no results found*/ }
										} else {echo 'error';}
							mysqli_close($con); echo "
					</select>
				</div>
			<h3>Description</h3>	
				<div>
					Description<input type='text' id='txt_description' value='$proejectDescription'>
					Project description will be submitted for approval by an administrator.
				</div>
			<h3>Body</h3>	
				<div>
					Body<textarea id='txt_body'>ffsafsd</textarea>
					Project body will be submitted for approval by an administrator.
				</div>
			<h3>Participants</h3>	
				<div>
					<button type='button' class='btn btn-default btn-sm' onClick=''>
					  <span class='glyphicon glyphicon-plus'></span> Add
					</button>
					Removing project participants will require approval by an administrator.
				</div>
			<h3>Files</h3>	
				<div>
				</div>
		</div>
		<img src='/images/pixel.png' onload='EditProjectLoaded()' width='0' height='0'>
		";
	}
?>
		
		<div>
			<h5>Title:</h5>
				<div id="editprojecttitle">
			</div>
			<h5>Image</h5>
			<div id="editprojectimage"><input class="button" type="button" value="Change" onClick="ProcessImageChanges()">
			      <img src="/images/pixel.png" onload="ImageChangesLoaded()" width="0" height="0"><br>
			</div>
			<h5>Description:</h5>
			<div id="editprojectdesc"><textarea maxlength="200">A short description that is attached to the home page when you're project is featured.</textarea>
      </div>
			<h5>Body:</h5>
			<div id="editprojectbody"><textarea>A more detailed summary of your project. Explain the idea, method, and impacts.</textarea>
			</div>
			<h5>Year:</h5>
			<div id="editprojectyear"><input type="text"  value="****" maxlength="4";>
			</div>
			<h5>Change College</h5>
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
            </select>
				</div>

			<h5>Change Participants:</h5>
			<div id="editprojectparticipants"><input class="button" type="button" value="Change Participants" onClick="ProcessParticipantChanges()">
			     
			</div>
      <div id="editprojectparticipantstext"><input type="text"
				value="Participant's email address";>
			</div>
      <div id="addprojectparticipant"><input class="button" type="button" value="Add" onClick="ProcessAddParticipant()">
      </div>
			<br><br><br><br><br>
      <h5>Upload Files</h5>
			<div id="editprojectupload";>
			</div>
      <div>
      <br><input class="button" type="button" value="Submit" onClick="ProcessProjectChanges()">
        <img src="/images/pixel.png" onload="ProjectChangesLoaded()" width="0" height="0";>
		</div>


