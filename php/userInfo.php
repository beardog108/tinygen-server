<?php
/*
Copyright 2017 Kevin Froman - GNU AFFERO GENERAL PUBLIC LICENSE
*/
class MyDB extends SQLite3 {
   function __construct() {
     include('php/settings.php');
      $this->open($userDB);
   }
}
class PluginsDB extends SQLite3 {
   function __construct() {
     include('php/settings.php');
      $this->open($pluginsDB);
   }
}
class userInfo {
  public function userExists($user){
    // Check if a user exists or not
    $rowCount = 0;
    $db = new MyDB();
    $user = $db->escapeString($user);
    $exists = false;
    $sql =<<<EOF
       SELECT * from Users where name = '$user';
EOF;

    $ret = $db->query($sql);
    while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
      $rowCount = $rowCount + 1;
    }
    if ($rowCount > 0){
      $exists = true;
    }
    $db->close();
    return $exists;
  }

  public function addUser($user, $password){
    $db = new MyDB();
    $user = $db->escapeString($user);
    $date = date('U');
    $sql =<<<EOF
   INSERT INTO Users (name, date, password)
   VALUES ('$user', '$date', '$password');
EOF;
    $ret = $db->exec($sql);
    if(!$ret){
       $ret = false;
    } else {
      $ret = true;
    }
    $db->close();
    return $ret;
  }
  public function loginUser($user, $password, $force){
    $login = false;
    if ($force){
      $_SESSION['user'] = $user;
      $_SESSION['loggedIn'] = true;
      $login = true;
    }
    else{
      $db = new MyDB();
      $user = $db->escapeString($user);
      $sql =<<<EOF
            SELECT * from Users where name = '$user';
EOF;
      $ret = $db->query($sql);
      while($row = $ret->fetchArray(SQLITE3_ASSOC)){
        if (password_verify($password, $row['password'])){
          $login = true;
        }
        else{
          $login = false;
        }
      }
    }
    return $login;
  }
  public function listUserPlugins($user){
    $rowCount = 0;
    $db = new PluginsDB();
    $retData = '';
    $user = $db->escapeString($user);
    $sql =<<<EOF
       SELECT * from Plugins where owner = '$user';
EOF;
    $ret = $db->query($sql);
    while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
      $rowCount = $rowCount + 1;
      $retData = $retData . $row['name'] . '<br>' . $row['description'] . '<br>';
    }
    if ($rowCount == 0){
      $retData = '<br><br><div class=\'center\'>Nothing here!</div><br><br>';
    }
    return $retData;
  }
}
?>