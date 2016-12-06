
<?php
	include_once 'Functions.php';
	$con = Open();

	if (isset($_POST['Action']) && isset($_POST['Id']) && isset($_POST['Pass']))
	{
		$UserId  = mysqli_real_escape_string($con,trim(strip_tags($_POST['Id'])));
		$Password  = mysqli_real_escape_string($con,trim(strip_tags($_POST['Pass'])));
		if (strlen($Password)<4)
		{
			echo "<p class='alert-box error'>Password has to be 4 characters long.</p>";
		}
		else
		{
			if (SetPassword($Password,$UserId))
			{
				echo "<p class='alert-box success'>The new password has been set.</p>";
			}
			else
			{
				echo "<p class='alert-box error'>There was an issue updating the password. Please try again.</p>";
			}
		}
		mysqli_close($con);
	}
	else
	{
		PageTitle("User Management");
		if (!isAdmin())
		{
			echo "<p class='alert-box error'>Access Denied!</p>";
			exit;
		}
		function FormattedTableUsers()
		{
			$con = Open();
			$query = "SELECT usr_id, usr_fname, usr_lname, usr_email, usr_phone, usr_admin FROM tbluser";
			$html = "";
			if ($result = mysqli_query($con,$query))
			{ if (mysqli_num_rows($result)> 0)
				{ while ($row = mysqli_fetch_assoc($result))
					{
						$html .= "<tr onClick='TableItemSelected(".$row['usr_id'].",this)'>
							  <td>".$row['usr_fname']."</td>
							  <td>".$row['usr_lname']."</td>
							  <td>".$row['usr_email']."</td>
							  <td>".$row['usr_phone']."</td>
							  <td>".$row['usr_admin']."</td>
							</tr>";
					}
				}
			}
			mysqli_close($con);
			return $html;
		}
		//select of any user's for a password reset
		echo "
		Selected User<div class='dropdownsearch'><select id='slt_SelectedUser' onClick='SelectDropdown()'></select></div>
			<div class='itemconfiguration'><input type='hidden' id='hdn_SelectedUserId' value=''>
			<table  cellpadding='15'>
			  <tbody>
				<tr>
				  <th scope='col'>First Name</th>
				  <th scope='col'>Last Name</th>
				  <th scope='col'>Email</th>
				  <th scope='col'>Phone</th>
				  <th scope='col'>Admin</th>
				</tr>";

		echo FormattedTableUsers();
		echo "
			  </tbody>
			</table>
		</div>
		<div id='actions'>
		New Password
		<br>
		<section class='in-line no-wrap'><input type='password' id='pwd_newpassword'><button onClick='SetPassword()'>Set</button>
		<button onClick='GoToPage(\"EditProfile\",\"\",$(\"#hdn_SelectedUserId\").val(),\"\")'>Edit Profile</button></section>
		<div id='status'></div>

		</div>
		";

		mysqli_close($con);
	}
?>
