<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require './modules/function/utils.php';

function connect_to_mysql() {
  $host = env('DB_HOST', 'mariadb');
  $user = env('DB_USERNAME', 'root');
  $pass = env('DB_PASSWORD', 'php-chat');
  
  $conn = new mysqli($host, $user, $pass);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  return $conn;
}

load_envs();
$conn = connect_to_mysql();
$db = env('DB_NAME', 'chat');

$create_db = "
  CREATE DATABASE $db;
";

$create_czat = "
  CREATE TABLE czat (
    id int(11) NOT NULL AUTO_INCREMENT,
    time timestamp NOT NULL DEFAULT current_timestamp(),
    user varchar(256) NOT NULL,
    msg varchar(1024) NOT NULL,
    CONSTRAINT pk PRIMARY KEY (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

$create_online = "
  CREATE TABLE online (
    id int(11) NOT NULL AUTO_INCREMENT,
    user varchar(255) NOT NULL,
    time timestamp NOT NULL DEFAULT current_timestamp(),
    CONSTRAINT pk PRIMARY KEY (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

$create_users = "
  CREATE TABLE users (
    id int(11) NOT NULL AUTO_INCREMENT,
    login varchar(256) NOT NULL,
    password varchar(256) NOT NULL,
    email varchar(256) NOT NULL,
    joindate timestamp NOT NULL DEFAULT current_timestamp(),
    picture varchar(256) NOT NULL DEFAULT './img/logo.png',
    level int(11) NOT NULL DEFAULT 1,
    aktywacja int(11) NOT NULL DEFAULT 0,
    CONSTRAINT pk PRIMARY KEY (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

query($create_db, "Create db '$db': ");
$conn->select_db($db);
query($create_czat, "Create table 'czat': ");
query($create_online, "Create table 'online': ");
query($create_users, "Create table 'users': ");

function query($sql, $msg) {
  global $conn;
  echo $msg;
  if(!(mysqli_query($conn, $sql))) {
    echo "Failed: ".mysqli_error($conn);
  } else {
    echo "OK";
  }
  echo "<br/><br/>";
}
