<?php
/*
Copyright 2017 Kevin Froman - GNU AFFERO GENERAL PUBLIC LICENSE
*/
session_start();
if (isset($_SESSION['loggedIn'])){
  if ($_SESSION['loggedIn'] == false){
    header('location: index.php?v=1');
    die(0);
  }
}
else{
  header('location: index.php');
  die(0);
}
include('php/csrf.php');
include('php/settings.php');
include('php/userInfo.php');
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
    <h1 class='title'>TinyGen Dashboard</h1>
  </div>
  <div class='center'>
    <?php echo $_SESSION['user'];?>
    <br><br><a href='logout.php?CSRF=<?php echo $CSRF;?>'>Logout</a>
  </div>
</body>
</html>