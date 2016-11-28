
<?php
include_once 'Functions.php';
echo GetPath("c:/wamp64/tmp/Uploaded Files")."<br>";
echo GetPath("c:\\wamp64\\tmp\\Uploaded Files")."<hr>";
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
$uploaddir = GetPath(sys_get_temp_dir());
$uploadfile = tempnam($uploaddir , basename($_FILES['userfile']['name']));

echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.\n";
	if ($_FILES['userfile']['size'])
	{
		echo $uploadfile."<br>";
	}
} 
else 
{

    echo "There was an error uploading the file. Please try again.";
}

echo 'Here is some more debugging info:';
print_r($_FILES);

echo realpath($uploadfile);

print "</pre>";
}
?>
