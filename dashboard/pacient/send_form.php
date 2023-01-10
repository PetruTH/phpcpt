<?php

session_start();
include "../dbconnection.php";

$usr = $_SESSION['nume'];

$qry = "SELECT * FROM credentiale WHERE nume = '$usr'";
$result = mysqli_query($conn, $qry);
$row = mysqli_fetch_assoc($result);

if(!isset($_SESSION['ct_fdb']))
    $_SESSION['ct_fdb'] = 0;


    if (!isset($_SESSION['nume']) || $row['drept'] != 2){ 
    exit('Your session expiried!');
  }

if (isset($_POST['titlu']) && isset($_POST['feedback'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $titlu=validate($_POST['titlu']);
    $feedback=validate($_POST['feedback']);

    if(empty($titlu)){
        $_SESSION['rsp_fdb'] = 'Introduceti un titlu pentru feedback!';
        header("Location: contact_us.php");
        exit();
    }else if(empty($feedback)){
        $_SESSION['rsp_fdb'] = 'Introduceti opinia dumneavoastra despre noi pentru feedback!';
        header("Location: contact_us.php");
        exit();
    }else{
        if($_SESSION['ct_fdb'] >= 1){
            $_SESSION['rsp_fdb'] = 'Ati trimis deja un feedback!';
            header("Location: contact_us.php");
            exit();
        }else{
            $_SESSION['ct_fdb'] = $_SESSION['ct_fdb'] + 1;
            
            $mail='petru.theodor@outlook.com';
            $feedback = $feedback . "<br>" . "trimis de utilizatorul: " . $usr;
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
                        CURLOPT_POSTFIELDS =>"{\"recipients\":[{\"email\":\"$mail\"}],\"title\":\"$titlu\",\"html\":\"$feedback\"}",
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
            
            $_SESSION['rsp_fdb'] = 'Multumim pentru feedback!';
            header("Location: contact_us.php");
            exit();
        }
    }

}
?>