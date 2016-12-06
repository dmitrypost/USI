<?php
	include_once 'Functions.php';
	PageTitle("Alter Home Page");
	function PageHTML($Content)
	{
		return "<textarea id='txt_container' style='min-height: 600px;'>$Content</textarea>
			<button onClick='GoToPage(\"AlterHomePage\",\"Update\",$(\"#txt_container\").val(),\"\")' title='Updates home page'>Update</button>
			<button onClick='GoToPage(\"AlterHomePage\")' title='Cancels the changes made'>Cancel</button><br>";;
	}
	
	if (isAdmin())
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') 
		{
			$path = "./PHP/Default.php";
			$Content = FileRead($path);
			if (isset($_POST['Action']) AND isset($_POST['value']))
			{
				$con = open();
				$Action  = mysqli_real_escape_string($con,trim(strip_tags($_POST['Action']))); 	
				$Value  = $_POST['value']; 	
				
				if ($Action == "Update")
				{
					FileWrite($path,$Value);
					echo "<p class='alert-box success'>Home page updated!</p>";
				}
				else
				{
					echo "<p class='alert-box error'>Action not recognized!</p>";
				}
			}
			echo PageHTML($Content);
		}
	}
	else
	{
		echo "<p class='alert-box error'>Access Denied!</p>";		
	}
	
?>
