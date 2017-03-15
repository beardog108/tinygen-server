<?php
/*
Copyright 2017 Kevin Froman - GNU AFFERO GENERAL PUBLIC LICENSE
*/
$userDB = './php/users.db'; # When in prod, this needs to be somewhere secure
$debugging = true;
if ($debugging){
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
}
?>