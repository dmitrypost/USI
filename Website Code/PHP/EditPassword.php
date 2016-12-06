<div class='row'><div class='small-12 columns' style='padding-right:0'>
<h1 id='page-name'>Change Password</h1></div></div>
Current Password:
<input type="password"  class="w300" id="pass_current" maxlength="50";>
New Password:
<input type="password" class="w300" id="pass_new" maxlength="50";>
Confirm New Password:
<input type="password"  class="w300" id="pass_confirm" maxlength="50";>
<button class="accordianbtns" onClick="SubmitPasswordChanges()">Submit</button> 
<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		if (isset($_POST['oldpassword']) AND isset($_POST['newpassword']) AND isset($_POST['repeatedpassword']) )
		{
			include_once 'Functions.php';
			$con = Open();
			$oldPass  = mysqli_real_escape_string($con,trim(strip_tags($_POST['oldpassword']))); 
			$newPass  = mysqli_real_escape_string($con,trim(strip_tags($_POST['newpassword']))); 
			$repPass  = mysqli_real_escape_string($con,trim(strip_tags($_POST['repeatedpassword']))); 
			$userId = getUID();
			if (isPasswordValid($oldPass))
			{
				if ($newPass == $repPass)
				{
					if ($userId != 0) //if not 0 then you got a uid of a logged in user...
					{
						if (strlen($newPass)<4)
						{
							echo "<p class='alert-box error'>Password has to be 4 characters long.</p>";
						}
						else
						{
						if (SetPassword($newPass,$userId))
						{
							echo "<p class='alert-box success'>The new password has been set.</p>";		
						}
						else
						{
							echo "<p class='alert-box error'>There was an issue updating the password. Please try again.</p>";
						}}
					}
					else
					{
						echo "<p class='alert-box error'>You must be logged in to do the action requested. Please log in and try again.</p>";	
					}
				}
				else
				{
					echo "<p class='alert-box warning'>The password does not match the confirm password. Please try again.</p>";
				}
			}
			else
			{
				echo "<p class='alert-box error'>The current password is incorrect. Please try again.</p>";	
			}
		}
	}
?>