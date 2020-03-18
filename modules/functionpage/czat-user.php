<?php
  function _downloadUsersOnline()
  {
    global $conn;
    //$query = "SELECT user FROM online";
    $query = "SELECT user FROM online WHERE time BETWEEN timestamp(DATE_SUB(NOW(), INTERVAL 5 SECOND)) AND timestamp(NOW());";
    $sth = mysqli_query($conn,$query);
    //echo "Error: ".$query."<br>".mysqli_error($conn);
    $num_rows = mysqli_num_rows($sth);
    if($num_rows != 0)
    {
      $rows = array();
      while($r = mysqli_fetch_assoc($sth)) {
        $rows[] = $r;
      }
      return json_encode($rows);
    }
    else
    {
      return '';
    }
  }
  
  function _createUserOnline() {
    $user = $_SESSION["login"];
    global $conn;
    $sql = "INSERT INTO online (user) VALUES ('$user');";
    if(!(mysqli_query($conn,$sql)))
    {
      echo "Error: ".$sql."<br>".mysqli_error($conn);
    }
  }
  
  function _updateUserOnline()
  {
    global $conn;
    $user = $_SESSION["login"];
    $query = "SELECT user FROM online WHERE user = '$user'";
    $sth = mysqli_query($conn,$query);
    //echo "Error: ".$query."<br>".mysqli_error($conn);
    $num_rows = mysqli_num_rows($sth);
    //echo $num_rows;
    if($num_rows != 0)
    {
      $sql = "UPDATE online SET time=timestamp(NOW()) WHERE user = '$user'";
      $sth = mysqli_query($conn,$sql);
    }
    else
    {
      _createUserOnline();
    }
  }
  
  if(isset($_SESSION["login"]))
  {
    _updateUserOnline();
    echo _downloadUsersOnline();
  }
?>
