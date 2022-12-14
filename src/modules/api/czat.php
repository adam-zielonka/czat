<?php

function get_chat_msg($last = 0) {
  global $conn;
  if($last != 0) $query = "SELECT id,time,user,msg FROM czat WHERE id>'$last'";
  else $query = "SELECT id,time,user,msg FROM czat WHERE time BETWEEN timestamp(DATE_SUB(NOW(), INTERVAL 1 HOUR)) AND timestamp(NOW());";
  $sth = mysqli_query($conn,$query);
  $rows = array();
  while($r = mysqli_fetch_assoc($sth)) {
    $rows[] = $r;
  }
  return json_encode($rows);
}

function get_users_online() {
  global $conn;
  $query = "SELECT user FROM online WHERE time BETWEEN timestamp(DATE_SUB(NOW(), INTERVAL 5 SECOND)) AND timestamp(NOW());";
  $sth = mysqli_query($conn,$query);
  $rows = array();
  while($r = mysqli_fetch_assoc($sth)) {
    $rows[] = $r;
  }
  return json_encode($rows);
}

function add_user_online() {
  $user = $_SESSION["login"];
  global $conn;
  $sql = "INSERT INTO online (user) VALUES ('$user');";
  if(!(mysqli_query($conn,$sql))) {
    echo "Error: ".$sql."<br>".mysqli_error($conn);
  }
}

function update_user_online() {
  global $conn;
  $user = $_SESSION["login"];
  $query = "SELECT user FROM online WHERE user = '$user'";
  $sth = mysqli_query($conn,$query);
  $num_rows = mysqli_num_rows($sth);
  if($num_rows != 0) {
    $sql = "UPDATE online SET time=timestamp(NOW()) WHERE user = '$user'";
    $sth = mysqli_query($conn,$sql);
  }
  else add_user_online();
}

if(isset($_POST["msg"]) && isset($_SESSION["login"])) {
  $msg = htmlspecialchars(addslashes($_POST["msg"]));
  $user = $_SESSION["login"];
  global $conn;
  $sql = "INSERT INTO czat (user, msg) VALUES ('$user', '$msg');";
  if(!(mysqli_query($conn,$sql))) {
    // echo "Error: ".$sql."<br>".mysqli_error($conn);
  }
}

if(isset($_POST['nr']) && isset($_SESSION["login"])) {
  $nr = addslashes($_POST['nr']);
  update_user_online();

  echo '{"users":';
  echo get_users_online();
  echo ',"msg":';
  echo get_chat_msg($nr);
  echo '}';            
}
