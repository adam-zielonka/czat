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
    
    if(isset($_GET["checkphoto"]))
    {
        $maxFileSizeByte = 1024000;
        $correctFileType = 'image';
        $directoryIntoFile = './img/';
        $fileFormInputName = 'photo';
    
        $uploadFile = new UploadFile;
        echo $uploadFile->_checkFileBeforSend($maxFileSizeByte,$correctFileType,$directoryIntoFile,$fileFormInputName);
    }
    
    if(isset($_GET["rejestruj"]))
    {
        $email = addslashes($_POST["email"]);
        $login = addslashes($_POST["login"]);
        $password = md5(addslashes($_POST["password"]));
        $photo = './img/logo.png';
        $kodaktywacji = md5($email + $login);
        if(isset($_FILES["photo"]))
            if($_FILES["photo"]["name"] != '') 
            {
                $maxFileSizeByte = 1024000;
                $correctFileType = 'image';
                $directoryIntoFile = './img/';
                $fileFormInputName = 'photo';
    
                $uploadFile = new UploadFile;
                $uploadFile->_sendFileToServer($maxFileSizeByte,$correctFileType,$directoryIntoFile,$fileFormInputName);
                $photo = $uploadFile;
            }
        global $conn;
        $sql = "INSERT INTO users (login, password, email, picture, aktywacja) VALUES ('$login', '$password', '$email', '$photo', '1');";
        if(!(mysqli_query($conn,$sql)))
        {
            echo "Error: ".$sql."<br>".mysqli_error($conn);
        }
        else
        {
            echo "Zajrejestowano".'<br> Czekaj na wiadomość aktywacyjną. ';
            
            include './modules/function/mail.php';
    
            $fromMail = 'netumik@gmail.com';
            $fromName = 'NetUmik';
            $toMail = $email;
            $toName = $login;
            $titleMail = 'Rejsestracja w Serwisie NetUmik';
            $messageMail = "<!DOCTYPE HTML>
            <html>
            <head>
              <meta charset='UTF-8'>
              <title>Rejsestracja w Serwisie NetUmik</title>
            </head>
            <body>
              <h2></h2>
              <p><strong>Witaj $login!</strong></p>
              <p>Dziękuje z rejestracje w serwisie. Aby aktywować konto należy kliknąć w poniższy link:</p>
              <p><a href='https://pcz.azurewebsites.net/aktywacja?kod=$kodaktywacji&user=$login'>https://pcz.azurewebsites.net/aktywacja?kod=$kodaktywacji&user=$login'</a></p>
            </div>
            </body>
            </html>";
    
            _mail($fromMail,$fromName,$toMail,$toName,$titleMail,$messageMail);
        }
    
    }
    
    
    
    
?>
