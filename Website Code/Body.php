<?php
/*
	Body.php
	the body panel php which gets the proper page based on what was posted to it.
	will get profile from Profile.php, Project from Project.php, Edit project from Edit.php

	if the Index.html page recieves a uid=1 in the url then this page will pull the info and return a user's profile
	uid: profile content to return		example: localhost/?uid=1
	pid: project content to return		example: localhost/?pid=1
	eid: projects content to return		example: localhost/?eid=1
		if eid = 0 then show all projects
	s:   user's search string			example: localhost/?s='USI Project Repository'
	add to history upon ajax change of page
	http://stackoverflow.com/questions/824349/modify-the-url-without-reloading-the-page
*/
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    { 
		if (!empty($_POST['uid']))
		{
			include 'Profile.php';
			// ^ Profile.php can read same post data as this page. no need to pass it in a post again
		}
		elseif (!empty($_POST['pid']))
		{
			include 'Project.php';
		}
		elseif (!empty($_POST['eid']) && !empty($_POST['sid']))
		{
			// user has to be logged in to edit a project... thus make sure session id is passed
			include 'EditProject.php';
		}
		elseif (!empty($_POST['s']))
		{
			include 'Search.php';
		}
		else
		{
			//default page
			echo 'Default landing page';
		}
	}
?>