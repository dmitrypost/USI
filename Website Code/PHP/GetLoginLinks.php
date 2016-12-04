<?php
ini_set('display_errors', 1);
	if (($_SERVER['REQUEST_METHOD'] == 'POST') )
    { 
		include_once './Functions.php';
		$con = open();
		session_start(); //required to get session_id 
		if (is_session_started())
		{
			
			
			$query = "SELECT usr_fname, usr_id, usr_admin FROM tblUser INNER JOIN tblSession ON tblUser.usr_id = tblSession.ses_usr_id WHERE ses_session = '".session_id()."' AND ISNULL(ses_expired)";
			if ($result = mysqli_query($con, $query))
			{
				if (mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_assoc( $result)) 
					{
						$UserId = GetUID();
						$AdminLink = "";
						if ($row['usr_admin'] == true)
						{ 
							$AdminLink = "<li><a onClick='GoToPage(\"AdminPanel\",\"\",\"\",\"\")'>Admin Panel</a></li>";
						}
						echo "
						<li class='has-dropdown' onMouseOver='ToggleDropdown(this)' onMouseOut='ToggleDropdown(this)'>
							<a onClick='GoToPage(\"Profile\",\"\",$UserId,\"\")'  title='View Profile'>".$row['usr_fname']."</a>
							  <ul class='dropdown'>
									<li class='title back js-generated'>
									  <h5><a href='#'>« Back</a></h5></li>
									<li><a class='parent-link js-generated' onClick='GoToPage(\"Profile\",\"\",".$row['usr_id'].",\"\")'>".$row['usr_fname']."</a></li>
									$AdminLink
									<li><a  onClick='GoToPage(\"EditProfile\",\"View\",\"\",\"\")' title='Edit Profile'>Edit Profile</a></li>
									<li><a  onClick='Logout()' title='Logout'>Logout</a></li>
							  </ul>
						</li>						
						";
						echo('|');		
						echo "
						<li class='has-dropdown' onMouseOver='ToggleDropdown(this)' onMouseOut='ToggleDropdown(this)'>
							<a onClick='GoToPage(\"Projects\",\"\",\"Owned\",\"\")' title='My Projects'>My Projects</a>
								<ul class='dropdown'>
									<li class='title back js-generated'>
										<h5><a href='#'>« Back</a></h5></li>
									<li><a class='parent-link js-generated' href='javascript:void(0)' onClick='GoToPage(\"Projects\",\"\",\"Owned\",\"\")'>My Projects</a></li>	
									<li><a onClick='GoToPage(\"AddProject\")' title='Add a new project'>Add Project</a></li>					
						";
						$query = "SELECT pjt_id, pjt_name FROM tblProject INNER JOIN tblRole ON tblProject.pjt_id = tblRole.rol_pjt_id WHERE rol_usr_id = $UserId";	
						
						if ($result = mysqli_query($con, $query))
						{
							if (mysqli_num_rows($result) > 0)
							{
								while ($row = mysqli_fetch_assoc($result))
								{
									echo "<li><a onClick='GoToPage(\"Project\",\"\",".$row['pjt_id'].",\"\")' >".$row['pjt_name']."</a></li>";
								}
							}
						}
						echo "
							</ul>
						</li>						
						";
						break;	
					}
				}
				else
				{ //session does not match a session in the database
					echo('<a onClick="showLogin()" title="Login">Login</a>');	
					echo('|');		
					echo('<a onClick="showRegister()" title="Register">Register</a>');		
				}
			}
			else
			{	//if user tries to send a post to this php and the query returns no result for the session in the database
				echo('<a onClick="showLogin()" title="Login">Login</a>');	
				echo('|');		
				echo('<a onClick="showRegister()" title="Register">Register</a>');
			}
					
		}
		else
		{ //failsafe if session still is empty
			echo('<a href="javascript:void(0)" onClick="showLogin()">Login</a>');	
			echo('|');		
			echo('<a href="javascript:void(0)" onClick="showRegister()">Register</a>');					
		}
		if ($con) {
		mysqli_close($con); }
	}
?>
