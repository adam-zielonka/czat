<?php
  if(isset($_POST["login"]) && isset($_POST["password"]))
  {
    $login = addslashes($_POST['login']);
    $password = md5(addslashes($_POST['password']));

    global $conn;
    $sql = "SELECT password FROM users Where login = '$login';";
    $result = mysqli_query($conn,$sql);
    $row = $result->fetch_array(MYSQLI_NUM);
    $passwordDB = $row[0];
    if(mysqli_num_rows($result) == 0)
    {
      echo 'Urzytkownik nie istnieje :-(';
    }
    else
    {
      $sql = "SELECT aktywacja FROM users Where login = '$login';";
      $result = mysqli_query($conn,$sql);
      $row = $result->fetch_array(MYSQLI_NUM);
      $aktywacja = $row[0];
      if($aktywacja != 0)
      {
        if($passwordDB == $password)
        {
            $_SESSION["login"] = $login;
            echo "Zostałeś zalogowany :-)";
            echo "<script>location.reload();</script>";
        }
        else
        {
            echo "Złe hasło :-(";
        }
      } 
      else
      {
          echo 'Konto nieaktywne :-(';
      }
    }  
  }
?>
