<?php session_start(); 
include "../dbconnection.php";
require '../simple_html_dom.php';

$usr = $_SESSION['nume'];

$qry = "SELECT * FROM credentiale WHERE nume = '$usr'";
$result = mysqli_query($conn, $qry);
$row = mysqli_fetch_assoc($result);

if(isset($_SESSION['views_fdb']))
    $_SESSION['views_fdb'] = $_SESSION['views_fdb']+1;
else
    $_SESSION['views_fdb']=1;

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

  <p>Trimite un feedback pentru a ne putea imbunatati serviciile!</p>
 
<div class="registration">
        <form action="send_form.php" method="post">

        <h2>Completeaza acest formular</h2>

        <?php if (isset($_SESSION['rsp_fdb'])) { ?>
            <p class="error"><?php echo $_SESSION['rsp_fdb']; ?></p>
        <?php } ?>

        <label>Titlu</label>
        <input type="text" name="titlu" placeholder="titlu"><br>

        <label>Feedback</label>
        <textarea name="feedback"></textarea><br>
        
        
        <p style="margin-top: 25px;">Rezerva programarea</p>
        <button class="register_button" type="submit">Confirma!</button> 
    
        </form>
        
        <br><br>
        <a href="../logout.php">Logout</a><br>
        <a href="home.php">Intoarce-te la pagina principala</a>
        <p>Numarul de vizitari pe aceasta pagina: <?php echo $_SESSION['views_fdb'] ?><br></p>
</div>

	</body>
</html>
