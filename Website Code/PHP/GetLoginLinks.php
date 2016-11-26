<?php
	if (($_SERVER['REQUEST_METHOD'] == 'POST') )
    { 
		session_start(); //required to get session_id 
		if (!empty(session_id()))
		{
			include_once 'Database.php';
			$con = open();
			$query = "SELECT usr_fname, usr_id, usr_admin FROM tblUser INNER JOIN tblSession ON tblUser.usr_id = tblSession.ses_usr_id WHERE ses_session = '".session_id()."' AND ISNULL(ses_expired)";
			if ($result = mysqli_query($con, $query))
			{
				if (mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_assoc( $result)) 
					{
						$AdminLink = "";
						if ($row['usr_admin'] == true)
						{ 
							$AdminLink = "<li><a href='javascript:void(0)' onClick='GoToPage(\"AdminPanel\",\"\",\"\",\"\")'>Admin Panel</a></li>";
						}
						echo "
						<li class='has-dropdown' onMouseOver='ToggleDropdown(this)' onMouseOut='ToggleDropdown(this)'>
							<a href='javascript:void(0)' onClick='GoToPage(\"Profile\",\"\",".$row['usr_id'].",\"\")'  title='View Profile'>".$row['usr_fname']."</a>
							  <ul class='dropdown'>
									<li class='title back js-generated'>
									  <h5><a href='#'>« Back</a></h5></li>
									<li><a class='parent-link js-generated' href='javascript:void(0)' onClick='GoToPage(\"Profile\",\"\",".$row['usr_id'].",\"\")'>".$row['usr_fname']."</a></li>
									$AdminLink
									<li><a href='javascript:void(0)' onClick='GoToPage(\"EditProfile\",\"View\",\"\",\"\")' title='Edit Profile'>Edit Profile</a></li>
									<li><a href='javascript:void(0)' onClick='GoToPage(\"Projects\",\"\",\"Owned\",\"\")' title='My Projects'>My Projects</a></li>
									<li><a href='javascript:void(0)' onClick='Logout()' title='Logout'>Logout</a></li>
							  </ul>
						</li>						
						";
						echo('|');		
						echo("<a href='javascript:void(0)' onClick='GoToPage(\"Projects\",\"\",\"Owned\",\"\")' title='My Projects'>My Projects</a>");	
						break;	
					}
				}
				else
				{ //session does not match a session in the database
					echo('<a href="javascript:void(0)" onClick="showLogin()" title="Login">Login</a>');	
					echo('|');		
					echo('<a href="javascript:void(0)" onClick="showRegister()" title="Register">Register</a>');		
				}
			}
			else
			{	//if user tries to send a post to this php and the query returns no result for the session in the database
				echo('<a href="javascript:void(0)" onClick="showLogin()" title="Login">Login</a>');	
				echo('|');		
				echo('<a href="javascript:void(0)" onClick="showRegister()" title="Register">Register</a>');
			}
					
		}
		else
		{ //failsafe if session still is empty
			echo('<a href="javascript:void(0)" onClick="showLogin()">Login</a>');	
			echo('|');		
			echo('<a href="javascript:void(0)" onClick="showRegister()">Register</a>');					
		}
		mysqli_close($con);
	}
?>
