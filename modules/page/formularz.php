<div class="tekst">
    <h1>Formularz</h1>
    <div id="formularz" class="tekst">
		<form action="" name="formularz" onsubmit="return false">
			<table class="form">
                <tr>
                    <td>Error:</td>
					<td><input type="text" name="error" id="error" disabled="disabled"></td>
                    <td><input type="button" onclick="ReadByID()" value="ReadByID"></td>
                    <td><input type="submit" onclick="Create()" value="Create"></td>
                    <td><input type="button" onclick="Update()" value="Update"></td>
                    <td><input type="button" onclick="Delete()" value="Delete"></td>
				</tr>
                <tr>
                    <td>ID:</td>
					<td><input type="number" name="id" id="idID" required></td>
                    <td>V</td>
					<td>V</td>
                    <td>V</td>
					<td>V</td>
				</tr>
				<tr>
					<td>Imię:</td>
					<td><input type="text" name="firstname" id="imie" pattern="^[A-Ż]+[a-ż]{2,}$" required></td>
                    <td> </td>
					<td>V</td>
                    <td>V*</td>
					<td> </td>
				</tr>
				<tr>
					<td>Nazwisko:</td>
					<td><input  type="text" name="lastname" id="nazwisko" pattern="^[A-Ż]+[a-ż]{2,}$" required></td>
                    <td> </td>
					<td>V</td>
                    <td>V*</td>
					<td> </td>
					</tr>
				<tr>
					<td>E-mail:</td>
					<td><input type="email" name="email" id="email" required></td>
                    <td> </td>
					<td>V</td>
                    <td>V*</td>
					<td> </td>
				</tr>
            </table>
		</form>
        <p>V - pola obowiązkowe (nie mogą być puste)</p>
        <p>V* - pola opcjonalne (pozostaw puste jeśli niechcesz nic zmnieniać)</p>
    </div>
    <div id="dane" class="tekst"></div>			
</div>
<script src="/js/formularz.js"></script>