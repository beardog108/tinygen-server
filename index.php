<?php
session_start();

if (isset($_SESSION['loggedIn'])){
  if ($_SESSION['loggedIn'] == true){
    header('location: dashboard.php');
    die(0);
  }
}
?>
<!DOCTYPE HTML>
<html>
<head>
  <meta charset='utf-8'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <!--Copyright 2017 Kevin Froman - GNU AFFERO GENERAL PUBLIC LICENSE -->
  <title>TinyGen</title>
  <link rel='stylesheet' href='theme.css'>
</head>
<body>
  <div class='center'>
    <h1 class='title'>TinyGen Market</h1>
  </div>
  <div class='center'>
    <a href='login.php'>Login</a>
    <br><br>
    <a href='signup.php'>Signup</a>
  </div>
</body>
</html>