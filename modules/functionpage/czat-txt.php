<?php

function get_chat_msg($last = 0) {
  global $conn;
  if($last == 0) $query = "SELECT id,time,user,msg FROM czat WHERE id>'$last'";
  else $query = "SELECT id,time,user,msg FROM czat WHERE time BETWEEN timestamp(DATE_SUB(NOW(), INTERVAL 1 HOUR)) AND timestamp(NOW());";
  $sth = mysqli_query($conn,$query);
  $num_rows = mysqli_num_rows($sth);
  if($num_rows != 0) {
    $rows = array();
    while($r = mysqli_fetch_assoc($sth)) {
      $rows[] = $r;
    }
    return json_encode($rows);
  }
  else return '';
}

if(isset($_GET['nr']) && isset($_SESSION["login"])) {
  get_chat_msg(addslashes($_GET['nr']));
}
