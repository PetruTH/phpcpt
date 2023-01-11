<?php

session_start();
include "../dbconnection.php";

if (!isset($_SESSION['nume'])){ 
    exit('Your session expiried!');
  }

  if (isset($_POST['numedr']) && isset($_POST['interval']) && isset($_POST['tlf']) && isset($_POST['specializare']) && isset($_POST['pass'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $doctor = validate($_POST['numedr']);
    $program = validate($_POST['interval']);
    $tlf = validate($_POST['tlf']);
    $specializare = validate($_POST['specializare']);
    $pass = validate($_POST['pass']);

    $pattern_interval="/[0-2][0-9][:][0][0][-][0-2][0-9][:][0][0]$/";
    $pattern_tlf="/[0][7]\d{8}$/";

    if(empty($doctor)){
        $_SESSION['raspuns'] = 'Completeaza numele doctorului!';
        header("Location: homeADMIN.php");
        exit();
    }else if(empty($program)){
        $_SESSION['raspuns'] = 'Introdu intervalul orar in care doctorul lucreaza!';
        header("Location: homeADMIN.php");
        exit();
    }else if(empty($tlf)){
        $_SESSION['raspuns'] = 'Completeaza numarul de telefon al doctorului!';
        header("Location: homeADMIN.php");
        exit();
    }
    else if(empty($specializare)){
        $_SESSION['raspuns'] = 'Completeaza specializarea doctorului!';
        header("Location: homeADMIN.php");
        exit();
    }else if(empty($pass)){
        $_SESSION['raspuns'] = 'Introdu o parola pentru contul doctorului!';
        header("Location: homeADMIN.php");
        exit();
    }else if(preg_match($pattern_interval, $program) === 0){
        $_SESSION['raspuns'] = 'Introdu un interval orar valid!';
        header("Location: homeADMIN.php");
        exit();
    }else if(preg_match($pattern_tlf, $tlf) === 0){
        $_SESSION['raspuns'] = 'Introdu un numar de telefon valid!';
        header("Location: homeADMIN.php");
        exit();
    }

    $verifySQL = "SELECT nume_doctor FROM doctor where nume_doctor = '$doctor'";
    $verify = mysqli_query($conn, $verifySQL);
    $row = mysqli_fetch_row($verify);
    $dr = "";
    if($row){
        $dr = $row[0];
    }
    if($dr != $doctor){
        $insertSQL = "INSERT INTO doctor VALUES ('$doctor', '$tlf', '$program', '$specializare')";
        $wasInserted = mysqli_query($conn, $insertSQL);

        $pass = hash("md5", $pass);
        $insertSQLacc = "INSERT INTO credentiale VALUES ('$doctor', '$pass', '1')";
        $wasInsertedacc = mysqli_query($conn, $insertSQLacc);

        if($wasInserted){
            $_SESSION['raspuns'] = 'Ai inregistrat doctorul cu succes.';
            header("Location: homeADMIN.php");
            exit();
        } 
    }else{
        $_SESSION['raspuns'] = 'Acest doctor deja este inregistrat!';
        header("Location: homeADMIN.php");
        exit();
    }
}
