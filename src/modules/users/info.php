<div class="tekst">
  <h1>Info o użytkowniku</h1>
  <?php
    $user = db_query('SELECT login, email FROM users WHERE login = ? LIMIT 1', [$_SESSION['login']])->fetch_assoc();
    if ($user) echo escape_html($user['login']) . '<br>' . escape_html($user['email']);
  ?>
</div>
