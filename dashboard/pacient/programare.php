<?php

session_start();
include "../dbconnection.php";

$usr = $_SESSION['nume'];

$qry = "SELECT * FROM credentiale WHERE nume = '$usr'";
$result = mysqli_query($conn, $qry);
$row = mysqli_fetch_assoc($result);

if (!isset($_SESSION['nume']) || $row['drept'] != 2){ 
    exit('Your session expiried!');
  }

if (isset($_POST['nume']) && isset($_POST['data']) && isset($_POST['afectiune']) && isset($_POST['mail']) && isset($_POST['doctor']) && isset($_POST['ora'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }


    $name = validate($_POST['nume']);
    $data = validate($_POST['data']);
    $afectiune = validate($_POST['afectiune']);
    $mail = validate($_POST['mail']);
    $doctor = validate($_POST['doctor']);
    $ora = validate($_POST['ora']);
    $usr = $_SESSION['nume'];



if(empty($name)){
    $_SESSION['errorp'] = 'Introduceti numele!';
    header("Location: home.php");
    exit();
} else if(empty($data)){
    $_SESSION['errorp'] = 'Introduceti data!';
    header("Location: home.php");
    exit();
}else if(empty($afectiune)){
    $_SESSION['errorp'] = 'Introduceti afectiune!';
    header("Location: home.php");
    exit();
}else if ($data < date('Y-m-d')){
    $_SESSION['errorp'] = 'Nu puteti introduce o data din trecut';
    header("Location: home.php");
    exit();
}else if(empty($mail)){
    $_SESSION['errorp'] = 'Introduceti mailul!';
    header("Location: home.php");
    exit();
}else if($doctor==""){
    $_SESSION['errorp'] ='Introduceti un doctor!';
    header("Location: home.php");
    exit();
}else if(empty($ora)){
    $_SESSION['errorp'] = 'Introduceti o ora!';
    header("Location: home.php");
    exit();
}

$qry = "SELECT * FROM programari WHERE username = '$usr'";
$ct = mysqli_query($conn, $qry);
$x =  mysqli_num_rows($ct);

if($x < 4){
    $sql = "SELECT * FROM programari WHERE nume_doctor = '$doctor' AND dataprog = '$data' AND ora = '$ora'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) === 0){
        
        $sql_ora = "SELECT interval_orar FROM doctor WHERE nume_doctor = '$doctor'";
        $interval = mysqli_query($conn, $sql_ora);    
        $row = mysqli_fetch_row($interval);

        $ora_start =(int) $row[0][0] . $row[0][1];
        $ora_finish =(int) $row[0][6] . $row[0][7];
        $ora = (int) $ora;

        if($ora < 0 || $ora > 23){
            $_SESSION['errorp'] = 'Alege o ora potrivita!';
            header("Location: home.php");
            exit();
        }else if ($ora < $ora_start || $ora > $ora_finish){
            $_SESSION['errorp'] = 'Medicul selectat nu lucreaza in acel interval orar!!';
            header("Location: home.php");
            exit();
        }else{

            $insertSQL = "INSERT INTO programari VALUES ('$doctor', '$data', '$name', '$mail', '$afectiune', '$ora', '$usr')";
            $wasInserted = mysqli_query($conn, $insertSQL);

            if($wasInserted){
            
                // TEST
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $_ENV['TRUSTIFI_URL'] . "/api/i/v1/email",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS =>"{\"recipients\":[{\"email\":\"$mail\"}],\"title\":\"Confirmare\",\"html\":\"Programarea dumneavoastra a fost inregistrata!\"}",
                        CURLOPT_HTTPHEADER => array(
                            "x-trustifi-key: " . $_ENV['TRUSTIFI_KEY'],
                            "x-trustifi-secret: " . $_ENV['TRUSTIFI_SECRET'],
                            "content-type: application/json"
                        )
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
                    if ($err) {
                        echo "cURL Error #:" . $err;
                    } else {
                        echo $response;
                    }
                //TEST
                $_SESSION['errorp'] = 'Programare inregistrata! Veti primi confirmarea pe mail!';
                header("Location: home.php");
                exit();
            } else {
                $_SESSION['errorp'] = 'Bad luck! Try again';
                header("Location: home.php");
                exit();
            }
        }
    }else {
        $_SESSION['errorp'] = 'Doctorul are deja o programare la acea data!';
        header("Location: home.php?errorp=Doctorul are deja o programare la acea data!");
        exit();
        }
    }
else{
    $_SESSION['errorp'] = 'limita de programari a fost atinsa!';
    header("Location: home.php");    
    exit();
    }
}
?>
