<?php

session_start();
include "../dbconnection.php";

$_SESSION['ans'] = '';

if (!isset($_SESSION['nume'])){ 
    exit('Your session expiried!');
  }

  if (isset($_POST['datapr'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }


    $datapr = validate($_POST['datapr']);
    $doctor = $_SESSION['nume'];

    if(empty($datapr)){
        $_SESSION['rsp'] = 'Selecteaza o data!';
        header("Location: homeDOCTOR.php");
        exit();
    }

    $sql = "SELECT * FROM programari WHERE nume_doctor = '$doctor' and dataprog = '$datapr' ORDER BY ORA";
    $result = mysqli_query($conn, $sql);
    $select_str = "Pe data selectata aveti urmatoarele programari: <br>";
    $i = 1;

    while ($row = mysqli_fetch_row($result)){
        $select_str .= $i . ". " . $row[2] . " la ora " . $row[5] .  " Simptom descris: " . $row[4] . "<br>"; 
        $i = $i + 1;
    } 
    if($select_str == "Pe data selectata aveti urmatoarele programari: <br>"){
        $_SESSION['rsp'] = 'Nu exista nicio programare la acea data!';
        header("Location: homeDOCTOR.php");
        exit();
    }else{
        $_SESSION['rsp'] = $select_str;
        header("Location: homeDOCTOR.php");
        exit();
    }

}
