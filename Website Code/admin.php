<!DOCTYPE html>
<html>
    <head>
        <title>Admin </title>
        <meta http-equiv="X-UA-Compatible" content="IE-edge"/>
        <meta http-equiv="content-type" content="text/html; charset-utf-8"/>
        <!-- Javascript source files initiation area -->

    
    </head>
    <body>
        <div id="">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') 
        { // Handle the form.
			
			include 'Database.php';
			//login attempt
			$error = FALSE;
			if (!empty($_POST['email']) && !empty($_POST['password']))
			{
				$email = mysqli_real_escape_string($con,trim(strip_tags($_POST['email'])));
				$password = mysqli_real_escape_string($con,trim(strip_tags($_POST['password'])));
			}
			else
			{
				echo("please try again");
				$error = TRUE;
			}
			if (!$error)
			{
				//Define query
				$query = "SELECT usr_fname, usr_lname FROM tblUser WHERE usr_email = '".$email."' AND usr_password = '".$password."' AND usr_admin = TRUE";
				//Execute query
				if ($result = mysqli_query($con, $query))
				{
					//login successful
					while ($row = mysqli_fetch_assoc($result)) 
					{
						echo $row['usr_fname'] . " " . $row['usr_lname'] ;
					}
				}
				else
				{
					//login failed
				}

			}
			mysqli_close($con);
        }
        else
        {
			echo ('<form action="Admin.php" method="post">
			<table>
				<tr>
					<td>Email</td>
					<td><input type="text" name="email" size="20" maxsize="20"/></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="password" size="20" maxsize="20"/></td>
				<tr>
					<td><input type="submit" name="submit" value="login" /></td>
				</tr>
			</form>');
        }
        ?>

    </body>
</html>