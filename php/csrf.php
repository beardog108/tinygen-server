<?php
/*
Copyright 2017 Kevin Froman - GNU AFFERO GENERAL PUBLIC LICENSE
*/
if (! isset($_SESSION['CSRF'])){
  $_SESSION['CSRF'] = bin2hex(openssl_random_pseudo_bytes(20));
}
$CSRF = $_SESSION['CSRF'];
?>