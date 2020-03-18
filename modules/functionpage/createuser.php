<?php
    
    function _checkExistEmail($email){
        global $conn;
        $sql = "SELECT * FROM users WHERE email = '$email';";
        $result = mysqli_query($conn,$sql);
        if(!$result)
            echo "Error: ".$sql."<br>".mysqli_error($conn);
        $num_rows = mysqli_num_rows($result);
        return $num_rows;
    }
    
    function _checkExistLogin($login){
        global $conn;
        $sql = "SELECT * FROM users WHERE login = '$login';";
        $result = mysqli_query($conn,$sql);
        if(!$result)
            echo "Error: ".$sql."<br>".mysqli_error($conn);
        $num_rows = mysqli_num_rows($result);
        return $num_rows;
    }
    
    if(isset($_POST["checkemail"]))
    {
        $email = addslashes($_POST["checkemail"]);
        echo _checkExistEmail($email);
    }
    
    if(isset($_POST["checklogin"]))
    {
        $login = addslashes($_POST["checklogin"]);
        echo _checkExistLogin($login);
    }
    
    if(isset($_GET["rejestruj"]))
    {
        $email = addslashes($_POST["email"]);
        $login = addslashes($_POST["login"]);
        $password = md5(addslashes($_POST["password"]));
        $photo = './img/logo.png';
        $kodaktywacji = md5($email + $login);
        global $conn;
        $sql = "INSERT INTO users (login, password, email, picture, aktywacja) VALUES ('$login', '$password', '$email', '$photo', '1');";
        if(!(mysqli_query($conn,$sql)))
        {
            echo "Error: ".$sql."<br>".mysqli_error($conn);
        }
        else
        {
            echo "Zajrejestowano";
        }
    
    }
    
    
    
    
?>
