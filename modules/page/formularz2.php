<div class="tekst">
    <h1>Formularz 2</h1>
    <div id="formularz" class="tekst">
        <form action="" name="formularz">
            <table>
				<tr>
					<td>Imię:</td>
					<td><input type="text" name="firstname" id="imie" pattern="^[A-Ża-ż]{1,}$" required></td>
                    <td id="testimie"></td>
				</tr>
				<tr>
					<td>Nazwisko:</td>
					<td><input  type="text" name="lastname" id="nazwisko" pattern="^[A-Ża-ż]{1,}$" required></td>
                    <td id="testnazwisko"></td>
				</tr>
				<tr>
					<td>Wiek:</td>
					<td><input type="number" name="wiek" id="wiek" min="18" max="100" required></td>
                    <td id="testwiek"></td>
				</tr>
				<tr>
					<td>E-mail:</td>
					<td><input type="email" name="email" id="email" required></td>
                    <td id="testemail"></td>
				</tr>
				<tr>
					<td>Telefon</td>
					<td><input type="tel" name="telefon" id="telefon" pattern="^[0-9]{9}$" required></td>
                    <td id="testtelefon"></td>
				</tr>
				<tr>
					<td>Miasto</td>
					<td><input type="text" name="miasto" id="miasto" pattern="^[A-Ża-ż]{1,}$" required></td>
                    <td id="testmiasto"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="button" onclick="Create()" value="Dodaj"></td>
                    <td></td>
				</tr>
			</table>
		</form>	
    </div>
	<div id="dane"></div>					
</div>
<script src="/js/formularz2.js"></script>