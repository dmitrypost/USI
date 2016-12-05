<?php
	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		include_once "Functions.php";
		
		function GetFilePath($FileId)
		{
			$path = "";
			$con = Open();
			$query = "SELECT fle_path FROM tblFile WHERE fle_id = $FileId";
			if ($result = mysqli_query($con, $query))
			{	if (mysqli_num_rows($result) > 0)
				{	while($row = mysqli_fetch_assoc( $result)) 
					{
						$path = GetPath($row['fle_path']);				
					}
				}
				else
				{
					$path = "Not found";	
				}
			}
			else
			{
				$path = "Not found"; //query didn't run properly (possibly no id passed)
			}
			mysqli_close($con);
			return $path;
		}//function
		
		$con = Open();
		if (isset($_GET['FileId']) && !isset($_GET['ReturnType']))
		{
			$FileId = mysqli_real_escape_string($con,trim(strip_tags($_GET['FileId'])));
			$FilePath = GetFilePath($FileId);
			$FileName = FileNameFromPath($FilePath);
			// set the headers
			header("Content-Disposition: attachment; filename=\"$FileName\"");
			header("Pragma: public");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header('Content-Type: application/pdf');
			//read the file content in chuncks
			if (FileExists($FilePath))
			{
				set_time_limit(0);
				$file = @fopen($FilePath,"rb");
				while(!feof($file))
				{
					echo (@fread($file, 1024*8));
					ob_flush();
					flush();
				}
			}
			else
			{
				header("HTTP/1.1 404 Not Found"); 
			}
		}
		if (isset($_GET['FileId']) && isset($_GET['ReturnType']))
		{
			//Return the path of the file relative to web directory
			$FileId = mysqli_real_escape_string($con,trim(strip_tags($_GET['FileId'])));
			$FilePath = GetFilePath($FileId);
			$FileName = FileNameFromPath($FilePath);
			// set the headers
			header("Content-Disposition: attachment; filename=\"$FileName\"");
			header("Pragma: public");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header('Content-Type: application/pdf');
			//read the file content in chuncks
			if (FileExists($FilePath))
			{
				echo $FilePath;
			}
			else
			{
				header("HTTP/1.1 404 Not Found"); 
			}
		}
		
		//for admin use only | download file by path | requires admin to be logged in
		if (isset($_GET['FilePath']) && isAdmin())
		{
			$FilePath = GetPath(mysqli_real_escape_string($con,trim(strip_tags($_GET['FilePath']))));
			// set the headers
			header("Content-Disposition: attachment; filename=\"$FilePath\"");
			header("Pragma: public");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			//read the file content in chuncks
			if (FileExists($FilePath))
			{
				set_time_limit(0);
				$file = @fopen($FilePath,"rb");
				while(!feof($file))
				{
					echo (@fread($file, 1024*8));
					ob_flush();
					flush();
				}
			}	
			else
			{
				header("HTTP/1.1 404 Not Found"); 	
			}
		}		
		mysqli_close($con);
	}
?>
