<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require './modules/function/utils.php';
require './modules/function/site.php';
require './modules/function/mysql.php';

load_envs();
session_start();
$conn = connect_to_mysql();

if (is_site()) include "./modules/section/html.php";
else view_function();

$conn->close();

