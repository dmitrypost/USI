<?php
	include_once '/PHP/Functions.php';
	echo "<button class='alink' onClick='GoToPage(\"Projects\",\"\",\"All\",\"\")' title='All approved projects'>All projects</button><br>";
	if (getUID() != 0)
	{
		echo "<button class='alink' onClick='GoToPage(\"Projects\",\"\",\"Owned\",\"\")' title='All projects participated in'>My projects</button><br>
		<button class='alink' onClick='GoToPage(\"Projects\",\"\",\"Pending\",\"\")' title='All projects pending'>Pending projects</button><br>
		<button class='alink' onClick='GoToPage(\"Projects\",\"\",\"ChangesPending\",\"\")' title='All projects pending'>Changes pending projects</button><br>";
	}
?>
