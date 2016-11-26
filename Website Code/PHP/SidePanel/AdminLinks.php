<?php
	include_once '/PHP/Functions.php';
	if (isAdmin())
	{
		echo "
			<a class='alink' href='javascript:void(0)' onClick='GoToPage(\"AlterCollegeMajor\")'>Add/Edit/Delete Colleges & Majors</a><br>
            <a class='alink' href='javascript:void(0)' onClick='GoToPage(\"AlterHomePage\")'>Edit Home Page</a><br>
            <a class='alink' href='javascript:void(0)' onClick='GoToPage(\"RunSQL\")'>Run SQL</a><br>
			<a class='alink' href='javascript:void(0)' onClick='GoToPage(\"ProjectApprovals\")'>Project Approvals</a><br>
			
			";	
	}
?>