<?php

session_start();
include "../dbconnection.php";

if (!isset($_SESSION['nume'])){ 
    exit('Your session expiried!');
  }

  if (isset($_POST['prog'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $pattern="/[0-2][0-9][:][0][0][-][0-2][0-9][:][0][0]$/";
    $prog = validate($_POST['prog']);
    $doctor = $_SESSION['doctor'];

    if(empty($doctor)){
        $_SESSION['raspuns'] = 'Alege un doctor!';
        header("Location: homeADMIN.php");
        exit();
    }else if(empty($prog)){
        $_SESSION['raspuns'] = 'Alege un program!';
        header("Location: homeADMIN.php");
        exit();
    }else if(preg_match($pattern, $prog) === 0){
        $_SESSION['raspuns'] = 'Alege un program valid!';
        header("Location: homeADMIN.php");
        exit();
    }else{

        if($prog != $_SESSION["progr_initial"]){
            $sql = "UPDATE doctor SET interval_orar = '$prog' WHERE nume_doctor = '$doctor'";
            $result = mysqli_query($conn, $sql);
            $ans = "Programul doctorului " . $doctor . ' a fost actualizat!';
            
            $_SESSION['raspuns'] = $ans;
            
            header("Location: homeADMIN.php");
            exit();
        }else{
            $_SESSION['raspuns'] = 'Noul program trebuie sa fie diferit de cel initial!';
            header("Location: homeADMIN.php");
            exit();
        }
    }
}
