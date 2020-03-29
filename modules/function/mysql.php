<?php

function connect_to_mysql() {
  $host = env('DB_HOST', 'mariadb');
  $user = env('DB_USERNAME', 'root');
  $pass = env('DB_PASSWORD', 'php-chat');
  $name = env('DB_NAME', 'chat');
  
  $conn = new mysqli($host, $user, $pass, $name);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  return $conn;
}
