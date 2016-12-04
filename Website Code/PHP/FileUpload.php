
<?php
include_once 'Functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
		foreach ($_POST as $key => $val) {
		  echo '<p>'.$key.':'.$_POST[$key].'</p>';
		  if (is_array($_POST[$key])) {echo "array";}
		}
		foreach ($_FILES as $key => $val) {
		  echo '<p>'.$key.':'.$_FILES[$key]['name'].'</p>';
		}
	//sys_get_temp_dir() returns the C:/Windows/temp directory path
	//tempnam( , ) function gives the file name a temporary file name instead of the acutal file name
		
	$UserId = getUID(); //gets the id of the logged in user: also returns 0 if they are not logged in.	
	
	// makes sure that the passed data contains an action variable
	if (isset($_POST['Action']))
	{
		$con = Open();
		switch (mysqli_real_escape_string($con,trim(strip_tags($_POST['Action']))))
		{
			case 'UploadForm':
				////FileAction(elem,type,page,action,value,optional)
				echo "
				<body>
				  <form id='frm_fileupload' enctype='multipart/form-data' action=\"javascript:FileAction($('#div_fileform'),'Upload','Profile','UploadFilePath','1','')\" method='POST'>
					  <input type='hidden' name='MAX_FILE_SIZE' value='30000000000000000' />
					  <input id='fle_userfile' type='file' />
					  <input type='submit' value='Send File' />
				  </form>
				</body>";
				break;
			case 'UploadFilePath':
			 	//makes sure that you are uploading while logged in and that there is a project id given to know which project to associate the file with.
				if (isset($_POST['value']) && $UserId !== 0 && isset($_POST['fle_filename']))
				{
					//    path with the start of "/" references the root
					//    path with the start of "./" references the path relative to this file
					$con = Open();
					$ProjectId = mysqli_real_escape_string($con,trim(strip_tags($_POST['value'])));	
					$projectDir = GetPath("C:/wamp64/www/Files/ProjectFiles/".$ProjectId."/");
					$originalFileName = basename($_FILES['fle_userfile']['name']);
					$NewFilePath =$projectDir . mysqli_real_escape_string($con,trim(strip_tags($_POST['fle_filename'])));
					$UploadFilePath = $projectDir . basename($_FILES['fle_userfile']['name']); //gives you a path that the new file will be stored at...

					if (FileExists($NewFilePath)) //if file being uploaded already has the same name as a file that already exists for this given project
					{
						// sends the user HTML of if they want to overwrite the file or not// temporarily moves the file...	
						if (MoveUploadedFile($UploadFilePath)) //moves the file from temp dir 
						{
							echo "<p class='alert-box notice'>There file uploaded already exists what would you like to do?</p>";
							echo "<button onClick='FileAction($(\"#div_fileform\"),\"Upload\",\"Project\",\"OverwriteFile\",$ProjectId,\"$originalFileName\")'>Overwrite File</button>";	//FileAction javascript function will get details such as file project id, sends action variable, 
							echo "<button onClick='FileAction($(\"#div_fileform\"),\"Upload\",\"Project\",\"DiscardFile\",$ProjectId,\"$originalFileName\")'>Discard File</button>";				
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
							$query = "INSERT INTO tblFile (fle_pjt_id,fle_data,fle_usr_id,fle_deleted) VALUES ($ProjectId,'".ReplaceDirChar($NewFilePath)."',$UserId,FALSE)";
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
					}
					mysqli_close($con);
				}				
				break;
			case 'OverwriteFile': //uploaded file had the same filename as another one and now the user says to overwrite that file 
				if (isset($_POST['value']) && $UserId !== 0 && isset($_POST['optional']) && isset($_POST['optional']))
				{
					$con = Open();
					$ProjectId = mysqli_real_escape_string($con,trim(strip_tags($_POST['value'])));	
					$projectDir = GetPath("C:/wamp64/www/Files/ProjectFiles/".$ProjectId."/");
					$originalFileName = mysqli_real_escape_string($con,trim(strip_tags($_POST['optional'])));
					$TempFilePath = $projectDir . $originalFileName;
					//can only proceed if the file exists...
					if (FileExists($TempFilePath))
					{
							
					}
					mysqli_close($con);
				}
				break;
			case 'DiscardFile': //uploaded file had the same filename as another one and now the user says to discard that file 
									
		}
		
	}
	

}
?>
