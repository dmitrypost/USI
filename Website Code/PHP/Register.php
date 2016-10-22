
<form id="registerForm">
	<input type="hidden" name="registerForm"> 
	<table width="300" border="0" cellpadding="0">
      <tbody>
        <tr>
          <td>First Name</td>
          <td><input type="text" name="firstname"></td>
        </tr>
        <tr>
          <td>Last Name</td>
          <td><input type="text" name="lastname"></td>
        </tr>
        <tr> 
          <td>Email</td>
          <td><input type="email" name="email"></td>
        </tr>
        <tr>
          <td>Password</td>
          <td><input type="password" name="password"></td>
        </tr>
        <tr>
        	<td>
                <select name="college">
					<?php
						include_once 'Database.php';
						$con = open();
						$query = "SELECT clg_name FROM tblCollege";
						
                    ?>
  <option value="volvo">Volvo</option>
  <option value="saab">Saab</option>
  <option value="mercedes">Mercedes</option>
  <option value="audi">Audi</option>

			    </select>
			</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input class="button" type="button" value="Submit" onClick="ProcessRegistration()"></td>
        </tr>
      </tbody>
    </table>

</form>
