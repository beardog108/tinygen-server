<?php
/*
Copyright 2017 Kevin Froman - GNU AFFERO GENERAL PUBLIC LICENSE
*/
session_start();
include('php/checklogin.php');
checkLogin();
include('php/csrf.php');
include('php/settings.php');
include('php/userInfo.php');

$userInfo = new userInfo();
$user = $_SESSION['user'];
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
    <p>Logged in as: <?php echo $user;?> <a href='logout.php?CSRF=<?php echo $CSRF;?>'>Logout</a></p>
  </div>
  <div class='contentArea'>
      <h2 class='center'>My Plugins</h2>
    <?php
    echo $userInfo->listUserPlugins($user);
    ?>
    <div class='center'>
      <a href='create.php?type=plugin'>Add Plugin</a>
    </div>
  </div>
</body>
</html>