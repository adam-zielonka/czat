<?php
  function _downloadCzatToJSON()
  {
    global $conn;
    $query = "SELECT id,time,user,msg FROM czat WHERE time BETWEEN timestamp(DATE_SUB(NOW(), INTERVAL 1 HOUR)) AND timestamp(NOW());";
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
  
  function _downloadCzatTxt($last)
  {
    global $conn;
    $query = "SELECT id,time,user,msg FROM czat WHERE id>'$last'";
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
  
  if(isset($_GET['nr']) && isset($_SESSION["login"]))
  {
    $nr = addslashes($_GET['nr']);
    if($nr == 0)
      echo _downloadCzatToJSON();
    else
      echo _downloadCzatTxt($nr);
  }
?>
