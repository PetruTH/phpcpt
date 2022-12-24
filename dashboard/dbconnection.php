<?php

$db= "heroku_56abc638eaa6981";

$uname= "b0f6f38347a10c";

$password = "7c185f87";

$sname="eu-cdbr-west-03.cleardb.net";

$conn = mysqli_connect($sname, $uname, $password, $db);

if (!$conn) {

    echo "Connection failed!";

}
