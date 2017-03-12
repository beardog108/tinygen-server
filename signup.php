<?php
/*
Copyright 2017 Kevin Froman - GNU AFFERO GENERAL PUBLIC LICENSE
*/
session_start();
include('php/csrf.php');
include('php/settings.php');
include('php/userInfo.php');

function signupError($reason){
  // Set a signup error and redirect back to the signup page
  $_SESSION['signupError'] = $reason;
  header('location: signup.php');
  die(0);
}

function signup(){
  // Validate and signup the user
  if (! isset($_POST['user']) || ! isset($_POST['password']) || ! isset($_POST['confirmPass'])){
    signupError('Invalid signup information');
  }
  $pass = $_POST['password'];
  $confirmPass = $_POST['confirmPass'];
  if ($pass != $confirmPass){
    signupError('Passwords do not match');
  }
  $user = rtrim(ltrim($_POST['user']));

  if (strlen($pass) < 8){
    signupError('Your password must be over 8 characters in length');
  }
  if (strlen($pass) > 250){
    signupError('Your password must be under 250 characters in length');
  }
  if ($pass == $user){
    signupError('Your password cannot be the same as your username');
  }
  if (strlen($user) < 3){
    signupError('Your username must be over 3 characters');
  }
  $userInfo = new userInfo();
  if ($userInfo->userExists($user)){
    signupError('A user by that name already exists.');
  }
  $pass = password_hash($pass, PASSWORD_DEFAULT);
  if ($userInfo->addUser($user, $pass)){
    $userInfo->loginUser($user, $pass, true);
    header('location: profile.php');
    die(0);
  }
}


if (isset($_GET['signup'])){
  if ($_GET['signup'] == 'true')
    signup();
}
?>
<!DOCTYPE HTML>
<html>
<head>
  <meta charset='utf-8'>
  <!--Copyright 2017 Kevin Froman - GNU AFFERO GENERAL PUBLIC LICENSE -->
  <title>TinyGen</title>
  <link rel='stylesheet' href='theme.css'>
</head>
<body>
  <div class='center'>
    <h1 class='title'>TinyGen Market</h1>
  </div>
  <div class='center'>
    <?php
    if (isset($_SESSION['signupError'])){
      if ($_SESSION['signupError'] != ''){
        echo '<h2 class="center" style="color: red;">' . $_SESSION['signupError'] . '</h2>';
        $_SESSION['signupError'] = '';
      }
    }
    ?>
    <form method='post' action='signup.php?signup=true'>
      <input type='hidden' name='csrf' value="<?php echo $CSRF;?>">
      <label class='formArea'>Username: <input type='text' name='user' required></label>
      <label class='formArea'>Password: <input type='password' name='password' required></label>
      <label class='formArea'>Confirm Password: <input type='password' name='confirmPass' required></label>
      <label class='formArea'><input type='submit' value='Signup' id='signupButton'></label>
  </div>
</body>
</html>