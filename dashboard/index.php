<?php session_start(); 
include "dbconnection.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_SESSION['nume'])){
  $usr = $_SESSION['nume'];
}else $usr="";

$qry = "SELECT * FROM credentiale WHERE nume = '$usr'";
$result = mysqli_query($conn, $qry);

?>

<!DOCTYPE html>
<html>
    <style>

    .registration form {
    margin: auto;
  width: 50%;
  height:390px;
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


	<?php ?>

<div class="registration">
        <form action="login\loginPacient.php" method="post">

        <h2>LOGIN</h2>

        <?php if (isset($_GET['error_login'])) { ?>
            <p class="error"><?php echo $_GET['error_login']; ?></p>
        <?php } ?>

        <label>Username</label>
        <input type="text" name="uname" placeholder="User Name"><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password"><br> 

        <button class="register_button" type="submit" <?php if(mysqli_num_rows($result) != 0) { ?> disabled <?php }?> >
          Login
        </button>
     
        <div><a href="register\index.php">Create account!</a></div>
        
        
        <!-- DE IMPLEMENTAT -->
        <div><a href="#">Continue as a guest!</a></div> 
        
    
    
        </form>
</div>

	<?php ?>

	</body>
</html>
