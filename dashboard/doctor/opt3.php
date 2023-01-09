<?php

session_start();
include "../dbconnection.php";
$_SESSION['ans'] = '';

if (!isset($_SESSION['nume'])){ 
    exit('Your session expiried!');
  }

  if (isset($_POST['datapr']) && isset($_POST['ora'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $ora = validate($_POST['ora']);
    $datapr = validate($_POST['datapr']);
    $doctor = $_SESSION['nume'];

    if(empty($datapr)){
        $_SESSION['rsp'] = 'Selecteaza o data';
        header("Location: homeDOCTOR.php");
        exit();
    }else if($datapr < date('Y-m-d')){
        $_SESSION['rsp'] = 'Nu poti anula o programare din trecut!';
        header("Location: homeDOCTOR.php");
        exit();
    }

    if(empty($ora)){
        $_SESSION['rsp'] = 'Selecteaza o ora!';
        header("Location: homeDOCTOR.php");
        exit();
    }else if($ora < 0 || $ora > 23){    
        $_SESSION['rsp'] = 'Selecteaza o ora valida';
        header("Location: homeDOCTOR.php");
        exit();
    }

    $sql = "SELECT * FROM programari WHERE nume_doctor = '$doctor' and ora='$ora' and dataprog = '$datapr'";
    $result = mysqli_query($conn, $sql);
    $select_str = "Ati selectat programarea urmatoare:<br> "; 
    $row = mysqli_fetch_row($result);
    if($row){
        $_SESSION['ora_opt2'] = $row[5];
        $_SESSION['data_opt2'] = $row[1];
        $_SESSION['nume_pacient_opt2'] = $row[2];
        
        $select_str .= " ora " . $row[5] . " din data de " . $row[1] . " a pacientului " . $row[2]; 
    }

    $sql_del = "DELETE FROM programari WHERE nume_doctor = '$doctor' AND dataprog = '$datapr' AND ora = '$ora'";
    $result_del = mysqli_query($conn, $sql_del);

    if($select_str == "Ati selectat programarea urmatoare:<br> "){
        $_SESSION['rsp'] ='Programare inexistenta';
        header("Location: homeDOCTOR.php");
        exit();
    }else{
        $delete = "Programarea anulata: " . $select_str;
        $_SESSION['rsp'] =$delete;
        header("Location: homeDOCTOR.php");
        exit();
    }

}
