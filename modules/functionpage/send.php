<?php
  if(isset($_POST["name"]) && isset($_POST["imie"]) && isset($_POST["nazwisko"]))
  {
    $name = addslashes($_POST["name"]);
    $imie = addslashes($_POST["imie"]);
    $nazwisko = addslashes($_POST["nazwisko"]);

    $maxFileSizeByte = 1024000;
    $correctFileType = 'image';
    $directoryIntoFile = './img/';
    $fileFormInputName = 'photo';

    $uploadFile = new UploadFile;
    $uploadFile->_sendFileToServer($maxFileSizeByte,$correctFileType,$directoryIntoFile,$fileFormInputName);

    if($uploadFile->ErrorMessage == "")
    {
      _addUserToPsiDB($name,$imie,$nazwisko,$uploadFile);
    }
    else
      echo $uploadFile->ErrorMessage; 
  }
  
  if(isset($_GET["del"])) 
  {
    _delUserFromPsiDB(addslashes($_GET["del"]));
  }
?>
