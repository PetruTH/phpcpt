<?php 

session_start(); 

include "../dbconnection.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data){

       $data = trim($data);

       $data = stripslashes($data);

       $data = htmlspecialchars($data);

       return $data;

    }
}
    
$uname = validate($_POST['uname']);

$pass = validate($_POST['password']);
$pass = hash("md5", $pass);
$captchausr = validate($_POST['captcha_verify']);


if (empty($uname)) {
    $_SESSION['error_login'] = 'Introdu username-ul!';
    header("Location: ../index.php");
    exit();
    
}else if(empty($pass)){
    $_SESSION['error_login'] = 'Introdu parola!';
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT * FROM credentiale WHERE nume = '$uname' AND parola = '$pass'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) === 1) {

    $row = mysqli_fetch_assoc($result);

    if ($row['nume'] === $uname && $row['parola'] === $pass && $captchausr === $_SESSION['captcha_code']) {
        echo "Logged in!";
        $_SESSION['nume'] = $row['nume'];
        if($row['drept'] === '2'){
            header("Location: \dashboard\pacient\home.php");
            exit();
        }else if($row['drept'] === '1'){
            header("Location: \dashboard\doctor\homeDOCTOR.php");
            exit();
        }else if($row['drept'] === '0'){
            header("Location: \dashboard\admin\homeADMIN.php");
            exit();
        }

    }else{
            $_SESSION['error_login'] = 'Date incorecte!';
            header("Location: ../index.php");
            exit();
    }
}
else{
    $_SESSION['error_login'] = 'Date incorecte!';
    header("Location: ../index.php");
    exit();
}
