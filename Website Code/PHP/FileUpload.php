
<?php
include_once 'Functions.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//sys_get_temp_dir() returns the C:/Windows/temp directory path
	//tempnam( , ) function gives the file name a temporary file name instead of the acutal file name
		
	$UserId = getUID(); //gets the id of the logged in user: also returns 0 if they are not logged in.	
	if (isset
	if (isset($_POST['ProjectId']) && $UserId !== 0) //makes sure that you are uploading while logged in and that there is a project id given to know which project to associate the file with.
	{
		//    path with the start of "/" references the root
		//    path with the start of "./" references the path relative to this file
		$con = Open();
		$ProjectId = mysqli_real_escape_string($con,trim(strip_tags($_POST['ProjectId'])));	
		$projectDir = GetPath("./../Files/ProjectFiles/".$ProjectId."/");
		$filename = basename($_FILES['userfile']['name']);
		
		if (FileExists($filename)) //if file being uploaded already has the same name as a file that already exists for this given project
		{
			// sends the user HTML of if they want to overwrite the file or not
			echo "<button onClick='FileOverwrite(this)'>Overwrite File</button>";	
		}
		$uploadfile = $projectDir . basename($_FILES['userfile']['name']); //gives you a path that the new file will be stored at...
		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
			echo "File is valid, and was successfully uploaded.\n";
			if ($_FILES['userfile']['size'])
			{
				echo $uploadfile."<br>";
			}
		} 
		else 
		{
		
			echo "There was an error uploading the file. Please try again.";
		}
		
		echo 'Here is some more debugging info:';
		print_r($_FILES);
		
		echo realpath($uploadfile);
	}
	elseif($_POST['ProjectId']) && $UserId !== 0 && $_POST['']))
	{
		
	}

}
?>
