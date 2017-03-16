<?php
/*
Copyright 2017 Kevin Froman - GNU AFFERO GENERAL PUBLIC LICENSE
*/

function createError($reason, $createType){
  $_SESSION['createError'] = $reason;
  header('location: create.php?type=' . $createType);
  die(0);
}

function checkIfPost(){
  // Check if it was a post (creation upload) request, if so validate it
  $retVal = false;
  if (isset($_POST['createType'])){
    $createType = $_POST['createType'];
    if ($createType != 'plugin' || $createType != 'theme'){
      header('location: dashboard.php');
      die(0);
    }
  }
  if ($CSRF != $_POST['csrf']){
    createError('Invalid request token', $createType);
  }
  if (isset($_POST['package'])){
    // Proccess it
  }
}

session_start();
include('php/checklogin.php');
checkLogin();
include('php/csrf.php');
include('php/settings.php');
include('php/userInfo.php');

$userInfo = new userInfo();
$user = $_SESSION['user'];
$createType = '';

if (checkIfPost()){
  //createItem()
}

if (isset($_GET['type'])){
  if ($_GET['type'] == 'plugin'){
    $createType = 'plugin';
  }
  elseif ($_GET['type'] == 'theme'){
    $createType = 'theme';
  }
  else{
    header('location: dashboard.php');
    die(0);
  }
}
else{
  header('location: dashboard.php');
  die(0);
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
    <h1 class='title'>TinyGen Dashboard</h1>
  </div>
  <hr>
  <div class='center'>
    <p>Logged in as: <?php echo $user;?> <a href='logout.php?CSRF=<?php echo $CSRF;?>'>Logout</a></p>
  </div>
  <div class='contentArea'>
      <h2 class='center'>Create <?php echo ucwords($createType);?></h2>
      <?php
      if (isset($_SESSION['createError'])){
        if ($_SESSION['createError'] != ''){
          echo '<h2 style="color: red;">' . $_SESSION['createError'] . '</h2>';
          $_SESSION['createError'] = '';
        }
      }
      ?>
      <div class='center'>
        <form method='post' action='create.php' onsubmit='return validateUpload("<?php echo $createType;?>");'>
          <input name='csrf' value='<?php echo $CSRF;?>' type='hidden'>
          <input name='createType' value='<?php echo $createType;?>' type='hidden'>
          <label class='formArea'><?php echo ucwords($createType);?> Archive (.zip): <input type='file' name='package' accept='.zip'></label>
          <label class='formArea'><input class='mainButton' type='submit' value='Create <?php echo ucwords($createType);?>'></label>
        </form>
      </div>
  </div>
</body>
</html>