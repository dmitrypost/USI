<?php
	include_once '/PHP/Functions.php';
	if (isAdmin())
	{
		echo "
			<button class='alink' href='javascript:void(0)' onClick='GoToPage(\"AlterCollegeMajor\")' title='Add, edit, or delete colleges and or majors'>Add/Edit/Delete Colleges & Majors</button><br>
            <button class='alink' href='javascript:void(0)' onClick='GoToPage(\"AlterHomePage\")' title='Edit home page'>Edit Home Page</button><br>
            <button class='alink' href='javascript:void(0)' onClick='GoToPage(\"RunSQL\")' title='Run SQL query upon database'>Run SQL</button><br>
			<button class='alink' href='javascript:void(0)' onClick='GoToPage(\"ProjectApprovals\")' title='Approve pending changes to projects'>Project Approvals</button><br>
			<button class='alink' href='javascript:void(0)' onClick='GoToPage(\"PasswordManagement\")' title='Change password of users'>Password Management</button><br>
			<button class='alink' href='javascript:void(0)' onClick='GoToPage(\"UserManagement\")' title='Manage users\' profiles'>User Management</button><br>
			";	
	}
?>