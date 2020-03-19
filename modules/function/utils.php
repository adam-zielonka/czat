<?php

function get_site_name($fileName) {   
  return substr($fileName, strpos($fileName, ".") + 1);
}

function get_site_type($fileName) {    
  return substr($fileName, 0, strpos($fileName, "."));
}

function load_envs() {
  if(file_exists('./env.php')) {
    include './env.php';
  }  
}

function env($key, $default = null) {
  $value = getenv($key);
  return ($value === false) ? $default : $value;
}
