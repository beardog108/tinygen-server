<?php
/*
Copyright 2017 Kevin Froman - GNU AFFERO GENERAL PUBLIC LICENSE
*/
session_start();
include('php/csrf.php');

if (!isset($_GET['CSRF'])){
  die('Invalid token1');
}

if (! isset($_SESSION['CSRF'])){
  die('Invalid token2');
}
if ($_SESSION['CSRF'] != $_GET['CSRF']){
  die('Invalid token3');
}

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

$_SESSION['loggedIn'] = false;
$_SESSION['user'] = '';
header('location: index.php');

?>