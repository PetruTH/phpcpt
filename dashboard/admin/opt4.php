<?php

session_start();
include "../dbconnection.php";

if (!isset($_SESSION['nume'])){ 
    exit('Your session expiried!');
  }

  if (isset($_POST['numedr'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $doctor = validate($_POST['numedr']);

    if(empty($doctor)){
        $_SESSION['raspuns'] = 'Alege un doctor!';
        header("Location: homeADMIN.php");
        exit();
    }else{

        $sql = "SELECT * FROM doctor WHERE nume_doctor = '$doctor'";
        $result = mysqli_query($conn, $sql);
        $select_str = "Ati selectat doctorul " ;

        $row = mysqli_fetch_row($result);
        if($row){
            $_SESSION['doctor'] = $row[0];
            $_SESSION['progr_initial'] = $row[2];
            
            $select_str .= $row[0] . " cu programul initial " . $row[2]; 
        }

        if($select_str == "Ati selectat doctorul "){
            $_SESSION['raspuns'] = 'Acest doctor nu este inregistrat la clinica.';
            header("Location: homeADMIN.php");
            exit();
        }else{
            $_SESSION['raspuns'] = $select_str;
            header("Location: homeADMIN.php");
            exit();
        }
    }
}
