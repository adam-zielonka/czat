<?php
    if(!(isset($_SESSION["login"])))
    {
?>
<div class="tekst">
    <p>Logowanie</p>
    <div id="formularzlogowania" style="float: left">
        <form action="" name="formularz" method="post" id="logowanie" onsubmit="return false">
            <table>
                <tr>
                    <td>Login:</td>
                    <td><input type="text" name="login" id="loginlog" required></td>
                </tr>
                <tr>
                    <td>Hasło:</td>
                    <td><input type="password" name="password" id="passwordlog" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Zaloguj" id="zaloguj"></td>
                </tr>
            </table>
        </form>
    </div>
    <div id="komunikat" style="clear: both;"></div>
</div>
<script src="/js/login.js"></script>
<?php
    }
    else
    {
?>
<div class="tekst">
    <p>Urzytkownik:<br><?php
        if(isset($_SESSION["login"]))
             echo $_SESSION["login"];
        ?></p>
    <div id="formularzlogowania" style="float: left">
        <form action="" name="formularz" method="post" id="logowanie" onsubmit="return false">
            <input type="submit" value="Wyloguj" id="wyloguj">
        </form>
    </div>
    <div id="komunikat" style="clear: both;"></div>
</div>
<script src="/js/login.js"></script>
<?php
    }
?>