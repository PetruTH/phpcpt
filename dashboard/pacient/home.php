<?php session_start(); 
include "../dbconnection.php";
require 'simple_html_dom.php';

$usr = $_SESSION['nume'];

$qry = "SELECT * FROM credentiale WHERE nume = '$usr'";
$result = mysqli_query($conn, $qry);
$row = mysqli_fetch_assoc($result);

if(isset($_SESSION['views']))
    $_SESSION['views'] = $_SESSION['views']+1;
else
    $_SESSION['views']=1;

if (!isset($_SESSION['nume']) || $row['drept'] != 2){ 
    exit('Your session expiried!');
  }


if (!isset($_SESSION['nume'])){ 
  exit('Your session expiried!');
}

?>

<!DOCTYPE html>
<html>
    <style>

    .registration form {
    margin: auto;
  width: 50%;
  height:590px;
  background-color: black;
  padding: 10px 0px 0px 4px;
  border-radius: 15px;
  color: white;
  text-transform: uppercase;
  font-size: 11px;
  font-weight: bold;
  font-family: "Century Gothic";
  /* display:flex; */
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
    margin-top:70px;
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

  <p>Clinica noastra dispune de cei mai capabili medici pe fiecare ramura. Apeleaza cu incredere
    la noi. Lista de medici din cadrul clinicii noastre. Fa-ti chiar acum o programare.</p>
 
    <?php
        $sql = "SELECT * FROM doctor";
        $result = mysqli_query($conn, $sql); 
        echo "<br>";
        echo "<table border='1'>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            foreach ($row as $field => $value) { 
                echo "<td>" . $value . "</td>"; 
            }
            echo "</tr>";
        }

        echo "</table><br><br><br>";
	?>

<div class="registration">
        <form action="programare.php" method="post">

        <h2>Programare</h2>

        <?php if (isset($_SESSION['errorp'])) { ?>
            <p class="error"><?php echo $_SESSION['errorp']; ?></p>
        <?php } ?>

        <label>Nume complet</label>
        <input type="text" name="nume" placeholder="Nume"><br>

        <label>Data</label>
        <input type="date" id="meeting-time" name="data"><br>

        <label>Ora</label>
        <input type="number" id="meeting-time" name="ora"><br>

        <label>Afectiune</label>
        <input type="text" name="afectiune" placeholder="Afectiune"><br>

        <label>Adresa de mail</label>
        <input type="email" name="mail" placeholder="E-mail"><br>

        <label>Doctor</label>
        <select name="doctor" required>
            <?php
            $select_str = "<option disabled selected value=\"\">Alege un doctor</option> ";
            $sql = "SELECT * FROM doctor";
            $result = mysqli_query($conn, $sql);
                 while ($row = mysqli_fetch_row($result)) {
                 $select_str .= "<OPTION VALUE=\"$row[0]\" >$row[0]\n"; 
                } 
                echo $select_str;
            ?>
        </select>
        
        <p style="margin-top: 25px;">Rezerva programarea</p>
        <button class="register_button" type="submit">Confirma!</button> 
    
        </form>
        <br><br>
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
        <br><br>
        <a href="../logout.php">Logout</a><br>
        <a href="contact_us.php">Trimite un feedback!</a>
        <p>Numarul de vizitari pe aceasta pagina: <?php echo $_SESSION['views'] ?><br></p>
</div>

	</body>
</html>
