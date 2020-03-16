<?php

function _mail($fromMail,$fromName,$toMail,$toName,$titleMail,$messageMail)
{
    
    // date_default_timezone_set('Etc/UTC');
    // require './modules/function/PHPMailer/PHPMailerAutoload.php';

    // $mail = new PHPMailer;
    // $mail->setLanguage('pl', './modules/function/PHPMailer/language/');
    // $mail->isSMTP();

    // #SMTP set
    // $mail->Debugoutput = 'html';
    // $mail->Host = '';
    // $mail->Port = 587;
    // $mail->SMTPSecure = 'tls';
    // $mail->SMTPAuth = true;
    // $mail->Username = "";
    // $mail->Password = "";

    // #Message set
    // $mail->CharSet = 'UTF-8';
    // $mail->setFrom($fromMail, $fromName);
    // $mail->addAddress($toMail, $toName);
    // $mail->Subject = $titleMail;
    // $mail->msgHTML($messageMail);

    // if (!$mail->send()) {
    //     echo "Błąd wysyłania: " . $mail->ErrorInfo;
    // } else {
    //     echo "Wiadomość wysłana!";
    // }

}

?>
