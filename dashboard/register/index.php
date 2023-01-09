<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <style>

    .registration form {
      margin-top: 10%;
    margin-left: 25%;
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

        <form action="registerPacient.php" method="POST">
        <h2>REGISTER</h2>

                <?php if(isset($_SESSION['error_register'])) { ?>
                    <p class="error"> <?php echo $_SESSION['error_register']; ?> </p>
                <?php } ?>

                <label> Username </label> <br>
                <input type="text" name="uname" placeholder="Username"> <br> 

                <label> Password </label> <br>
                <input type="password" name="pass" placeholder="Password"> <br>

                <button class="register_button" type="submit">Register</button>

            </form>
</div>
	<?php ?>

	</body>
</html>
