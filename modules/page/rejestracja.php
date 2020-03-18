<div class="tekst">
    <h1>Rejestracja</h1>
    <div id="formularz" class="tekst">
        <form action="" name="rejestracja" id="rejestracja" method="post" enctype="multipart/form-data" onsubmit="return false">
            <table>
                <tr>
                    <td>Login:</td>
                    <td><input type="text" name="login" id="login" pattern="^[A-Ża-ż0-9_.-]{5,}$" required></td>
                    <td id="testlogin">Wymagane, min 5 znaków (A-Ża-ż0-9_.-).</td>
                </tr>
                <tr>
                    <td>E-mail:</td>
                    <td><input type="email" name="email" id="email" required></td>
                    <td id="testemail">Wymagane.</td>
                </tr>
                <tr>
                    <td>Hasło:</td>
                    <td><input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required></td>
                    <td id="testpassword">Wymagane, min 6 znaków (przynajmniej jedna mała litera, duża litera i cyfra).</td>
                </tr>
                <tr>
                    <td>Powtórz hasło:</td>
                    <td><input type="password" name="passwordrepeat" id="passwordrepeat" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required></td>
                    <td id="testpasswordrepeat">Wymagane, takie same jak wyżej :-)</td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Rejestruj" id="send"></td>
                    <td></td>
                </tr>
            </table>
        </form>
    </div>
</div>
<script src="/js/rejestracja.js"></script>
