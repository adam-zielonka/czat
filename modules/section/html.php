<!doctype html>
<html>
	<head>
    <?php include "./modules/section/head.php"; ?>
	</head>
	<body>
		<div id="strona">
			<header>
        <?php include "./modules/section/header.php"; ?>
      </header>
			<nav>
        <?php include "./modules/section/menu.php"; ?>
      </nav>
			<article>
         <?php view_sub_site(); ?>
      </article>
			<footer>
        <?php include "./modules/section/footer.php"; ?>
      </footer>
		</div>
	</body>
</html>
