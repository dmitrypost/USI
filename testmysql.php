
<?php
$mysqlhost = gethostbyname ('mysqlsvr.ddns.net');
$con = mysqli_connect($mysqlhost, 'user', 'password', 'usiprojectrepository','3301');

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
//get the textbox data
$strSearch = "Computer";
$sql = "SELECT pjt_name, pjt_description, pjt_pageview, dep_name FROM tblProject INNER JOIN tblDepartment ON pjt_dep_id = dep_id INNER JOIN tblKeywordAssociation ON pjt_key_id = key_id INNER JOIN tblKeyword ON key_kwd_id = kwd_id WHERE kwd_name LIKE " & $strSearch;
//print($sql)
//$sql .= "SELECT Country FROM Customers";//concatinates to the same variable

// Execute multi query
if (mysqli_multi_query($con,$sql))
{
  do
    {
    // Store first result set
    if ($result=mysqli_store_result($con)) {
      // Fetch one and one row
      while ($row=mysqli_fetch_row($result))
        {
        printf("%s\n",$row[0]);
        }
      // Free result set
      mysqli_free_result($result);
      }
    }
  while (mysqli_next_result($con));
}

mysqli_close($con);
?>