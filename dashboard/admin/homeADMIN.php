<?php session_start(); 
include "../dbconnection.php";

$usr = $_SESSION['nume'];

$qry = "SELECT * FROM credentiale WHERE nume = '$usr'";
$result = mysqli_query($conn, $qry);
$row = mysqli_fetch_assoc($result);

if (!isset($_SESSION['nume']) || $row['drept'] != 0){ 
    exit('Your session expiried!');
  }
echo $usr;
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
    
	<body style="background-color:powderblue;">
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
                <label for="listeaza">Listeaza doctorii curenti</label>
            </div>

            <div>
                <input type="radio" id="2" name="opt" value="adauga" onclick="show2();">
                <label for="print">Adauga un doctor</label>
            </div>

            <div>
                <input type="radio" id="3" name="opt" value="sterge" onclick="show3();">
                <label for="anuleaza">Sterge un doctor</label>
            </div>

            <div>
                <input type="radio" id="4" name="opt" value="actualizare" onclick="show4();">
                <label for="actualizare">Modifica programul unui doctor</label>
           </div>

        </form>
        </div>

        <div style="display: flex; flex-direction: column;">            
            <div id="opt1" style="display: none;">
            <div class="registration">
                <form action="opt1.php" method="post">

                    <h2>Doctorii disponibili</h2>
                    
                    <button class="register_button" type="submit">Afiseaza</button> 
    
               </form>
            </div>
            </div>
            
            <div id="opt2" style="display: none;">
            <div class="registration">
                <form action="opt2.php" method="post">

                    <h2>Completeaza datele noului doctor</h2>

                    <label>Nume doctor</label>
                    <input type="text" name="numedr"><br>
                    
                    <label>Numarul de telefon</label>
                    <input type="text" name="tlf" ><br>

                    <label>Program de lucru</label>
                    <input type="text" name="interval"><br>

                    <label>Specializare</label>
                    <input type="text" name="specializare"><br>

                    <label>Adauga o parola pentru contul doctorului inregistrat</label>
                    <input type="password" name="pass"><br>

                    <button class="register_button" type="submit">Adauga!</button> 
    
               </form>
            </div>
            </div>
            
            <div id="opt3" style="display: none;">
            <div class="registration">
                <form action="opt3.php" method="post">

                    <h2>Introdu numele doctorului pe care doresti sa-l stergi</h2>

                    <label>Nume doctor</label>
                    <input type="text" name="numedr"><br>

                    <button class="register_button" type="submit">Sterge doctorul</button> 

                    </form>
                </div>
            </div>
            <div id="opt4" style="display: none;">
            <div class="registration">
                <form action="opt4.php" method="post">

                    <h2>Actualizeaza programul unui doctor</h2>

                    <label>Introdu doctorul caruia doresti sa ii actualizezi programul.</label>
                    <input type="text" name="numedr"><br>

                    <button class="register_button" type="submit">Actualizeaza</button> 

                    </form>
                </div>
            </div>

        </div>
        <a href="../logout.php">Logout</a>
    </div>
    <div id='opt5'>
    <?php if (isset($_SESSION['raspuns'])) { ?>
            <div class="error">
                <?php 
                    echo $_SESSION['raspuns'];
                    if($_SESSION['raspuns'][0] == 'A' && $_SESSION['raspuns'][1] == 't' && $_SESSION['raspuns'][2] == 'i'){ ?>
                        <div>
                            <form action="opt4A.php" method="post">
                            <label>Noul program</label>
                                <input type="text" name="prog"><br>
                                <button class="register_button" type="submit">Genereaza!</button> 
                            </form>
                        </div>
                    
                    <?php } ?>

            </p>
    <?php } ?>
    </div>
  
	</body>
</html>
