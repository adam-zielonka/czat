<?php

function is_email_exist($email) {
  global $conn;
  $sql = "SELECT * FROM users WHERE email = '$email';";
  $result = mysqli_query($conn,$sql);
  if(!$result)
    echo "Error: ".$sql."<br>".mysqli_error($conn);
  $num_rows = mysqli_num_rows($result);
  return $num_rows;
}

function is_login_exist($login) {
  global $conn;
  $sql = "SELECT * FROM users WHERE login = '$login';";
  $result = mysqli_query($conn,$sql);
  if(!$result)
    echo "Error: ".$sql."<br>".mysqli_error($conn);
  $num_rows = mysqli_num_rows($result);
  return $num_rows;
}

if(isset($_POST["checkemail"])) {
  $email = addslashes($_POST["checkemail"]);
  echo is_email_exist($email);
}

if(isset($_POST["checklogin"])) {
  $login = addslashes($_POST["checklogin"]);
  echo is_login_exist($login);
}

if(isset($_GET["rejestruj"])) {
  $email = addslashes($_POST["email"]);
  $login = addslashes($_POST["login"]);
  $password = md5(addslashes($_POST["password"]));
  $photo = './img/logo.png';
  $kodaktywacji = md5($email + $login);
  global $conn;
  $sql = "INSERT INTO users (login, password, email, picture, aktywacja) VALUES ('$login', '$password', '$email', '$photo', '1');";
  if(!(mysqli_query($conn,$sql))) {
    echo "Error: ".$sql."<br>".mysqli_error($conn);
  }
  else echo "Zarejestrowano";
}
