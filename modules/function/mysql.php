<?php
function _connectMySQL($setLocalOrOnlineDB)
{
  global $typeOfDB;
  $local = $setLocalOrOnlineDB;
  if($_SERVER['SERVER_NAME'] == 'localhost')
  {
    if($local)
    {
      #Lokalna Baza Danych
      $servername = 'localhost';
      $username = 'root';
      $password = 'root';
      $db = 'chat';
      $typeOfDB = "Lokalna Baza Danych";
    }
    else
    {
      #Remote
      $servername = '';
      $username = '';
      $password = '';
      $db = '';
      $typeOfDB = "";
    }
  }
  else
  {
    #Remote
    $servername = '';
    $username = '';
    $password = '';
    $db = '';
    $typeOfDB = "";
  }

  $conn = new mysqli($servername, $username, $password,$db);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  return $conn;
}

?>
