<?php

	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
		if (isset($_POST['user']) && isset($_POST['password']) && isset($_POST['port'] )&& isset($_POST['host']))
		{
			$host = $_POST['host']; echo $host."<br>";
			$user = $_POST['user']; echo $user."<br>";
			$password = $_POST['password']; echo $password."<br>";
			$port = $_POST['port']; echo $port."<br>";
			$host = gethostbyname ($host);
			
			$con = mysqli_connect($host, $user, $password, 'usiprojectrepository',$port);
			if (!$con)
			{
				echo ("connection error: " . mysqli_connect_error());
			}
			else
			{
				echo "connected method 1";
			}
			$con = mysql_connect('localhost', "$user", "$password");
			if (!$con)
			{
				echo ("connection error: " . mysqli_connect_error());
			}
			else
			{
				echo "connected method 2";	
			}
		}
	}
	echo "<form action='DatabaseTest.php' method='post'>
	host: <input type='textbox' name='host' id='host' value='localhost'>
	user: <input type='textbox' name='user' id='user' value='eproject'>
	password: <input type='textbox' name='password' id='password' value='dana123'>
	port: <input type='textbox' name='port' id='port' value='3306'>
	<div><input type='submit' value='Test'></div></form>";
		//connect to database
	

?>