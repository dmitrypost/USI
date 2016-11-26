<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		include_once "Functions.php";
		$con = Open(); //used to sanitize the variable
		$FileId = mysqli_real_escape_string($con,trim(strip_tags($_POST['FileDownload'])));
		$query = "SELECT fle_data, fle_name FROM tblFile WHERE fle_id=$FileId";
		if ($result = mysqli_query($con, $query))
		{ if (mysqli_num_rows($result) > 0)
			{ if ($row = mysqli_fetch_assoc($result))
				{
				$data = $row['fle_data'];
				$filename = $row['fle_name'];
				mysqli_close($con);
				//write the data to a file
				$myfile = fopen($filename, "w") or die("Unable to open file!");
				fwrite($myfile, $data);
				fclose($myfile);
				//set the headers and start the download
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="'.basename($filename).'"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($filename));
				readfile($filename);
				exit;
				}
			}
			else
			{
				mysqli_close($con);
				//nothing to do file doesn't exist.
				echo "file does not exist";		
			}	
		}
	}
?>
