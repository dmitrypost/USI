<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Profile Document</title>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://www.usi.edu/f4/css/foundation.css">
    <link rel="stylesheet" type="text/css" href="../CSS/foundation2.css">
</head>
<body>
    <div class="row">
        <div class="small-12 columns" style="padding-right:0">
            <h1 id="page-name">Edit Profile Page</h1>
        </div>
    </div>

    <h5 class="descrTitles">Change Legal Name</h5>
    <form action="demo_form.asp">
    First name: <input type="text" name="FirstName" value="John" maxlength="20" size="20"><br>
    Last name: <input type="text" name="LastName" value="Doe" maxlength="20" size="20">
    </form>

    <h5 class="descrTitles">Change Major</h5>
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

    <h5 class="descrTitles">Change Contact Information</h5>
    Phone Number: <input type="text" name="PhoneNumber" value="812-123-4567" maxlength="10" size="10"><br>
    Email: <input type="text" name="Email" value="account@service.com" maxlength="30" size="30">
    <br>

</body>
</html>
