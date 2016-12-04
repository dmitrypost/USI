<?php
	include_once 'Functions.php';
	PageTitle("Run SQL");

	function FormattedPage($query,$results)
	{
		echo "
	<body>
		<div id='sqlBox'>
					<div id='QuerySql'>
						<p class ='queryTitle'>Query:</p><br>
						<textarea id='txt_query'>";
		if (strlen($query) > 0) { echo $query; }
		else { echo "Insert query here..."; }
						echo "</textarea><br>
						<button href='javascript:alert(\"\")' onClick='var qry = $(\"#txt_query\").val(); var request = $.ajax({url:\"/PHP/RunSQL.php\",type: \"post\", data: \"Query=\" + qry});
	request.done(function (response,textStatus,jqXHR) {
		console.log(response);
		replaceHtml(\"BodyPanel\",response);
	});'>Run</button>
					</div>
					<div id='resultSql'>
						<p class ='queryTitle'>Results:</p><br>
						<table  cellpadding='15'>
			  				<tbody>
				";
		if (strlen($results) > 0 ) { echo $results; }
		else { echo "SQL query results here."; }
						echo "
							</tbody>
						</table>
				</div>
			</div>

	";

	}

	if (!isAdmin())
	{
		echo "<p class='alert-box error'>Access Denied!</p>";
	}
	else
	{
		if (isset($_POST['Query']))
		{
			$con = Open();
			$query = mysqli_real_escape_string($con,trim(strip_tags($_POST['Query'])));
			$query = str_replace("\"","",$query);echo $query;
			if ($result = mysqli_query($con, $query))
			{
				$queryResult = "Number of rows affected: ".mysqli_affected_rows($con);
				if (mysqli_num_rows($result) > 0)
				{
					$columnCount = mysqli_num_fields($result);
					$columns = "";
					for ($x = 0; $x <= $columnCount -1; $x++) {
						if (strlen($columns) == 0)
						{
							$columns .= mysqli_fetch_field_direct($result, $x)->name;
						}
						else
						{
							$columns .= "|".mysqli_fetch_field_direct($result, $x)->name ;
						}
					}
					$columnsArray = explode("|", $columns);
					$queryResult .= "<tr>";
					foreach($columnsArray as $key=>$column) {
						$queryResult .= "<th scope='col'>$column</th>";
					}
					$queryResult .= "</tr>";
					while ($row = mysqli_fetch_assoc($result))
					{
						$queryResult .= "<tr>";
						foreach($columnsArray as $key=>$column) {
							$queryResult .= "<td>".$row[$column]."</td>	";
						}
						$queryResult .= "</tr>";
					}
					FormattedPage($query,$queryResult);
				}
			}
			else
			{
				FormattedPage($query,"The query has an error in the formatting please try again.");
			}
			mysqli_close($con);
		}else
		{
			FormattedPage("","");
		}
	}
?>
