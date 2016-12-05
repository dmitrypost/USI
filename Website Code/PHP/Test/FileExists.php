<?php
echo "Test<hr>";
	function FileNameFromPath($Path)
	{
		$slash = DIRECTORY_SEPARATOR;
		$i = strripos($Path,$slash);
		echo $i;
		return substr($Path,(int)$i);	
	}

	function GetPath($path,$delimitor = "|")
	{
		$slash = DIRECTORY_SEPARATOR;
		
			return str_replace($delimitor,$slash,$path);
		
	}
	echo "<hr>".FileNameFromPath(GetPath(".\..\Filename.txt"));
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
		if (isset($_POST['file']))
		{
			$path =  $_POST['file'];
			if (file_exists($path))
			{
				echo "file does exist! :)";	
				echo GetPath($path);
				echo FileNameFromPath(GetPath($path));
			}
			else
			{
				echo "file does not exists! :(";
			}
		}
		elseif(isset($_POST['dir']))
		{
			$dir = $_POST['dir'];
			$files1 = scandir($dir);
			print_r($files1);
		}
		else
		{
			echo "path not passed";	
		}
	}
	echo "<form action='FileExists.php' method='post'>
	path: <input type='textbox' name='file' id='file' value=''>
	<div><input type='submit' value='File Exists?'></div></form>";
	echo "<form action='FileExists.php' method='post'>
	path: <input type='textbox' name='dir' id='dir' value=''>
	<div><input type='submit' value='Check Files In Dir'></div></form>";
?>