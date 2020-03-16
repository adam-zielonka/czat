<?php

?>
<div class="tekst">
    <h1>UpLoad</h1>
    <a class="link" href="https://davidwalsh.name/basic-file-uploading-php">https://davidwalsh.name/basic-file-uploading-php</a>
    <form action="/photofile" method="post" enctype="multipart/form-data">
	    Twoje zdjęcie: <input type="file" name="photo" size="25" />
	    <input type="submit" name="submit" value="Wyślij" /><br>
    </form>
    <form action="/otherfile" method="post" enctype="multipart/form-data">
	    Twoj plik: <input type="file" name="other" size="25" />
	    <input type="submit" name="submit" value="Wyślij" />
    </form>
</div>