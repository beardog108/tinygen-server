<?php
/*
Copyright 2017 Kevin Froman - GNU AFFERO GENERAL PUBLIC LICENSE
*/

function createError($reason, $createType){
  // Show an error if there was one encountered while creating
  $_SESSION['createError'] = $reason;
  header('location: create.php?type=' . $createType);
  die(0);
}

function checkIfPost($CSRF, $createType){
  // Check if it was a post (creation upload) request, if so validate it
  $retVal = false;
  if (isset($_FILES['package'])){
    $retVal = true;
    if ($_FILES['package']['size'] > 10485760){
        createError('Your archive is too large', $createType);
    }
    if (pathinfo(basename($_FILES['package']['name']), PATHINFO_EXTENSION) != '.zip'){
        createError('Your archive is not in the zip format', $createType);
    }
  }
  return $retVal;
}

session_start();
include('php/checklogin.php');
include('php/csrf.php');
checkLogin();
include('php/settings.php');
include('php/userInfo.php');

$userInfo = new userInfo();
$user = $_SESSION['user'];
$createType = '';

$createError = false;
if (isset($_SESSION['createError'])){
  if ($_SESSION['createError'] != ''){
    $createError = true;
  }
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
  if (! $createError){
    if (checkIfPost($CSRF, $createType)){
        createError('Success!', $createType);
        //header('location: dashboard.php');
        //die(0);
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
  <script src='validate.js'></script>
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
      <h2 class='center'>Add <?php echo ucwords($createType);?></h2>
      <?php
      if (isset($_SESSION['createError'])){
        if ($_SESSION['createError'] != ''){
          echo '<h2 style="color: red;">' . $_SESSION['createError'] . '</h2>';
          $_SESSION['createError'] = '';
        }
      }
      ?>
      <div class='center'>
        <form method='post' action='create.php?type=<?php echo $createType;?>' onsubmit='return validateUpload("<?php echo $createType;?>");' enctype="multipart/form-data">
          <input name='csrf' value='<?php echo $CSRF;?>' type='hidden'>
          <label class='formArea'><?php echo ucwords($createType);?> Archive (.zip): <input required id='package' type='file' name='package' accept='.zip'></label>
          <label class='formArea'><input class='mainButton' type='submit' value='Create <?php echo ucwords($createType);?>'></label>
        </form>
      </div>
  </div>
</body>
</html>