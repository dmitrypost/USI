<?php
<select id='pjh_id'>";
include_once 'Database.php';
          $con = open();
          $query = "SELECT pjh_id, pjh_approved FROM tblProjectHistory ";
          if ($result = mysqli_query($con, $query)){if (mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_assoc( $result)) {
              if ($row['pjh_id'] == $ProjectMajorId)
              {
                echo "<option value=".$row['pjh_id']." selected>".$row['pjh_approved']."</option>";
              }
              else
              {
                echo "<option value=".$row['pjh_id'].">".$row['pjh_approved']."</option>";
              }
          }
          } else { /*no results found*/ }
          } else {echo 'error';}
    mysqli_close($con); echo "
</select>
?>
