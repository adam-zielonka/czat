<?php 

//Włączenie wyświetlania błędów
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require './modules/function/others.php';
require './modules/function/site.php';
require './modules/function/mysql.php';

$site = true;

//Local = true
//Azure = false
$localDataBaseActive = true;
$conn = _connectMySQL($localDataBaseActive);

$site = _isSite();
if ($site == true) {
    include "./modules/section/html.php";
}
else
    _viewFunction();

//Zamykanie połączenia z MySQL
$conn->close();
?>
