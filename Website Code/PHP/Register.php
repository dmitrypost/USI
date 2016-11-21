<?php include_once 'Functions.php'; PageTitle("Register"); ?>
<form id="registerForm">
	<input type="hidden" name="registerForm"> 
	<table width="300" border="0" cellpadding="0">
      <tbody>
        <tr>
          <td>First Name</td>
          <td><input type="text" id="firstname"></td>
        </tr>
        <tr>
          <td>Last Name</td>
          <td><input type="text" id="lastname"></td>
        </tr>
        <tr> 
          <td>Email</td>
          <td><input type="email" id="email"></td>
        </tr>
        <tr>
          <td>Password</td>
          <td><input type="password" id="password"></td>
        </tr>
        <tr>
        	<td>
               
			</td>
        </tr>
        <tr><td></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td></td>
        </tr>
      </tbody>
    </table>
    College<br>
	<select id ="slt_college" name="slt_college" >
		<?php
            include_once 'Database.php';
            $con = open();
            $query = "SELECT clg_id, clg_name FROM tblCollege ";
            if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc( $result)) {
                echo "<option value=".$row['clg_id'].">".$row['clg_name']."</option>";
            }
            } else { /*no results found*/ }
            } else {echo 'error';}
			mysqli_close($con);
        ?>
	</select>
    <br>Major<br>
    <select name="slt_major" id="slt_major">
    	<?php
			include_once 'Database.php';
			$con = open();
			$query = "SELECT mgr_clg_id, mgr_name FROM tblMajor";
			if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0 ) { while($row = mysqli_fetch_assoc($result)){
				echo "<option value=".$row['mgr_clg_id'].">".$row['mgr_name']."</option>";
			}
			} else { /*no results found */ }
			} else { echo 'error';}
			mysqli_close($con);
		?>
    </select>
                
	<br><input class="button" type="button" value="Submit" onClick="ProcessRegistration()">
    <img src="http://www.w3schools.com/jsref/w3javascript.gif" onload="RegistrationFormLoaded()" width="0" height="0">

</form>
