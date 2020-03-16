<div class="tekst">
    <h1>MySQL + AJAX</h1>
    <div id="formularz" class="tekst">
        <?php
            global $typeOfDB;
            echo '<p>'.$typeOfDB.'</p>';
        ?>
	    <form action="" name="formularz" id="formDB" method="post" enctype="multipart/form-data" onsubmit="return false">
            <table>
			    <tr>
				    <td>Name:</td>
				    <td><input type="text" name="name" id="name" pattern="^[A-Ża-ż]{1,}$" required></td>
			    </tr>
			    <tr>
				    <td>Imię:</td>
				    <td><input type="text" name="imie" id="imie" pattern="^[A-Ża-ż]{1,}$" required></td>
			    </tr>
			    <tr>
				    <td>Nazwisko:</td>
				    <td><input  type="text" name="nazwisko" id="nazwisko" pattern="^[A-Ża-ż]{1,}$" required></td>
			    </tr>
                <tr>
				    <td>Twoje zdjęcie:</td>
				    <td><input type="file" name="photo" id="photo" size="25" required/></td>
			    </tr>
			    <tr>
				    <td></td>
				    <td><input type="submit" value="Dodaj" id="dodajDoBazy"></td>
			    </tr>
		    </table>
	    </form>	
    </div>
    <div id="dane" class="tekst">Trwa ładowanie danych...</div>	
</div>				
<script src="/js/mysql.js"></script>