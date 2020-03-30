<?php if(!(isset($_SESSION["login"]))) { ?>

  <form action="" name="formularz" method="post" id="logowanie" onsubmit="return false">
    <input placeholder="Name" type="text" name="login" id="loginlog" required>
    <input placeholder="Password" type="password" name="password" id="passwordlog" required>
    <input type="submit" value="Login" id="zaloguj">
  </form>
  <div id="komunikat" style="clear: both;"></div>

<?php } else { ?>

  <form action="" name="formularz" method="post" id="logowanie" onsubmit="return false">
    <?php if(isset($_SESSION["login"])) echo $_SESSION["login"]; ?>
    <input type="submit" value="Wyloguj" id="wyloguj">
  </form>
  <div id="komunikat" style="clear: both;"></div>

<?php } ?>

  <script src="/js/login.js"></script>
