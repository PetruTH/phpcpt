<?php session_start(); 
include "dbconnection.php";
include "login/captcha.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_SESSION['nume'])){
  $usr = $_SESSION['nume'];
}else $usr="";

$qry = "SELECT * FROM credentiale WHERE nume = '$usr'";
$result = mysqli_query($conn, $qry);

$doctori = "SELECT * FROM credentiale where drept = 1";
$pacienti = "SELECT * FROM credentiale where drept = 2";

$result_doctori = mysqli_query($conn, $doctori);
$result_pacienti = mysqli_query($conn, $pacienti);

require 'simple_html_dom.php';

function getUniqueVisitorCount($ip)
{
    if(!isset($_SESSION['current_user']))
    {
        $file = 'counter.txt';
        if(!$data = @file_get_contents($file))
        {
            file_put_contents($file, base64_encode($ip));
            $_SESSION['visitor_count'] = 1;
        }
        else{
            $decodedData = base64_decode($data);
            $ipList      = explode(';', $decodedData);

            if(!in_array($ip, $ipList)){
              array_push($ipList, $ip);
              file_put_contents($file, base64_encode(implode(';', $ipList)));
            }
            $_SESSION['visitor_count'] = count($ipList);
        }
        $_SESSION['current_user'] = $ip;
    }
}

$ip = $_SERVER['REMOTE_ADDR'];
getUniqueVisitorCount($ip);
echo 'Unique visitor count: ' . $_SESSION['visitor_count'];

?>

<!DOCTYPE html>
<html>
    <style>

    .registration form {
    margin-top: 5%;
    margin-left: 25%;
  width: 50%;
  height: 500px;
  background-color: black;
  padding: 10px 0px 0px 4px;
  border-radius: 15px;
  color: white;
  text-transform: uppercase;
  font-size: 11px;
  font-weight: bold;
  font-family: "Century Gothic";
}

.registration input {
  width: 195px;
  height: 20px;
  margin: 20px 10px 30px 10px;
  border: 0px;
  font-weight: bold;
}

.registration input:focus {
  background-color: orange;
}

.registration form label {
    margin-top: 75px;
  margin-left: 75px;
}

button {
  outline: none;
}

.register_button {
  width: 149px;
  height: 42px;
  background-color: orange;
  border-radius: 10px;
  margin: 20px 15px 30px 30px;
  text-align: center;
  cursor: pointer;
  clear: both;
}


.error {
  margin: 0px 14px 0px 10px;
  font-size: 9px;
  color: orange;
  height: 6px;
  padding: 0px 0px 8px 0px;
  text-align: right;
  text-transform: none;
}

    </style>
	<head>
		<title>Home</title>
	</head>

	<body style="background-color:powderblue;">


<div class="registration">

        
    bine ati venit!<br><br><br>
    <a href="index_login.php">Logheaza-te si rezerva-ti o programare!</a><br><br><br>
    <div>
        <?php
            echo "Clinica noastra dispune de urmatoarele pachete in parteneriat cu clinica Regina Maria:";
            $html = file_get_html('https://www.reginamaria.ro/analize-de-laborator/pachete-analize');
            $pachet = $html->find('div.field__item');
            $i = 4;
            while($i<sizeof($pachet)){
                echo $pachet[$i];
                echo $pachet[$i+1];
                echo '<br>';
                $i=$i+6;
            }
        ?>
    </div>
    
    </div>
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Doctori',     <?php echo mysqli_num_rows($result_doctori) ?>],
          ['Pacienti',      <?php echo mysqli_num_rows($result_pacienti) ?>],
          
        ]);

        var options = {
          title: 'Utilizatori pe site',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
      </script>
    <div id="piechart_3d" style="width: 700px; height: 300px; margin-top: 50px; margin-left: 390px;"></div>

	</body>
</html>
