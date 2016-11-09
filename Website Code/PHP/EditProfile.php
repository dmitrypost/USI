<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Profile Document</title>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../CSS/foundation2.css">
</head>
<body>
    <div class="row">
        <div class="small-12 columns" style="padding-right:0">
            <h1 id="page-name">Edit Profile Page</h1>
        </div>
    </div>

    <h5>Change Legal Name</h5>
    <div id=editprofilenames>
      <form action="demo_form.asp">
      First name: <input type="text"  value="John";><br>
      Last name: <input type="text" name="LastName" value="Doe">
      </form>
    </div>

<h5>Change Profile Picture</h5>

<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
    /*
    foreach ($_POST as $key => $val) {
      echo '<p>'.$key.'</p>';
    } */

    include_once 'Functions.php';

    $con = Open(); $pageview = 0;
    $usr_id=getUID();
    $query = "select usr_picture FROM tblUser WHERE usr_id=".$usr_id;

    if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){ while($row = mysqli_fetch_assoc( $result)) {
      echo "<p>
      <row>
      <a class='Participant' >
        <table>
          <tr>
            <td>
              <img class='userPic Left' src='".$row['usr_picture']."' alt='No Profile Picture'>
            </td>
            <td>
              <a onClick='showProfile(".$row['usr_id'].")'>".$row['usr_fname']." ".$row['usr_lname']."
              <br>".$row['rol_name']."</a>
            </td>
          </tr>
        </table>
      </a>
      </row>
      ";
    }	} else {
    /*no results found*/
      echo "No participants found for this project";
    }	} else {echo 'error';}

  mysqli_close($con);

  }
?>

<h5>Change Password</h5>
  <div id=editpassword>
    <input type="text" name="password" value="********">
  </div>

    <h5>Change Major</h5>
    <div id=editmajor>
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
  </div>

  <h5>Change Academic Status</h5>
  <div id=editstatus>
      <input type="radio" name="Undergraduate>" id="Undergraduate" value="Undergraduate"> Undergraduate<br>
      <input type="radio" name="Graduate>" id="Graduate" value="Graduate"> Graduate<br>
  </div>

    <h5>Change Contact Information</h5>
      <div id=editphone>
        Phone Number: <input type="text" name="PhoneNumber" value="812-123-4567"><br>
      </div>
      <div id=editemail>
        Email: <input type="text" name="Email" value="account@service.com"><br>
      </div>
      <div id=editlinkedin>
        LinkedIn: <input type="text" name="linkedin" value="account@linkedin.com"><br>
      </div>

    <br><input class="button" type="button" value="Submit" onClick="ProcessProfileChanges()">
      <img src="http://www.w3schools.com/jsref/w3javascript.gif" onload="ProfileChangesLoaded()" width="0" height="0">

</body>
</html>
