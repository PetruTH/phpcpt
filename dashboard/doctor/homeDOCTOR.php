<?php session_start(); 
include "../dbconnection.php";
$_SESSION['raspuns'] = ' ';
$usr = $_SESSION['nume'];

$qry = "SELECT * FROM credentiale WHERE nume = '$usr'";
$result = mysqli_query($conn, $qry);
$row = mysqli_fetch_assoc($result);

if (!isset($_SESSION['nume']) || $row['drept']!=1){ 
  exit('Your session expiried!');
}

echo "Buna ziua, domnule doctor " . $_SESSION['nume'] . "! <br>";
echo "Informatiile contului dumneavoastra " . "<br>";
$sql = "SELECT * FROM doctor where nume_doctor='$usr'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($result);
echo 'Numar de telefon: ' . $row[1] . "<br>";
echo 'Interval orar: ' . $row[2] . "<br>";
echo 'Specializare: ' . $row[3] . "<br>";

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Home</title>
	</head>
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
    display: grid;
  margin: 20px 20px 20px 20px;
  font-size: 19px;
  color: black;
  height: 6px;
  padding: 0px 0px 8px 0px;
  text-align: right;
  text-transform: none;
}
    </style>
    <script>
            function show1(){
                document.getElementById('opt1').style.display ='block';
                document.getElementById('opt2').style.display ='none';
                document.getElementById('opt3').style.display ='none';
                document.getElementById('opt4').style.display ='none';
                document.getElementById('opt5').style.display ='none';
            }

            function show2(){
                document.getElementById('opt1').style.display ='none';
                document.getElementById('opt2').style.display ='block';
                document.getElementById('opt3').style.display ='none';
                document.getElementById('opt4').style.display ='none';
                document.getElementById('opt5').style.display ='none';
            }
            function show3(){
                document.getElementById('opt1').style.display ='none';
                document.getElementById('opt2').style.display ='none';
                document.getElementById('opt3').style.display ='block';
                document.getElementById('opt4').style.display ='none';
                document.getElementById('opt5').style.display ='none';

            }
            function show4(){
                document.getElementById('opt1').style.display ='none';
                document.getElementById('opt2').style.display ='none';
                document.getElementById('opt3').style.display ='none';
                document.getElementById('opt4').style.display ='block';
                document.getElementById('opt5').style.display ='none';
            }

            datePickerId.max = new Date().toISOString().split("T")[0];
        </script>
	<body style="background-color:powderblue;">

  <p>Selectati din urmatorul meniu activitatile pe care doriti sa le realizati astazi!</p>
    <div style="display: grid;   grid-template-columns: auto auto; margin: 50px 50px 50px 50px;">
        <div style="display: flex; flex-direction: column;">
        <form>
            <div>
                <input type="radio" id="1" name="opt" value="listeaza" onclick="show1();">
                <label for="listeaza">Listeaza programarile dintr o anumita zi</label>
            </div>

            <div>
                <input type="radio" id="2" name="opt" value="print" onclick="show2();">
                <label for="print">Elibereaza o reteta/set de analize</label>
            </div>

            <div>
                <input type="radio" id="3" name="opt" value="anuleaza" onclick="show3();">
                <label for="anuleaza">Anuleaza o programare</label>
            </div>

            <div>
                <input type="radio" id="4" name="opt" value="actualizare" onclick="show4();">
                <label for="actualizare">Actualizeaza-ti datele contului</label>
           </div>

        </form>
        </div>

        <div style="display: flex; flex-direction: column;">            
            <div id="opt1" style="display: none;">
            <div class="registration">
                <form action="opt1.php" method="post">
                    <h2>Programare</h2>

                    <label>Data</label>
                    <input type="date" id="meeting-time" name="datapr"><br>
                    
                    <button class="register_button" type="submit">Vezi programarile</button> 
    
               </form>
            </div>
            </div>
            
            <div id="opt2" style="display: none;">
            <div class="registration">
                <form action="opt2.php" method="post">

                    <h2>Alege programarea pentru ca doresti sa oferi un diagnostic sau o reteta.</h2>

                    <label>Data</label>
                    <input type="date" name="datapr" ><br>
                    
                    <label>Ora</label>
                    <input type="number" id="meeting-time" name="ora"><br>
                
                    <button class="register_button" type="submit">Genereaza!</button> 
    
               </form>
            </div>
            </div>
            
            <div id="opt3" style="display: none;">
            <div class="registration">
                <form action="opt3.php" method="post">

                    <h2>Alege programarea pe care vrei s-o anulezi</h2>

                    <label>Data</label>
                    <input type="date" id="meeting-time" name="datapr"  min="<?= date('Y-m-d'); ?>"><br>

                    <label>Ora</label>
                    <input type="number" id="meeting-time" name="ora"><br>

                    <button class="register_button" type="submit">Vezi programarile</button> 

                    </form>
                </div>
            </div>
            <div id="opt4" style="display: none;">
            <div class="registration">
                <form action="opt4.php" method="post">

                    <h2>Actualizeaza-ti numarul de contact</h2>

                    <label>Numarul de telefon</label>
                    <input type="text" name="tlf" ><br>

                    <button class="register_button" type="submit">Actualizeaza</button> 

                    </form>
                </div>
            </div>

        </div>
    </div>
    <div id='opt5'>
    <?php
        if (isset($_SESSION['rsp'])) { ?>
            <div class="error">
                <?php 
                    echo $_SESSION['rsp'];
                     if($_SESSION['rsp'][0] == 'A' && $_SESSION['rsp'][1] == 't' && $_SESSION['rsp'][2] == 'i'){ ?>
                           <div>
                             <form action="opt2A.php" method="post">
                                 <input type="text" placeholder="Completati aici diagnosticul pacientului" name="diagnostic">    
                                 <input type="text" placeholder="Completati aici tratamentul pacientului" name="tratament">    
                                 <button class="register_button" type="submit">Genereaza!</button> 
                             </form>
                         </div>  
                        <?php
                        if(isset($_SESSION['ans']))
                            echo $_SESSION['ans'];
                        
                        } ?>
            </p>
    <?php } ?>
    </div>
    <div>
        <a href="../logout.php">Logout</a>
    </div>
	</body>
</html>
