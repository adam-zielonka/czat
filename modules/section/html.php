<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="description" content="Tworzenie i uczenie się programowania stron internetowych">
    <meta name="keywords" content="HTML,CSS,XML,JavaScript,PHP,MySQL">
    <meta name="author" content="Adam Zielonka">
    <title>Czat</title>
    <link rel="stylesheet" type="text/css" href="/css/styl.css">
    <script src="/js/jquery-2.1.4.min.js"></script>
    <style>
    </style>
  </head>
  <body>
    <header>
      <div class='title'>
        Czat
      </div>
      <div class='login'>
        <?php include './modules/page/login.php'; ?>
      </div>
    </header>
    <main>
      <nav>
        <?php include "./modules/section/menu.php"; ?>
      </nav>
      <article>
        <?php view_sub_site(); ?>
      </article>
    </main>
    <footer>
      <div class="tekst">
        &copy; 2015 Adam Zielonka
      </div>
    </footer>
  </body>
</html>
