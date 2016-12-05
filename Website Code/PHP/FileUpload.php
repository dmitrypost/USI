<?php
include_once 'Functions.php';
$FilesDir = "./Files/";
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
		/*foreach ($_POST as $key => $val) {
		  echo '<p>'.$key.':'.$_POST[$key].'</p>';
		  if (is_array($_POST[$key])) {echo "array";}
		}
		foreach ($_FILES as $key => $val) {
		  echo '<p>'.$key.':'.$_FILES[$key]['name'].'</p>';
		}*/
	//sys_get_temp_dir() returns the C:/Windows/temp directory path
	//tempnam( , ) function gives the file name a temporary file name instead of the acutal file name
		
	$UserId = getUID(); //gets the id of the logged in user: also returns 0 if they are not logged in.	
	
	// makes sure that the passed data contains an action variable
	if (isset($_POST['Action']) && $UserId !== 0 )
	{
		$con = Open();
		switch (mysqli_real_escape_string($con,trim(strip_tags($_POST['Action']))))
		{
			case 'UploadForm':
				////FileAction(elem,type,page,action,value,optional)
				if (isset($_POST['value']) && $UserId !== 0)
				{
					$con = Open();
					$ProjectId = mysqli_real_escape_string($con,trim(strip_tags($_POST['value'])));	
					echo "
					<body>
					  <form id='frm_fileupload' enctype='multipart/form-data' action=\"javascript:FileAction($('#div_fileform'),'fle_userfile','Upload','Project','UploadFilePath','$ProjectId','')\" method='POST'>
						  <input type='hidden' name='MAX_FILE_SIZE' value='30000000000000000' />
						  <input id='fle_userfile' type='file' />
						  <input class='button' type='submit' value='Upload' />
					  </form>
					</body>";
				}
				mysqli_close($con);
				break;
			case 'UploadFilePath':
			 	//makes sure that you are uploading while logged in and that there is a project id given to know which project to associate the file with.
				if (isset($_POST['value']) && $UserId !== 0 && isset($_POST['fle_filename']))
				{
					//    path with the start of "/" references the root
					//    path with the start of "./" references the path relative to this file
					$con = Open();
					$ProjectId = mysqli_real_escape_string($con,trim(strip_tags($_POST['value'])));	
					$projectDir = GetPath($FilesDir."ProjectFiles/".$ProjectId."/");
					$originalFileName = basename($_FILES['fle_userfile']['name']);
					$NewFilePath =$projectDir . mysqli_real_escape_string($con,trim(strip_tags($_POST['fle_filename'])));
					$NewFileName = mysqli_real_escape_string($con,trim(strip_tags($_POST['fle_filename'])));
					$UploadFilePath = $projectDir . basename($_FILES['fle_userfile']['name']); //gives you a path that the new file will be stored at...
					if (!FileExists($projectDir)) { mkdir($projectDir);	 }
					if (FileExists($NewFilePath)) //if file being uploaded already has the same name as a file that already exists for this given project
					{
						// sends the user HTML of if they want to overwrite the file or not// temporarily moves the file...	
						if (MoveUploadedFile($UploadFilePath)) //moves the file from temp dir 
						{
							echo "<p class='alert-box notice'>There file uploaded already exists what would you like to do?</p>";
							echo "<button onClick='FileAction($(\"#div_fileform\"),\"\",\"Upload\",\"Project\",\"OverwriteFile\",$ProjectId,\"$originalFileName|$NewFileName$\")'>Overwrite File</button>";	//FileAction javascript function will get details such as file project id, sends action variable, 
							echo "<button onClick='FileAction($(\"#div_fileform\"),\"\",\"Upload\",\"Project\",\"DiscardFile\",$ProjectId,\"$originalFileName\")'>Discard File</button>";				
						}
						else
						{
							echo "<p class='alert-box error'>There was an error uploading the file.</p>";
						}
					}
					else
					{
						//file does not exist so proceed with uploading
						if (MoveUploadedFile($UploadFilePath))
						{
							rename($UploadFilePath,$NewFilePath);
							$query = "INSERT INTO tblFile (fle_pjt_id,fle_path,fle_usr_id) VALUES ($ProjectId,'".ReplaceDirChar($NewFilePath)."',$UserId)";
							if (QuickQuery($query))
							{
								//file is encoded in base64 and has metadata with it
								//		FileDecode returns the decoded data without the metadata
								//		FileWrite writes the data back into the file.
								FileWrite($NewFilePath,FileDecode($NewFilePath));
								echo "<p class='alert-box success'>File uploaded successfully!</p>";
								
							}
							else
							{
								echo "<p class='alert-box error'>File uploaded successfully, but was not added to database!</p>";
							}
						}
						else
						{
							echo "<p class='alert-box error'>File upload failed!</p>";	
						}
						//upload additional file button
						echo  "<button onClick='FileAction($(\"#div_fileform\"),\"\",\"Upload\",\"Project\",\"UploadForm\",$ProjectId,\"\")'>Upload More</button>";
					}
					
					mysqli_close($con);
				}				
				break;
			case 'OverwriteFile': //uploaded file had the same filename as another one and now the user says to overwrite that file 
				if (isset($_POST['value']) && $UserId !== 0 && isset($_POST['optional']) && isset($_POST['optional']))
				{
					$con = Open();
					$ProjectId = mysqli_real_escape_string($con,trim(strip_tags($_POST['value'])));	
					$projectDir = GetPath($FilesDir."ProjectFiles/".$ProjectId."/");
					//split the optional posted value (contains the old file name and the new file name)
					$optional = mysqli_real_escape_string($con,trim(strip_tags($_POST['optional'])));
					$optionalArray = explode("|",$optional);
					$originalFileName = $optionalArray[0];
					$newFileName = $optionalArray[1];
					//paths
					$TempFilePath = $projectDir . $originalFileName;
					$NewFilePath = $projectDir.$newFileName;
					//can only proceed if the file exists...
					if (FileExists($TempFilePath))
					{
						rename($TempFilePath,$NewFilePath);
						$query = "UPDATE tblFile SET fle_usr_id = $UserId WHERE fle_pjt_id = $ProjectId AND fle_path = '$NewFilePath'";
							if (QuickQuery($query))
							{
								//file is encoded in base64 and has metadata with it
								//		FileDecode returns the decoded data without the metadata
								//		FileWrite writes the data back into the file.
								FileWrite($NewFilePath,FileDecode($NewFilePath));
								FileDelete($NewFilePath); //confusing I know, this is deleting the copy of file that is created which includes a $ at the end of the filepath
								echo "<p class='alert-box success'>File updated successfully!</p>";
							}
							else
							{
								echo "<p class='alert-box success'>File updated successfully, but was not updated in the database!</p>";
							}
						
					}
					else
					{
						echo "<p class='alert-box error'>File missing!</p>";	
					}
					echo  "<button onClick='FileAction($(\"#div_fileform\"),\"\",\"Upload\",\"Project\",\"UploadForm\",$ProjectId,\"\")'>Upload More</button>";
					mysqli_close($con);
				}
				break;
			case 'DiscardFile': //uploaded file had the same filename as another one and now the user says to discard that file 
				if (isset($_POST['value']) && $UserId !== 0 && isset($_POST['optional']) && isset($_POST['optional']))
				{
					$con = Open();
					$ProjectId = mysqli_real_escape_string($con,trim(strip_tags($_POST['value'])));	
					$projectDir = GetPath($FilesDir."ProjectFiles/".$ProjectId."/");
					//split the optional posted value (contains the old file name and the new file name)
					$originalFileName = mysqli_real_escape_string($con,trim(strip_tags($_POST['optional'])));
					$TempFilePath = $projectDir . $originalFileName;
					//can only proceed if the file exists...
					if (FileExists($TempFilePath))
					{
						if (FileDelete($TempFilePath))
						{
							echo "<p class='alert-box success'>File discarded successfully!</p>";	
						}
						else
						{
							echo "<p class='alert-box error'>Error occurred while discarding file!</p>";
						}
					}
					else
					{
						echo "<p class='alert-box error'>File missing!</p>";	
					}
					echo  "<button onClick='FileAction($(\"#div_fileform\"),\"\",\"Upload\",\"Project\",\"UploadForm\",$ProjectId,\"\")'>Upload More</button>";
					mysqli_close($con);					
				}		
				break;
			case 'ProjectPictureChange':
				if (isset($_POST['value']))
				{
					$con = Open();
					$ProjectId = mysqli_real_escape_string($con,trim(strip_tags($_POST['value'])));	
					echo "
					<body>
					  <form enctype='multipart/form-data' action=\"javascript:FileAction($('#div_projectpictureform'),'fle_projectpic','Upload','Project','ProjectPicture','$ProjectId','')\" method='POST'>
						  <input type='hidden' name='MAX_FILE_SIZE' value='30000000000000000' />
						  <input id='fle_projectpic' type='file' />
						  <input class='button' type='submit' value='Upload' />
					  </form>
					</body>";
					mysqli_close($con);	
				}
				break;
			case 'ProjectPicture':
				//only has to overwrite the profile picture in the database
				if (isset($_POST['value']))
				{
					$con = Open();
					$tempFilePath = tempnam(sys_get_temp_dir(),"TempProfilePic");
					$ProjectId = mysqli_real_escape_string($con,trim(strip_tags($_POST['value'])));	
					
					//file does not exist so proceed with uploading
						if (MoveUploadedFile($tempFilePath))
						{
							$query = "UPDATE tblProject SET pjt_picture = '".FileRead($tempFilePath)."' WHERE pjt_id = $ProjectId";
							if (QuickQuery($query))
							{
								echo "<p class='alert-box success'>Project picture updated successfully!</p>";
								FileDelete($tempFilePath); //deletes the file
							}
							else
							{
								echo "<p class='alert-box error'>There was a problem updating the project picture!</p>";
							}
						}
						echo  "<button onClick='FileAction($(\"#div_projectpictureform\"),\"\",\"Upload\",\"Project\",\"UploadForm\",\"ProjectPictureChange\",\"\")'>Change again</button>";
				}
				break;
			case 'ProfilePictureChange':
				if (isset($_POST['value']))
				{
					$con = Open();
					$ProfileId = mysqli_real_escape_string($con,trim(strip_tags($_POST['value'])));	
					echo "
					<body>
					  <form enctype='multipart/form-data' action=\"javascript:FileAction($('#div_profilepictureform'),'fle_profilepic','Upload','Profile','ProfilePicture','$ProfileId','')\" method='POST'>
						  <input type='hidden' name='MAX_FILE_SIZE' value='30000000000000000' />
						  <input id='fle_profilepic' type='file' />
						  <input class='button' type='submit' value='Upload' />
					  </form>
					</body>";
					mysqli_close($con);	
				}
				break;
			case 'ProfilePicture':
				//only has to overwrite the profile picture in the database
				
				if (isset($_POST['value']))
				{
					$con = Open();
					$tempFilePath = tempnam(sys_get_temp_dir(),"TempProfilePic");
					$ProfileId = mysqli_real_escape_string($con,trim(strip_tags($_POST['value'])));	
					if ($UserId != $ProfileId && !isAdmin()) 
					{
						echo "<p class='alert-box error'>You are only permitted to change your own picture!</p>";
					}
					else
					{
					//file does not exist so proceed with uploading
					if (MoveUploadedFile($tempFilePath))
					{
						$query = "UPDATE tblUser SET usr_picture = '".FileRead($tempFilePath)."' WHERE usr_id = $ProfileId";
						if (QuickQuery($query))
						{
							
							echo "<p class='alert-box success'>Project picture updated successfully!</p>";
							FileDelete($tempFilePath); //deletes the file
						}
						else
						{
							echo "<p class='alert-box error'>There was a problem updating the project picture!</p>";
						}
					}
					echo  "<button onClick='FileAction($(\"#div_profilepictureform\"),\"\",\"Upload\",\"Profile\",\"ProfilePictureChange\",$ProfileId,\"\")'>Change again</button>";
					}
				}
				break;
		}		
	}
	else
	{
		echo "<p class='alert-box error'>You must be logged in to perform this action!</p>";		
	}
}
?>
