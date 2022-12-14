<?php
    
function is_site() {
  if(isset($_GET["strona"])) {
    return (get_site_type(addslashes($_GET["strona"])) == 'function') ? false : true;
  } 
  else return true;
}

function view_sub_site() {
  if(!(isset($_GET["strona"])))
    include './modules/page/start.php';
  elseif(
    (get_site_type(addslashes($_GET["strona"])) == 'users') && 
    (file_exists('./modules/users/'.get_site_name(addslashes($_GET["strona"])).'.php'))
  ) {
    if (isset($_SESSION["login"]))
      include './modules/users/'.get_site_name(addslashes($_GET["strona"])) .'.php';
    else
      include './modules/page/401.php';
  }
  else {
    if(file_exists('./modules/page/'.addslashes($_GET["strona"]) .'.php'))
      include './modules/page/'.addslashes($_GET["strona"]) .'.php';
    else
      include './modules/page/404.php';
  }
}

function view_function() {
  if(file_exists('./modules/api/'.get_site_name(addslashes($_GET["strona"])) .'.php'))
    include './modules/api/'.get_site_name(addslashes($_GET["strona"])) .'.php';
  else
    include './modules/page/404.php';
}
