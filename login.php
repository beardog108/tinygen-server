<?php
/*
Copyright 2017 Kevin Froman - GNU AFFERO GENERAL PUBLIC LICENSE
*/
session_start();

if (isset($_SESSION['loggedIn'])){
  if ($_SESSION['loggedIn'] == true){
    header('location: dashboard.php');
    die(0);
  }
}

function loginError($reason){
  // Set a login error and redirect back to the signup page
  $_SESSION['loginError'] = $reason;
  header('location: login.php');
  die(0);
}

include('php/csrf.php');
include('php/settings.php');
include('php/userInfo.php');
$userInfo = new userInfo();

if (isset($_GET['login'])){
  if ($_GET['login'] == 'true'){
    if (! isset($_POST['user']) || ! isset($_POST['password'])){
      loginError('Invalid login request');
    }
    else{
      $user = $_POST['user'];
      $password=  $_POST['password'];
    }
    if (! $userInfo->userExists($user)){
      loginError('A user by that name does not exist.');
    }
    $password = password_hash($password, PASSWORD_DEFAULT);
    if($userInfo->loginUser($user, $password, false)){
      $_SESSION['user'] = $user;
      $_SESSION['loggedIn'] = true;
      header('location: dashboard.php');
      die(0);
    }
  }
}
?>
<!DOCTYPE HTML>
<html>
<head>
  <meta charset='utf-8'>
  <!--Copyright 2017 Kevin Froman - GNU AFFERO GENERAL PUBLIC LICENSE -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <title>TinyGen</title>
  <link rel='stylesheet' href='theme.css'>
</head>
<body>
  <div class='center'>
    <h1 class='title'>TinyGen Login</h1>
  </div>
  <div class='center'>
    <form method='post' action='login.php?login=true'>
      <input type='hidden' name='csrf' value="<?php echo $CSRF;?>">
      <label class='formArea'>Username: <input type='text' name='user' required></label>
      <label class='formArea'>Password: <input type='password' name='password' required></label>
      <label class='formArea'><input type='submit' value='Login' id='signupButton'></label>
      <br><br><a href='signup.php'>Don't have an account?</a>
  </div>
</body>
</html>