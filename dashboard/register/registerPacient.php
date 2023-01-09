<?php

session_start();
include "../dbconnection.php";
$_SESSION['error_login'] = '';


if(isset($_SESSION['nume']))    
    $usr = $_SESSION['nume'];
else $usr='';

$qry = "SELECT * FROM credentiale WHERE nume = '$usr'";
$result = mysqli_query($conn, $qry);

if(mysqli_num_rows($result) != 0){
    exit("Nu poti crea un cont cat timp esti logat!");
}

if (isset($_POST['uname']) && isset($_POST['pass'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;

    }
}
    $uname = validate($_POST['uname']);
    $pass = validate($_POST['pass']);

if(empty($uname)){
    $_SESSION['error_register'] = "Introdu username-ul!";
    header("Location: index.php");
    exit();
} else if(empty($pass)){
    $_SESSION['error_register'] = "Introdu parola!";
    header("Location: index.php");
    exit();
}
$pass = hash("md5", $pass);

$sql = "SELECT * FROM credentiale WHERE nume = '$uname'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) === 0){
    //$pass = hash('sha512', $pass);
    $insertSQL = "INSERT INTO credentiale VALUES ('$uname', '$pass', '2')";
    $wasInserted = mysqli_query($conn, $insertSQL);

    if($wasInserted){
        $_SESSION['error_register'] = "Te ai inregistrat cu succes!";
        header("Location: ../index.php");
        exit();
    }
} else {
    $_SESSION['error_register'] = "Exista deja un cont cu acest username.";
    header("Location: index.php");
    exit();
}

?>
