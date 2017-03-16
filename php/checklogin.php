<?php
/*
Copyright 2017 Kevin Froman - GNU AFFERO GENERAL PUBLIC LICENSE
*/
function checkLogin(){
  if (isset($_SESSION['loggedIn'])){
    if ($_SESSION['loggedIn'] == false){
      header('location: index.php');
      die(0);
    }
  }
  else{
    header('location: index.php');
    die(0);
  }
}
?>