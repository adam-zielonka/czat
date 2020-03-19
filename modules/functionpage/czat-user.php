<?php

function get_users_online() {
  global $conn;
  $query = "SELECT user FROM online WHERE time BETWEEN timestamp(DATE_SUB(NOW(), INTERVAL 5 SECOND)) AND timestamp(NOW());";
  $sth = mysqli_query($conn,$query);
  $num_rows = mysqli_num_rows($sth);
  if($num_rows != 0) {
    $rows = array();
    while($r = mysqli_fetch_assoc($sth)) {
      $rows[] = $r;
    }
    return json_encode($rows);
  }
  else {
    return '';
  }
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
  else {
    add_user_online();
  }
}

if(isset($_SESSION["login"])) {
  update_user_online();
  echo get_users_online();
}
