<html>
<body>
    <?php
// the message
$msg = "test email succeeded!";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail($_GET["email"],"Test",$msg);

echo("check your inbox")
?>

</body>
</html>