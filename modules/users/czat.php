<style>
  <?php echo '.'.$_SESSION["login"]; ?> {
    color: #ffd800;
  }
</style>
<div id="czat" class="czat">Trwa ładowanie danych...</div>
<div class="sendtxt">
  <form action="" name="czat" onsubmit="return false">
    <input type="text" name="msg" id="msg" class="sendplace" required>
    <input type="submit" value="Wyślij" id="sendmsg">
  </form>
</div>
<div id="online" class="tekst">Trwa ładowanie userów...</div>
<script src="/js/chat.js"></script>
