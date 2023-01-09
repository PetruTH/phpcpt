<?php

session_start();
include "../dbconnection.php";
$_SESSION['ans'] = '';

if (!isset($_SESSION['nume'])){ 
    exit('Your session expiried!');
  }

  if (isset($_POST['tlf'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $tlf = validate($_POST['tlf']);
    $doctor = $_SESSION['nume'];
    $pattern="/[0][7]\d{8}/";

    if(empty($tlf)){
        $_SESSION['rsp'] = 'Introdu un nou numar de telefon!';
        header("Location: homeDOCTOR.php");
        exit();
    }else if(preg_match($pattern, $tlf) === 0){
        $_SESSION['rsp'] = 'Introdu un numar de telefon valid!';
        header("Location: homeDOCTOR.php");
        exit();
    }else{

        $sql = "SELECT * FROM doctor WHERE nume_doctor = '$doctor'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_row($result);
        $tlf_initial = "";
        if($row){
            $tlf_initial = $row[1];
        }

        if($tlf == $tlf_initial){
            $_SESSION['rsp'] = 'Noul numar de telefon nu poate fi identic cu cel vechi!';
            header("Location: homeDOCTOR.php");
            exit();
        }else{
            $sql_upd = "UPDATE doctor SET telefon_doctor = '$tlf' WHERE nume_doctor = '$doctor' ";
            $result_upd = mysqli_query($conn, $sql_upd);

            $_SESSION['rsp'] = 'Noul numar de telefon a fost inregistrat! Multumim!';
            header("Location: homeDOCTOR.php");
            exit();
        }
    }
}
