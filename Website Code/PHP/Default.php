<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Project Repository Home</title>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://www.usi.edu/f4/css/foundation.css">
    <link rel="stylesheet" type="text/css" href="http://www.usi.edu/css/departments.css">
    <link rel="stylesheet" type="text/css" href="CSS/foundation2.css">
	<script src="http://www.usi.edu/f4/js/foundation.min.js"></script>
	<script src="JS/EarlyBindingFunctions.js"></script>
    <script src="JS/ProcessRegister.js"></script>
    <style>
	.descrTitles, #homePage_title{
		color:red;
	}
	p{
		font-size: 16px;
		margin:0px;
	}
	#homePage_title{
		margin:0px;
	}
	#homeHeaderImg{

	}
	#leftpics{
		float:left;
		width:50%;
		border-style: solid;
		border-color:red;
		margin:0px, 15px;
	}
	#rightpics{
		float:left;
		width:50%;
	}
	#smallpics{
		float:left;
		clear:both;
		/*border-style:solid;*/

	}
	</style>
</head>
<body>
<div>
    <h1 id ="homePage_title">Project Repository</h1>
    <p>Welcome to University of Southern Indiana Project Repository.  Here, you can find projects completed by students inside and outside of the classroom.</p>
     <!---------------------------------------------------------->

    <h3 class="descrTitles">Our Featured Projects</h3>

    <div id ="homeHeaderImg">
    	<?php
	        include_once 'Functions.php';
			GetImage(1);
		?>
        <h5 class="descrTitles">Our 2016 Alberta Energy Challenge Team</h5>
        <p>We cou't be more proud of ourr 2016 Alberta Energy Challenge team and faculty advisors Jeanette Maier-Lytle and Dr. Brandon Field! Check out the impressive statistics of the case teams that have represented USI Romain College nationally and internationally. </p>
    </div>

    <div id ="smallpics">
    <!---------------------------------------------------------->
        <div id = "leftpics">
            <div id = "homeImg1_Row2">
            	<?php
					include_once 'Functions.php';
					GetImage(2);
				?>
                <h5 class="descrTitles">Three Earn Toastmasters Designations</h5>
                 <p>Three USI Speaking EAgles club officers earn Toastmasters certifications.</p>
            </div>
            <div id = "homeImg2_Row3">
                <h5 class="descrTitles">Title Here</h5>
                 <p>Description of cool senior project here!</p>
            </div>
        </div>
         <!---------------------------------------------------------->
        <div id ="rightpics">
            <div id = "homeImg1_Row2">
                <?php
	        		include_once 'Functions.php';
					GetImage(3);
				?>
                <h5 class="descrTitles">Three Earn Toastmasters Designations</h5>
                 <p>Three USI Speaking EAgles club officers earn Toastmasters certifications.</p>
            </div>
            <div id = "homeImg2_Row3">
                <h5 class="descrTitles">Title Here</h5>
                 <p>Description of cool senior project here!</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
