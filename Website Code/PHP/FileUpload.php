<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
$uploaddir = '../../Uploaded Files/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.\n";
	if ($_FILES['userfile']['size'])
	{
		echo $uploadfile."<br>";
	}
} else {
    echo "Possible file upload attack!\n";
}

echo 'Here is some more debugging info:';
print_r($_FILES);

echo realpath($uploadfile);

print "</pre>";
}
?>
