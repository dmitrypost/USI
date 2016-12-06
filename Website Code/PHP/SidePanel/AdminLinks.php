<?php
	include_once './PHP/Functions.php';
	if (isAdmin())
	{
		echo "
			<button class='alink' href='javascript:void(0)' onClick='GoToPage(\"AlterCollegeMajor\")' title='Alter colleges and or majors'>Alter Colleges & Majors</button><br>
            <button class='alink' href='javascript:void(0)' onClick='GoToPage(\"AlterHomePage\")' title='Alter Home Page'>Alter Home Page</button><br>
            <button class='alink' href='javascript:void(0)' onClick='GoToPage(\"RunSQL\")' title='Run SQL query upon database'>Run SQL</button><br>
			<button class='alink' href='javascript:void(0)' onClick='GoToPage(\"ProjectApprovals\")' title='Approve pending changes to projects'>Project Approvals</button><br>
			<button class='alink' href='javascript:void(0)' onClick='GoToPage(\"UserManagement\")' title='Change password of users and go to edit their profile'>User Management</button><br>
			";
	}
?>
