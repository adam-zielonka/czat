<?php
  if(isset($_POST["msg"]) && isset($_SESSION["login"]))
  {
    $msg = htmlspecialchars(addslashes($_POST["msg"]));
    $user = $_SESSION["login"];
    global $conn;
    $sql = "INSERT INTO czat (user, msg) VALUES ('$user', '$msg');";
    if(!(mysqli_query($conn,$sql)))
    {
      echo "Error: ".$sql."<br>".mysqli_error($conn);
    }
  }
?>
