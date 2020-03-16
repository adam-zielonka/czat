<div class="tekst">
    <h1>Kontakt</h1>
<?php 
	if(isset($_POST["topic"]) && isset($_POST["email"]) && isset($_POST["msg"]) && isset($_POST["imie"]))
	{
		$topic = addslashes($_POST["topic"]);
        $email = addslashes($_POST["email"]);
        $message = addslashes($_POST["msg"]);
        $imie = addslashes($_POST["imie"]);
		echo 'Temat: '.$topic.'<br>';
        echo 'Imie: '.$imie.'<br>';
		echo 'Email: '.$email.'<br>';
		echo 'Wiadomość: '.$message.'<br>';

        include './modules/function/mail.php';

        $fromMail = $email;
        $fromName = $imie;
        $toMail = 'pocta@vp.pl';
        $toName = 'Adam Zielonka';
        $titleMail = $topic;
        $messageMail = "<!DOCTYPE HTML>
        <html>
        <head>
          <meta charset='UTF-8'>
          <title>$topic</title>
        </head>
        <body>
          <h2>Kontak Formularz Netumik</h2>
          <p>Kontaktowy e-mail od <strong>$imie $email</strong>.</p>
          <p>$message</p>
        </div>
        </body>
        </html>";

        _mail($fromMail,$fromName,$toMail,$toName,$titleMail,$messageMail);
	}
	else
	{
?>
	<form name="formularz" action="" method="post" >
        <table>
            <tr>
                <td>Temat:</td>
                <td><input type="text" name="topic" value="" required /></td>
            </tr>
            <tr>
                <td>Imie:</td>
                <td><input type="text" name="imie" value="" required /></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="email" value="" required /></td>
            </tr>
            <tr>
                <td>Wiadomość:</td>
                <td><textarea name="msg" rows="10" cols="20" required></textarea></td>
            </tr>
            <tr>
                <td> </td>
                <td><input type="submit" value="Wyślij" /></td>
            </tr>

        </table>
	</form>
<?php 
    }
?>
</div>