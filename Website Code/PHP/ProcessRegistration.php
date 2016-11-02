post registration posting
<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		echo "data recieved";
		foreach ($_POST as $key => $val) {
		  echo '<p>'.$key.'</p>:'.$_POST[$key];
		}
		if (isset($_POST['s'])) 
		{ 
			$Search = mysqli_real_escape_string($con,trim(strip_tags($_POST['s']))); 
			echo $_POST['s'];
		}
		
	}
?>
