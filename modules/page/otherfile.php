<div class="tekst">
    <h1>File Other</h1>

<?php

$maxFileSizeByte = 1024000;
$correctFileType = '';
$directoryIntoFile = './upload/';
$fileFormInputName = 'other';

$uploadFile = new UploadFile;
$uploadFile->_sendFileToServer($maxFileSizeByte,$correctFileType,$directoryIntoFile,$fileFormInputName);

if($uploadFile->ErrorMessage == "")
{
    /* tu mogę wysłać dane np. na serwer MySQL */
    echo $uploadFile->SuccesMessage;
}
else
    echo $uploadFile->ErrorMessage;


?>

</div>