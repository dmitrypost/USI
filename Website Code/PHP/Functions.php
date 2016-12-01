<?php
	include_once 'Database.php';
	
	function AddParticipant($firstName,$lastName,$email,$role,$projectId)
	{
		$randomPassword = uniqid();
		$con = Open();
		$query = "INSERT INTO tblUser (usr_fname,usr_lname,usr_email)VALUES('$firstName','$lastName','$email')";
		QuickQuery($query);
		$UserId = GetUserIdByEmail($email);
		$query = "INSERT INTO tblRole (rol_usr_id,rol_pjt_id,rol_name,rol_rst_id)VALUES($UserId,$projectId,$role,SELECT rst_name FROM tblRoleState WHERE rst_name = 'NORMAL')";
		QuickQuery($query);
		SetPassword($randomPassword,$UserId);
		$emailMessage = "You have been added as a project participant, thus we have created a password for you to allow you to login and make changes to your profile and edit details about the project. Your login information is Email: $email Password: $randomPassword";
		Email($email,"USI Project Repository - You have been added to a project as a participant",$emailMessage); 	
	}
	
	
	function Email($destinationAddress, $subject, $message)
	{
		mail($destinationAddress,$subject,$message);	
	}
	
	function GetPath($path,$delimitor = "|")
	{
		$slash = DIRECTORY_SEPARATOR;
		if ($delimitor == "|")
		{
			if ($slash == "/") //linux based environment
			{
				return str_replace("\\",$slash,$path);					
			}
			else //windows based environment
			{
				return str_replace("/",$slash,$path);			
			}
		}
		else //delimitor was passed 
		{		
			return str_replace($delimitor,$slash,$path);
		}
	}
	
	function FormattedUserLink($userId,$usersName)
	{
		echo "
			<div class='user-link'>
				<a href='javascript:void(0)' onClick='GoToPage(\"Profile\",\"\",$userId,\"\")' >$usersName</a>
				<br>
			</div>
		";	
	}
	function FormattedMajorLink($majorId,$majorName)
	{
		echo "
			<div class='major-link'>
				<a href='javascript:void(0)' onClick='GoToPage(\"Major\",\"\",$majorId,\"\")' >$majorName</a>
				<br>
			</div>
		";	
	}
	function FormattedCollegeLink($collegeId,$collegeName)
	{
		echo "
			<div class='collage-link'>
				<a href='javascript:void(0)' onClick='GoToPage(\"College\",\"\",$collegeId,\"\")' >$collegeName</a>
				<br>
			</div>
		";	
	}
	function FormattedProjectLink($projectId,$projectName)
	{
		echo "
			<div class='user-link'>
				<a href='javascript:void(0)' onClick='GoToPage(\"Project\",\"\",$projectId,\"\")' >$projectName</a>
				<br>
			</div>
		";	
	}
	
	function FormattedProjectPreview($projectTitle,$projectDescription,$projectyear,$projectId,$edit)
	{
		echo "
		<div class='project-preview' >
            <section>
		  		<h4><a onClick='GoToPage(\"Project\",\"\",$projectId)'><u>$projectTitle</u> $projectyear</a>"; 
				if ($edit) { echo "<a class='edit' href='javascript:GoToPage(\"EditProject\",\"\",$projectId)' onClick='GoToPage(\"EditProject\",\"\",$projectId)'>Edit</a>"; }
	    echo "  		
				</h4>
			</section>
			<p class='project-description'>$projectDescription</p>
		</div>
		";	
	}

	function PageTitle($title)
	{
		echo "<div class='row'><div class='small-12 columns' style='padding-right:0'>
		<h1 id='page-name'>$title</h1></div></div>	";
	}

	//updates the password for the given user to the new password
	//userid needed for when administrator needs to set a new password for another user's account
	//returns true if successful and false if failed
	function SetPassword($newpassword,$userId)
	{
		$salt = GenerateSalt();
		$hashedpassword = GetHashedString($newpassword);
		$encryptedpassword = GetEncryptedPassword($hashedpassword,$salt);
		//encode the strings to work with the database
		$salt = mb_convert_encoding($salt, "utf8");
		$encryptedpassword = mb_convert_encoding($encryptedpassword, "utf8");
		//update the database to the new encrypted password and the new salt
		include_once 'Database.php';
		$con = Open();
		mysqli_set_charset ( $con, 'utf8mb4' );
		$query = "UPDATE tblUser SET usr_password = '".$encryptedpassword."',usr_salt = '".$salt."' WHERE usr_id =".$userId;	
		//echo "<br>salt:$salt <br>encPass:$encryptedpassword <br>";
		if (mysqli_query($con,(string)$query)) //run the query
		{	//query ran successfully
			mysqli_close($con);
			return true;			
		}
		else
		{	//an error in the query occured
			//echo $query;
			//echo("Error description: " . mysqli_error($con));
			//var_dump(mysqli_get_charset($con));
			mysqli_close($con);
			return false;	
		}
	}
	
	//evaluates if the current password in the database matches the logged in user's password
	function isPasswordValid($password)
	{
		$userId = getUID();
		$dbpassword; $dbsalt;
		$con = Open();
		if (($userId != 0) AND (strlen($password) > 0))
		{
			$query = "SELECT usr_password, usr_salt FROM tblUser WHERE usr_id =".$userId;
			if ($result = mysqli_query($con, $query))
			{
				if (mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_assoc( $result)) 
					{
						$dbpassword = $row['usr_password'];
						$dbsalt = $row['usr_salt'];
						
						$hashedpassword = GetHashedString($password);
						$encryptedpassword = GetEncryptedPassword($hashedpassword,$dbsalt);
						
						//encode it for comparison (db values are already encoded)
						$encryptedpassword = mb_convert_encoding($encryptedpassword,"utf8");
						
						//echo "<br>password: $password<br>dbpassword: ".$dbpassword." <br>dbsalt:".$dbsalt." <br>hashedcurrent:".$hashedpassword." <br>encryptedpassword:".$encryptedpassword;
						
						if (((string)$dbpassword==(string)$encryptedpassword))
						{
							mysqli_close($con);
							//echo "<br>valid";
							return true;
						}
						else
						{
							mysqli_close($con);//echo "<br>invalid";
							return false;
						}
					}
				}
				else 
				{ 
					/*no results found*/ 
					mysqli_close($con);
					return false;
				}	
			} 
			else 
			{
				/* error running query */
				mysqli_close($con);
				return false;
			}
		}
		else
		{
			mysqli_close($con);
			return false;
		}
		
	}
	
	function GetHashedString($input)
	{
		return hash('sha256', $input);	
	}

	//Generates a random string of characters
	function GenerateSalt()
	{
		for ($x = 0; $x <= 10; $x++) {
			$res[$x] = chr((rand(0,255)));
		} 
		return mb_convert_encoding(implode($res),"utf8");
	}
	
	function GetEncryptedPassword($HashedPassword,$Salt)
	{
		return crypt($HashedPassword, $Salt);	
	}
	
	function GetMajorIdByName($majorName)
	{
		include_once 'Database.php';
		$con = Open(); $mgr_id = 0;
		$query = "SELECT mgr_id FROM tblMajor WHERE mgr_name = '".$majorName."'";	
			if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){while($row = mysqli_fetch_assoc( $result)) {
			$mgr_id = $row['mgr_id'];
		}	} else { /*no results found*/ }	} else {echo 'error';}
		mysqli_close($con);
		return $mgr_id;
	}
	
	function GetMajorNameById($majorId)
	{
		include_once 'Database.php';
		$con = Open(); $mgr_name = "";
		$query = "SELECT mgr_name FROM tblMajor WHERE mgr_id = $majorId";	
			if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){while($row = mysqli_fetch_assoc( $result)) {
			$mgr_name = $row['mgr_name'];
		}	} else { /*no results found*/ }	} else {echo 'error';}
		mysqli_close($con);
		return $mgr_name;
	}
	
	function GetCollegeNameById($collegeId)
	{
		include_once 'Database.php';
		$con = Open(); $clg_name = "";
		$query = "SELECT clg_name FROM tblCollege WHERE clg_id = $collegeId";	
			if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){while($row = mysqli_fetch_assoc( $result)) {
			$clg_name = $row['clg_name'];
		}	} else { /*no results found*/ }	} else {echo 'error';}
		mysqli_close($con);
		return $clg_name;
	}
	
	function GetUserIdByEmail($email)
	{
		include_once 'Database.php';
		$con = Open(); $userId = 0;
		$query = "SELECT usr_id FROM tblUser WHERE usr_email = '".$email."'";	
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){while($row = mysqli_fetch_assoc( $result)) {
			$userId = $row['usr_id'];
		}	} else { /*no results found*/ }	} else {echo 'error';}
		mysqli_close($con);
		return $userId;
	}
	
	function GetImage($ImageId)
	{
        include_once 'Database.php';
		$con = Open();
		$query = "SELECT img_image FROM tblImage WHERE img_id = ".$ImageId;
		if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){while($row = mysqli_fetch_assoc( $result)) {
			echo "<img src=".$row['img_image'].">";
		}	} else { /*no results found*/ }	} else {echo 'error';}
		mysqli_close($con);
	}
	
	function isLoggedIn()
	{
		if (session_status() == PHP_SESSION_NONE) {
    		session_start();
		}	
		$con = Open();
		$query = "SELECT ses_id FROM tblSession WHERE ses_session ='".session_id()."' AND ISNULL(ses_expired)";
		$loggedin = false;
		if ($result = mysqli_query($con, $query))
		{
			if (mysqli_num_rows($result) > 0)
			{ $loggedin= true; } else { $loggedin= false; }
		}
		mysqli_close($con);
		return $loggedin;
	}
	
	
	function isAdmin()
	{
		if (session_status() == PHP_SESSION_NONE) {
    		session_start();
		}	
		$con = Open();
		$query = "SELECT ses_id FROM tblSession INNER JOIN tblUser ON tblSession.ses_usr_id = tblUser.usr_id WHERE ses_session ='".session_id()."' AND ISNULL(ses_expired) AND usr_admin = true";
		$bool = false;
		if ($result = mysqli_query($con, $query))
		{
			if (mysqli_num_rows($result) > 0)
			{ $bool= true; } else { $bool= false; }
		}
		mysqli_close($con);
		return $bool;	
	}
	
	function getUID()
	{
		if (session_status() == PHP_SESSION_NONE) {
    		session_start();
		}
		$con = Open();
		$query = "SELECT ses_usr_id FROM tblSession WHERE ses_session ='".session_id()."' AND ISNULL(ses_expired)";
		$uid = 0;
		if ($result = mysqli_query($con, $query))
		{
			if (mysqli_num_rows($result) > 0)
			{
				while($row = mysqli_fetch_assoc( $result)) {
					$uid = $row['ses_usr_id'];
				}
			} else { $loggedin= false; }
		}
		mysqli_close($con);
		return $uid;	
	}
	
	function sendEmail($address, $content)
	{
		
	}
	
	//returns the base64 string of an image
	function image_to_base64($input_file)
	{
		$type = pathinfo($input_file, PATHINFO_EXTENSION);
		$data = file_get_contents($input_file);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data); 
		return $base64;
	}
		
	//takes in the file being uplodaded and the uid 
	function setProfilePic($uid)
	{
		
		$target_dir = "temp/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size (10MB)
		if ($_FILES["fileToUpload"]["size"] > 1000000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
				$uploadOk = 0;
			}
		}
		
		if (!$uploadOk == 0)
		{
			// now that the file has been uploaded you can read the file and add it to database
			// after it's added you can delete it
			include_once 'Database.php';
			$con = Open();
			$query = "UPDATE TABLE tblUser SET usr_picture='".image_to_base64($_FILES["fileToUpload"]["tmp_name"])."') WHERE usr_id =". $uid;
			echo $query;
			if (mysqli_query($con, $sql)) {
				echo "Record updated successfully";
			} else {
				echo "Error updating record: " . mysqli_error($con);
			}
			mysqli_close($con);
		}
					
	}
	
	$NoProfilePictureImage = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAE7CAIAAACkCuS8AAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAAAlwSFlzAAAOwwAADsMBx2+oZAAAAAl2cEFnAAAB9AAAATsAANZovQAALKhJREFUeNrt3dmPZNd9H/Df75x7b61d1Xv3rOSI1AxJiaIXwUGAJALivOQlBvzipwBBXmIgCJD/JI8G8pC8OEAc25JjK7ZgSbYkc0hKXGeGsy/dPTO9V9e+33vPLw+nume4zVRX3VtVXf39QCQoglN97u2q7z31Oxu/+/E6AQDAdFHjbgAAAEQP4Q4AMIUQ7gAAUwjhDgAwhRDuAABTCOEOADCFEO4AAFMI4Q4AMIUQ7gAAUwjhDgAwhRDuAABTCOEOADCFEO4AAFMI4Q4AMIUQ7gAAUwjhDgAwhRDuAABTCOEOADCFEO4AAFMI4Q7wDBMp5nG3AiACzrgbADBBhIhExt0KgAig5w7wBYh2mA4IdwCAKYRwh+nBTMzEX/w3WuNNDqcRau5wsjGTiP1fr1jORHw4KCpCxpj+X+qrg6n2RZlZUIuHEwXhDieSzXRjxIi4jnK08lytHUVEYWg63ZCo14U/SvwXECImCkLjB+YLf4pZK+bnIl8xG6Q8nAQIdzhJmJlIwlBERCmVSrrnV/OzM0ml2HWUTWER8oPw+K9MrXbQ7vpMzMzNdrfVDvwgLFVaRgwRaaWUYsGAK5wQCHc4AZiJiI0xQWBYcTrpnFvJz+VSjqOcr5TUmclz9QA/xc3qHCUO/1+aiESoWm+Xa+1Wx69U261OoDVrpQg1Gph4CHeYaLb8EgRGhFIp98ziTC6byGYSWj2rqke16uirgc1M+ZlkfiZJRJ1ucFBubu3V6s2uUqQVxmlhoiHcYUIxszEShMbRanE+k88mVxazR/30o0yPcD3p177UUeInPOfscm5pLrNXbJRr7Uqtje47TDJ+9+P1cbcB4AuOeuuJhJNOuq+cnbV9Z3o2d2U8DbNPFPv33YP6rQd7nqvtvwGYNOi5wwSxvfXQiKN5dSl76fy8rZ4fZfp49315boIlryxkFfP99UIQiqMZ+Q6TBuEOE8H2f30/dF39+oX5hXzacXVvVmJ0VfWImtprzdJ8ZjaXXN8sb+5WHK2UUijUwORAuMOY9WI9MFrxxbOzZ5ZmkgmHbG896qp6tETIdfS3X1lYmsvc3yg0Wl3P1Yh3mBAIdxgnZgpDYabVxZkLq/l0yqXDrvrEZvrzjbetnc0lv/vtlY2t8n6xwUxKoUoD44dwh/E4GjVNp7zXLs7P5VJ0cmL9qxeSTLhvfGtpYS798HHR90OtUaKBMUO4wxgwcxgapfi1iwvnVnJ0WIQ5WbH+3OUQEYnI0lxmdiZ568Feqdr2XIV4hzHCQgwYKZuDXT/IpL3feetsL9npy7s5nkTMbKvw37288tqF+a5vaIIHDGDqoecOo8PMQRBqrb79yuLq0oxWLCJf2JfrhLNXopS6cCafSrr31wt+EDqORokGRg/hDiPCTH4Q5meS3zo/l8smRWyHfWqC/bkrJRKRxbl0Jn3m3lqhXG27KNHAyKEsAyPi++bM0sw7V87YZJ+COswL2P3fUwn37SurZ5ZmgsBM41MMJhrCHeJlJ5OEobl0Ye7yq4s0eYuSYrtwFiEmvnxp8duvLvoowcNooSwDMWKm0IhW/O1Xl1YWsqck1p+/fCISojNLMwnPuf1wz94NlGhgBNBzh7jYBUqu1u+8cWZlISsipyrZn90HIhGaz6feeeNMwnWC0EzlSANMGoQ7xKKX7I5++8pKJuXZWTHjbtQ474YIZdPeb715Ziad8INQneK7AaOBcIfofSXZp3NWzHHviQh5rn778mouk+j4Ae4JxArhDhE7SvbvXVk9TPZxt2ky2Hx3HPX25dUzSzN+EOLGQHwQ7hAxY8Rz9dtXVtIpF8n+JfZuaEddubR0fjWP+jvEB+EOUbLTY779ysJhnX3cDZpIdoj1tQvzs7mU74fId4gDwh0iw0xd37x+cWF+Nn3KR1Bfyt6bN19bzmUTfoB8h+gh3CEazBQEZnUxa/cCQ1r1w3XU25dXc9lEGGIJK0QM4Q4RYKYglGwmceXS4rjbcpLY8dW3Xlt2HGXMNO/HAKOHcIcIiJCj1RvfWrJr7qFPdv5MwnO+d3mViAxuHUQH4Q7DYmY/MGeXZ9JJTI85NmYSokzau3JpkQjpDpFBuMOwwtDkZxIXz8wSNsYaCBMJ0dJ8ZnVxxhhMMYJoINxhKMxkjFxYzeNU6GHYyZGvv7Iwk0n42B8YooBwh8HZxaiL85nFuQyh2z4kJiJ67eJ8wnXwmIThIdxhCEJE9MrZWUK1eGj2/KaZTOKVc7OY+Q7DQ7jDgJgpMDKTTWRSLhGm8UXABvrKQjafTYahwS2FYSDcYVBCTHR2OYfpjxESIaX40oX5cTcETjyEOwwoNJJOuUuotkfK3sl8NpnNeAFmzsAQEO4wCGY2RnKZhF2GAxESImZ6/eICDuSDYSDcYRAiojQvL2bH3ZApZDvrM5lEMuEYLFqFQSHc4diYyBiZySTy2SShJhMD22FfmssYbJsMg0K4w/ExGZF00iVCTSYWNtBXl2YSrjZm3K2BkwnhDgNyNN48MRIiz9X5XMoYLFiFQeDzCQPKzyTH3YSpJkREmhlfjWAwCHcYBOM4jpHIpL1xNwFOKoQ7HJsx5LnOTMYjjKbGLJVwxt0EOKkQ7jAAYUbPfRRQk4GBIdwBJheenzAwhDsAwBRCuAMATCGEOwDAFEK4AwBMIYQ7wOTCbBkYGMIdYBLZiabZdMLD9jIwEIQ7wOTSmhUzevAwAIQ7AMAUQrgDAEwhhDsMAFsVAkw6hDscm5A4vVowAEwohDscDzMZI5l0QuH4ZoAJhnAHAJhCCHcAgCmEcAcAmEIIdwCAKYRwBwCYQgh3AIAphHAHAJhCCHcAgCmEcAcAmEIIdwCAKYRwh0FgWxmACYdwh0EItpUBmGwIdxiE1njnAEw0fETh+IRmZ5LjbgQAvAjCHQBgCiHcAQCmEMIdAGAKIdwBAKYQwh0AYAoh3AEAphDCHQBgCiHcAQCmEMIdAGAKIdwBAKYQwh0AYAoh3AEAphDCHQBgCiHcAQCmEMIdAGAKIdwBAKYQwh0AYAoh3AEAphDCHQBgCiHcAQCmEMIdAGAKIdwBAKYQwh2Oi4nH3QQAeBmEO/SFibiX6TLutgDAyyHcoS+hkSAw9p/LRhDwI8NMfGjcbYGTxBl3A+AEMCLplPvqublMyiMiPwgTnkPP+vIQIz8wfhAyMwlpjYiHfiHc4eUU85VLS9m0J0RMlEzgbTM651fzqaRLRGFgHu+UfT9EvkM/8CmFF2GmIDBz+VQ27YmIjRUR9NlHxNHqlbOzdHjPQ2MePSk6DqMuBi+Fmju8XK+reJjoSPZREiERsuPYq4szCc8xBtEOL4eeO8BEO3qkHv0NoB/ouQMATCGEO7yQEDPbSZDoNQKcIAh3eBEhUoqb7W6nG4y7LUC+H4ZGMFsG+oFwh5dgoiCURssnIkzSGBd75xst3w9CZDv0A+EOL8MsRvwgHHc7gGqNzribACcGwh1eSoixW9hEwCMW+odwhz4czrOG8UK1HfqHcAcAmEIIdwCAKYRwhz4wVeoYygM4SRDu0BcM5Y0XM4lQrd5WjF3DoC8Id+iLwlDeuIlIYAS/B+gTwh1eQoQUc6PVFUGyjBUTY9IS9A3hDi/HzL4fhiGCZTzsfW+2/I4f4isU9AnhDv0QZixjGh8hIgpCY0KDbIc+Idzh5RRzxw/rjQ5he5nxYkZdBvqEcIc+MIlIq4ONIcdFiKhSbYsRfH+CPiHcoV/YtWp8mIhaHR/JDv1DuEO/sLHJuNgb32h1Mckd+odwBzgZ8HCFY0G4w8vZqe7VehtT3ccJnXY4DoQ79EUpbneCVjsgrKMZLXu3G61usxMohUcr9AvhDn2xx2QfVJpESPfREiKiWr0TYpI7HAfCHfokrLhYbtLh+B6Mhr3bhXITdx2OBeEOfREhxdT1w9Cg3z5qnW5Qq3e0Vqi6Q/8Q7tAvpbjV9gulBmFsb1Tsbe50w8CYcbcFThiEO/RNiJk3d6oGc2ZGRoiItvdrBpv9wjEh3KFfQqQ111vdah2bzIyCEDFTvdndLzYc1GTgmBDucFyyuVMRDKuOgAgRVevtMDRYwQTHhXCHYxAhR+v9UmN7r0pEgs5knOw2+k93q1ozbjUcF8IdjkdEXEevb5bLtTZjq5PY2DR/9LTUavlYuwQDQLjDsTFTEJoHGwd+gGU1cWHmzd3qfrHuOKi2wyAQ7nBsIuRo1Wh17zzaG3dbplat0dnYKo27FXCCIdxhECKiFbc7gcGaphh0/fDGvV1jBAUZGBjCHQbEzB0/bHV8wmYzUQtCIyIY0oBhINxhcIpZMRPhgKDIyOE2YQG2CYPhINxhQMzkB+H2fo2woClqlXp73E2AEw/hDgMSIaX4oNzEyvgIMVMYmnK1pRVqMjAUhDsMTjF3ukGzjbJ7NGyal2vtNs7lgKEh3GFwzByGUrU1BPQzIxIERoQwkAFDQrjDMISZKjVbIEYYRaPV8YkJ34VgSAh3GIIQM7e7AWEfsSgwk4gclJsKkyBhaAh3GJwcnuDR6YbjbsuJ15sE2eg0sZkMRAHhDsMyhrp+QKi6R+Gg3DJGsMEvDA/hDkNh5iA0jZZPRCgTD88PQhTcIRIIdxiSMNNhFQH9zcHZgnu90UHBHSKBcIcI1JvdcTfhZLNpXq136ii4Q0QQ7jAsZq41OoQJM8NgIqKdQl1w+DhEBOEOQxEhrbje7DZaXUKpeFA2z2uoyUB0EO4wLGYKAlOstIiQ7oNrtv2uj10HIDIId4gCU7M3YQaOzXbV9w7qOLYQIoRwh2HZykyl3vaDENk0AGby/XCnUNcKx6VCZBDuEAG7TrVQahKWMh2TvVtdPwzwaIRIIdwhAiKkmLf2qoQ5M8dlazLFRoht8SFSCHeIhlLc6QatNirvx8NM7U6ws19DTQaihXCHaNg5M092KoQpM32zaV6ptTt+iHkyEC2EO0RDhLRWewf1VttHSvWJmYyR7f2aVizot0OkEO4QGRtVO4U6YVi1D/YW7R7Uy7WW1nggQsQQ7hAZ23l/ulOpNTrMKM68hB0+LVVaCgOpEAOEO0TJbm34dKdChNL7i9hu+85+rVBqOA6GUiF6CHeIkgg5jtorNjZ3q8woznwj21nf3q8RvuNAPBDuEDG7YHVzt9Jq+wiur2WfeZu71Xqz6yjGLYI4INwhekqpVie4v3Ew7oZMIiFipnqzu/a0xIxkh7gg3CF6IuI6ulRtPdmuMGbOfBEThUYebBwYEYXPH8QGby6IhYg4Wq09Le4XG3aUddwtmgj2Puzs10rVlqMxjgoxQrhDjLRWd9f2q/UOMxbpkAgx89Zebe1pKeFp3BCIFcIdYmTnhNx5tF+utVFfttvIPNkpiwgGmiFuCHeIkQgpxe2Of29tv9bonOa1Orab3u747U6gtUK2Q9wQ7hAvEXIc3e4Ed9f2x92W8ev4IRNhfReMAMIdYicirFif9qkhQkT1ZtcIHR6IDRCjU/55g1ERMhg/JFKMfWRgRBDuEDs7FTKb9ghz3gFGBeEOI8BGyHE0EaHcDDAaCHcYAWGmVMIlIpSbAUYD4Q6jwMyZlDvuVgCcIgh3iB8qMQAjh3CH2BmRZMLJZjw6XLMKAHFDuMMoMBGj2g4wQgh3iJ3dhAAzvAFGCeEO8WImI5LLJnHqHhFhwzAYGYQ7wOigNgUjg3AHGAVblWq0uqwI84dgBBDuMAo4mMLqdAImxs2AEUC4wyg4Gu80IiJWKMvAiOAjB6Mwm0uOuwmTAX12GBWEO4wCChEAI4Zwh3iJkFbs9raEBIARQbhDvETEdXQ65RL2HgAYIYQ7xI2NYO0OwKgh3CFGTCQiqYTrOHinAYwUPnIQJ+5tCUkYUwUYLYQ7xM4Y5DrAqCHcIXa5bGLcTQA4dRDuECtmIs9zxt2MicHETNj9GEYA4Q4RY3oWXiLiB0Z6ZRkUZ8gY8QMThoYwMRRihi4VRImZwlBCY1xHMZPnOjOZhOfZFUynPcxEKJNykwknCEyt0RERjS13IDYId4gMM/mByc8kVxdnZjKe62hjelNlCB1VIma6cmlJKRaRRst/sl0ulJoKW4lBPBDuEA1mCgKzOJt+8/Vl9VyQiyDWn1GKRYiZs2nvzdeWb97fPSg3HUdhnihEDt8KIRqhkUzae+O1ZcUsz23fjmT/EntD7A26fGkpmXQxVRTigHCHCDCTCeXVc3NasYjgMOyXYra77qiluUxoBPcLIodwh2ExUxDK/GxqfjZNhHl+/bI36txKznO1MeNuDUwdhDsMj8VIKuEy9hg4JhHyXL00lwmNwTMRooVwh6GJsOL5fGrc7TipsIIX4oBwh2EZIddRM9kkYfh0INL7C/cOooRwh6EcberrYlPf47PPwlwm4TpKUNKCSOEDCcPBpr5D01rhKw9EDuEOEcBM7SEpxqMRIoZwhwjkZpLjbsIJ5rk6k/aMYMIMRAnhDkNiEnJ7G2Ch83lstsOutcLNg2gh3GEoIqIUJ5N2kyL0PI+PiYgunskrhR1mIEoIdxgcM4WhWV2ayWeTgnmQA7H3LJtOpFMu9iGACCHcYVhLcxkilGQGZzvsF8/MYokvRAjhDgOye/zO5lL5GSxfGoq9dYtz6UzKw7wjiArCHQYkQlqrV87NMqbxDc3ewNWlbGgEO69BJBDuMCB7ylIeuw5Ewd7AlYXsTNoLsUUkRAHhDoNg5tDI6uIMoUwcEXukai6bMOi8QxQQ7jAIY0w27S0vZAjd9ojYQD+znLMHnoy7OXDiIdzh2JgpNDKXS7qORgxFK5v2lheyYYjVqjAshDsMaC6fJqITtHBp8p9C9kGZn0mGBg9NGBbCHY7ND8zsTNKeznGCOpiT31J7M2cyiZm0p5iR7zAMhDv0RYhERIQ8R3laXZ7PENEJ6l4223692aWT0H9PJ507m5WDWjvhamNvOsDxIdzhJWysa+aE58w76ulB46OHhf/8P64/2qown4yhv9DI5/d2f3V7u90JJnkVqL2Zjf3Gn/787qePCm7HTzg64WpmQsbDcen/+J/+67jbABNKhJjJUey5utLsru3UPt0ovrterFfbJdM1neD7b6zS4TSPyWQvYWOzXKy0kkylSmtxLuNoZf/9pBEhZv75jc37xYYO5epmRRvT6oZpz0l5vfPHRTBREvrijLsBMHGEiESUYtdRfmCqTf/hTuXRTq3R9rXiea2Y1TmtPrhZ+uM/aDGnJjMoiXo5+GS7srFV9lxFRI1W9/rdne9dWfVcPYEpqRQT0ftrhTnFijlj5PpaUUjyae+N83Mrs6l00km6TjcIbTd+wpoPkwXhDs+IEJE4Wiml2t3w8V711pNSreX7odGKU54jJLbzqBR3PP+Hv3z6hz/4tpDw5I1W2l5wudbe2Cq7Tm83XcfRzS/k+wTlo33YVPdqDx/Ulme1EWEmz1VEXG8HH97fqzO/OpN84/zsW0uZlqOMkSAUool7RMGEQLgDiZCQaGbXVUxUqnfvbpafHjSabZ+ZtWLPUSJknqv6GiMrnv7rq1t/+IMLipMTlZJ0WI1ptLo37+9+8d/LUb6/+dpSJuVNTsttS66uFYJkoFRvB7He41YxMc8KFaqtd2+1P896C9nElfOzr+aSNaIgNMbIZJfHYAwQ7qeajWvXUVqx2w2vPSnvVVo7pWarGzhauY6iXp33a/6s1qrV6b57/eBffO/cpJU4mMkPzL21gjGi9RfmFIqI46hWx//k1tZbry0vzKYnpPG9msyjwqLz5VM7pPcX2d9IpdEt1tpPCo3FXHJ5NvU7Z/O+p4nID8yEXAtMAn734/VxtwHGwJZWHKWIaKfUPKh1Hu1Ui/UOEzmOUn1Mg7EB6uj0f/sv/2wCp11dv7tTqrRc9+vX0DKTERKRCcl324Dafu2P/+TD5bmXtISJiFlE/NAQUTbpvro8s5hPnplLe44KQgmNQT8e0HM/XWwfUDF5rm60g/1me32v9sl2NWuMVirhajqsqr/8pYQ8V69v135ze/f33jxjjNi+55gvUIiZHj0plqvfmOz2P1NEhvnWw71JyPdeTeZRIUg9q8l8439Mve9cnqOIqNUNbmwU60SXcsk3Lswu5pK5tBcaCUMhDLqeYgj306I3oqiZmRNBeGurcnW9qNq+CC04irRDA6yXEVqZVx/d2f29N89MQk/RBvTWXnVjq5zwnBdfjtBhvj/Ye+v1Mee7/bEbO9V5xf2vs7LXp5gTrkqQHNQ6797a6br6nZWZy+dmc2nPfrsSQUX+NEK4Tzk7WKqY7VzAcr17be2gWG/XWr6jWB9W1Qdb2GNEkp7zj58Wfv93i1cuzhsRNebOLx+Um4+elDy3rx3NevmuxpzvtuVE7V/fLufS2hz/d2Ev1nWYiF0jNx+X1vfq+bR3cTn726u5tqtDI4ERGnf1CUYJ4T61jrrqjtaJILy5Xd3Yr+9XWu1uqDV7jiKJYK0mMy3k5N0bm1cuzo/3Ypmp1ujcerh3rHmZz/J9fPUZ+xPf+7xYb3bnZtyBT9o7+m2mPMcPzE65uVNu3t+qzGcTr53JrcymFZNvp9Yg408BhPsUsmHhaFaK9yvtQrW9vlvbq7SYydHK9mqjWsxujCQ95+qN4n/4t02t0mOZWShEzNT1w3trBRJS+ngPrWf1mTHlu/1RNx7uL+Sj2fumN0f+2dSazo3d2ltL2YtL2ZXZVDrhhsYEqMhPO2w/MFVsKiVcHRqptfxrjw7+4cH+3n697Yeeo3Q8A55aczHsSpe/e2lRxrGmxv68G/d2a82O4+jBnluKiJj3i41s2kunvJHl+2FNpvMnf/UgnYz+9TWzo1WCqVTvrO/VnhaaQuQ5OpXQWqvQIOKnFnru06C3t5dSnqOSgbmzV7v9pHxQaxsjs1qpw5Wlcf10Iyue8/OP9/7oX39LsSuj3VzXfle4t16o1tvDHB4yrvFV+1M+uFWsNruzQ9RkXnBd1KvIKyaut/0P7+81lfrOUuaNc7OX8sk6cRCaUIRRrJkuCPeT7WjDAEfrRtu//aS6tlurNDpE5GilHf7SytJY2kDkOKpSbP/ys50f/NYFMcKjmhPZ2z1mp7K5W33p9Jh+LsTm++2He6+emzu/mh9Blcm+/vUHe4sR1WS++V6RHC52dYUe7dQ2D5r5tHtpJffOas73nNCIHxjsZzA1EO4nlc0111Gziu8Vmw+2K/vVdrneeenK0pgaszyn/vwXT37wW2eUckbTebcFjb2DxvpmKdHf9JiXv2Yvbfn+xkHXD791YT7WfD+qyfz6VnlmoHkyA1ygfYTYO1aodvYquw+2K4u55MWlmcvz6QazH4YYdJ0CCPeTR4S0Yu2ojh9uFRsf7NXX92odP3QdlfScsez8LUKeox/vNa49KL3z+tIICho2c5st/956gYkjv+KE5zzeLhNRrPneq8ncPIipJvPiH0292ZNOudE9qLU/3a6+tZg5t5A5O5/JJJ0Ay6BOOIT7idFbXKrY0dxo+6V659raQbHeISHXUSnPGfupPUuz/MvPnrzz+tII+nzM1O4Enz/YJRKloj+RTkQ897l8j+m7CBMR3dooLuRivl/feJlkNyZztOOJPN6vr+3WZjPe5XOzFxazmaTDRL4Rmpjt1aB/CPcT4KiwTkSpwHywXvpws5IKQmb2DiswI/hG/2JGJOU5v7pW/P3fPfjOpYURLGi6v1FotXw3ooLMV30p3+P4EYqZKLyxW3UdNcYH8/ODrh5xvR18/GD/V48O3l7OvnVxLpfytMN+YMa7SA2OC+E+0ezCcddRiqnc6H62dlCotBqdIKuUOlpcOjmYFvPy2f2971xaiPGeEDHR/fVCsdyKL9l7P0vEc52NrTIzXzo/F219xmblrfXy07XmxWVn7I9n+uKga17o4U718X59Lpu4fDb/3eVs23W6gQmNwbyaEwHhPqFsNdZzdU7o053q00Jjt9w8Wlw6ysHS/hkjqYTzd7/e+cMfXEglsjFV3u0r1ptdVjyK865FHK2SXgyfFCFiuv5wfz4nNJJL6b9dtjH2nbZfae2VW3c3k4u51BvnZ/MZLwyN3bEGET/JsIhp4tjxUs/RfmAe79c/eFS49bhUanQVs6N5As88ep5SXBFfBfzdS4sSz4QLmylK8UGpEfc+lMzkh2ZlMftq1N126m3lFf73v7nvqHASNtT8Jlqz1txoB7vl5tNCveMbR3E64bpa2fUTiPjJhJ77pDgcLyVXq0bHf7rduLtZLtW7iu0RDTzu4dL+rkJk2XOurh38EflKxbKgyUbJykJ2v9golpvOV462iPRySCs+t5InivhKbE3m5lp5t9g6vzQRNZkX3AQicjS72mn74bW1g6sbxe8sZN66ODeTclMJxw8MIn4CIdzHzxY6Xa2YORWEHz4pfvCklOiGSvHRBusT9KX9ZdfiOmpjvfGzj7b+zfdfiWlBk42S8yv5UqUVXyra/XLPreSy6bhO47v+cG92ZrJqMt/kaHvRhKs8kSeF+tODRpBw/uWlhbeXsg17pqsxjGr8xEC4j9NRrM9pvVZtX1s7KNU79bafUaxcPcgG6xNARM4s6B+/t/Vvvn9BqVhOaGImEZrNJc8sz2zuVofZdeAF7J5or5ydpajnektvnkzw/ufFxFjnyQzS+MN5NUTEneD9O7vX1w8uLmX/+cX5IOEEoQlCg+3jJwHCfTzkcMAqr/husfH+dnXzoNHqhs6z8dKT9IH/0qW5jt4qNK49KLzz+nJM8+fsS55bye0V6nHcK2YOAnPxzIzr6Mi77Xao+fO18m5p0msy33wJRERaMTE128HnG6Un+42lfPL1M/nL8+mykSBErWbMEO6jZt/xnqOMyOP9+l6l9fFmJRmErqsTkW7GO0ZMNJ+jv/z48TuvL8c3M1qEUgn34tnZB4+LfZ7O0T9jJJlwzizNUGxLNK8/2J87ITWZb2LrhVqx1qrR8ctbncf79UfLMxeXs6tzacV8uJHBuBt6KiHcR0eEiMlzVBCarWLz7mb55n59hijnKDUB60sjZE9ounOzvL9ZXjo3G2vn/exybu+g0Wh1tYpsEwJm9oPg4pm860bfbadeTYau71YdHeNo8MjYNVCK2S6Tvr9V+WS7cmUu/falhXzaS7raD83YjyA/hRDuo2A/wK6jjMhuuXV9/eBusZlnWnR702BO4hfzF2Oihbz85POtf39uNr6fIkJK8aXzczfu7RAf4/TRF7c8DE0umzy3kqMYuu025sq71adrjaXZE1ZwfzH7NvZcvUCyXWrulFsm6fyrby1+ZzHbdJQfmtBgjevoINzjdRTrOaJ7pea1tYODatuILLpH60un57P9PNt5/9sPdv7db1/IL8/EtaCJiYjm8qm5fLpUbTk6ik1mmIzIhdW81iqObrt9zauPCn4yUMob5WZho/FsxFUoaAfv3tq5mU2cmU+/eX42k3T9wGBSzWgg3OPSGzJ1VZ7o+l79/lZ5t9wyRlytNEe/0dUE0opN2v/Fvd0/WJ6Je2zttQvzn9zaiuBIWKIwlFw2sTiXoXiq7Xa90ntrhaVBD406EXqz4xUTUane2a+0nuzXzy1kLp/Lz2US3dCEmFQTs1hmqp1yRzNh5jRv7NX+7/Wtf7q5vVVsambXUTJpG8LExoises5Pfr1D1FXRFcS/SoTSKffcSi4IzbBhwWREzq/k7WzLGJoqRFTaqa4/qI93s7DREHuWi+KU59Tb/o2N4s8+27y2flBtdhOutt+0pv0ejA3CPUr2uDvXUcy0VWz8+PPtv7mx/bhQdxR7pynWe3dDyHFUodL8uw82iUhiqz/YQL+wmk8mnGGqHMwUBCaXSSzOx9Vtt2+Aq48KYSqY5C0HIr7qwxW5ac9pd4OP7u//xSdPfn13r1TvuI7qRfy4Gzl9EO6RMSJa8YKri7XOP1zb+tFnm08L9UVXncJYPyJCK3P6nx7u02E5Ir4f5Djq4pnZYTrvIqSUeuXcLMf2+zqqySxOdU3mmxgRZk55TkboztPyn3385IM7u7WW7zrKUWym/ovMaKHmHgEjopVadvVatf2rtYPdcrMbmAV38rbkHTkRSbj6/t3KR3d2vv/GanwbgttXPbM0U6139g7qgz1IjJFM2pvPpymubrswc2mnuv6wvjI3/TWZb2JEmMhz9ZzI/a3K+l7t3ELmnUsLsxkvCLGHQWQQ7kMREaU47TmlWufXG0W7ytRzlBfnblYnixAtz/KPPn3y/TdWRzAN7vKri81Wt94cZNq7Utxs+Y1WN5Py4tjy7GiejElN5zyZY96N3rxJEVnfrW2Xmmfn0t99ZX4xn+z6JjQGCT8khPuA7Ac14ep6O7i7Wbm/WSk3OokpWmUaFdt533hQK+9UZlfzsS5msb+U3gkeA017F+kdHEoxpLu98I3d6rxSqDFbhxGvjJGHO9X9avvyufz5hcxcNhmEJjSChB8Yau6DOBo1Xdut/fTTpx/e22t0/JTnEJ3gPWHiw4qzqfAvP3oc+w9iMiJdP+SBJpsyszFSqbWJKPL1B/ZxE5rWR3cqnqunb9naMOzNSB0Ot/6fT57efFxsdQNHM5362ubAEO7HIyLM5Lm6UG399NPNX32+bWNdMePj+k3sCU0/+3i/4zcGi93++X7YbvsDD94KUUwTN+xT/70bB412V2t0R7/G0XBr1shHD/b/9Dcb97cqC4rdST16bMIh3Ptl316eqzOh/Orz7Z9+ulmotjxXa8R6H5RiyoR//5sdijE9iYjanWCIX4coRZVah2JYXWNf8PqjwmIumm0SppWx/SdH50Q+erD/vz58fG+zvOLZSfG4cceAcO+LEdGaFxx1f7Pyvz96vL5bYya7CAVvt36IkWVX/9U/bRJ1VFyddyGidicIwkHL+kJEHIYm+paJLRmhJtMvOzajmcuN7m/u7f/o+mah2rYn2eLe9Qnh/nIilPScVif46d3dn9zZbXYDz9WEUuBxCJHrqEqj/Q+f7FJcIxNMRPVWl5kGSwB7hkanG3T9MOLL79Vkio0WajLHIESuw67DG3v1H362+emjAhOdkt07hodwfxERYiJH8/pu7aefPr37tLzkas34ejgII7Q6r392e4dI4lvQ1OkGw/xxe7Re5J13+0Xi+sP9hTxqMsdjy6EJV88y/cP9/Q8f7GeNqHg2h5gyCPdv1CvFKP7g7t6Prm+2ukHSc1CHGZiIJDx993bl/ZvbdLg9bISYyRhptnylhurZiUi7E1B038xEbMG9/eGdSgI1mYHYz93ZpHt/q/I/P3uaJ1IK+f4SCPevZ4ykPKdc7/zpR48fbldWPY35MBEQWpnjD2/vEBFHv0iIjEgQmmFemZlDY5ptv9fcSC5ahIiu3jiooyYzHCPiOSqod/7skyfZUByNj+SLINy/hhFJJZx7m+Vf3Ngu1Tueo7GxUSSMSDKhP7hZ3t8sM0dZebev1Gr7QTDkxpDCzIfhHk0Q2/Z8/qiwmMdo4LBEyNFcqnf+6sZWqxt48ZyNPh0Q7l8mQklX331a/vu7e61ukHDwPTpKTJzPhj/8aCOOF+90w9AMu+svE7U7fu+fhia9SZDBzULddTQ6CcMTIc/RO6Xme7d3m21fK2z18fUQ7l9gJ3U83K7+5O7unGJ874ucEUm4zvs3S0StyBc01ZudIV/B1sf9wIhIJP1226+88ai8vdF0p+LE1Elgv1tvHjTevbUzxziA++sh3J+xFb21nepf39pZ0iq+fV9POa254/k//OVTinpBUyRTGJXidtuPbDakENl5MrkYtiI7xeyo2E659be3dxfw1Pw6CPceYySdcB5uV398e2fVUYTqaGyMkRVP//XVLaJ2VAua7MFJ9UY3khcUot72YUO/jlJMFL7/edFufxjBpcIhI5Jw1cOd6q/WDhKuwpfsL0G4Ex2e5vy00Pj4wf6iYsJc5JhprVqd7rvXDyi6BU29qTJD946ZOQhMrdmhob+6HdZkSnsl1GRiIUKeo65uFHdKrQQen1+EcCcRcrUqVFvv3d7p+EZhfCZ+IrI8p/7yl4+JzPALmuzvq9HsdrpBFHvCCEU6k+fag7151GRiw0xzTP/v5nal0XXwBH0Owp2Uokxo3ru92+gE3ik4s3gS2C3YHu/WfnN7l4giObYiCEO7Z2ckytX2sNdIpJiJgvdvllCTiY8IaaV0x//sUSFHeIg+c9rDXYQU80/u7JXqHcx6HCmhlXn10Z1dimALRiGiSq0jQpF8uJkoCA0Nd9ieTfPrD0v7pRZqMrEyIknXub5b++BJKeGg+N5zqsPdiCQ9/aTQuLZXxV59I2bHOf7x08Ldx0V7yMYQL8ZE5AchDbpl2PPsMdn1ZjcYcocZISK6/7SkZwy6k3ETkXlH3duseN1Qq1Mda0dO710QIkepcqPzycP9BY2NKsaAmRZy8u6NzeFfh4hqjYg3Ex7ypexYwqeb5QVH480VNyHSihtt/x8fFrCtmHWKw13EddTaTq1c7zpK4c0wesZI0nOu3iiGpjlkLkdb0VaKut2g1hh8woxtT3Gn+vBezXMxkDMKtvj+tFB3OoGjj308+vQ5veGuFdda/qOdKmbIjpHW3NSdv/jFExp0QZP9M82W3xridL2vfdlhEtn+0asP9yUTxncgOHyJUtz2w18+KuDzTKc23EXE1frOk1Kl2UWFbozEyIrn/PzjPSJf8UC9LSEi8sPoH9DV+uATZpRiIrm6VlhETWaERMTV6vO9erXZddRp77yf0lxj5sCYQq2tFWMvpzESIsdRlXr7l5/tEJEMMidSiKhab4dm0NP1voEfDDigarv8he3q44d11GRGjJkyIlsHTX3qB9JOY7jbsZdKo1usdbDqYezsgqY//8UTokAN0ttiIvJ9M/Dpel/XJlLMrbZPA82GtO+o9x7umzRqMiMnpBXf3SzXW7463V/KT+XFi2jFxVrbH3bvb4iAXdC0W2xce1Ci41e6j6bKMEe2a4QQMVOnGw62usrWZN5bP0BNZvTsLLhaq7tbbrr6VJ+IeSrDnViI9ittIcKCtokgtDTLP/7sCQ20oCkMjd1VJsLPMTP7QWhP7TjWy/ZqMlvVDdRkxsR+rqtN/5Tf+tMY7vYQ5INaW2NC7GSwq8lufF6q7lb5+J33jh+2O76K9FsYc++ZQXS8dO/Nk3m0L6jJjIuIo3htt9rxw2jfFSfLaQx3mEDMPJs1P76+ScfJUpuk7bYvEv1XMCFq9c7bO96FENHGTnVeKwzVj4XdabnVCSuNrtYRHwhzgiDcYSIYI8mE8zfv7ewWG4r7L5UKEbU6QWhM1OfxsAgd96RsEWKmg0rr47tVD1sVjQ8z+6Ep1jqK+dQezfD/AXlNpqU6xkDrAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDEyLTEwLTIxVDA4OjU0OjQ4LTA0OjAwhztH3QAAACV0RVh0ZGF0ZTptb2RpZnkAMjAxMi0xMC0yMVQwODo1NDo0OC0wNDowMPZm/2EAAAAASUVORK5CYII=";

?>