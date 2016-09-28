<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <meta http-equiv="X-UA-Compatible" content="IE-edge"/>
        <meta http-equiv="content-type" content="text/html; charset-utf-8"/>
        <!-- Javascript source files initiation area -->


    </head>
    <body>
        <div id="head">
        <!-- Area where the navigation, search, login go -->


        </div>
        
        <!-- body div where the core content will show up based upon what the POST is -->
        <div id="">        
        <?php 
            //check if a post happened
            
            //check what kind of post happened (search result|profile view|project/activity view)

            //connect to database
            $host = gethostbyname('mysqlsvr.ddns.net');
            $con = mysqli_connect($host,'user','password','usiprojectrepository','3301');
            if (mysql_connect_errno())
            {
                echo "Failed to connect to database" . mysql_connect_error();
            }
            //


        ?>
        </div>
    </body>
</html>