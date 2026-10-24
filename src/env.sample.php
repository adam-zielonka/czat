<?php

$variables = [
  'DB_HOST' => 'localhost',
  'DB_USERNAME' => 'chat',
  'DB_PASSWORD' => '',
  'DB_NAME' => 'chat',
];

foreach ($variables as $key => $value) {
  putenv("$key=$value");
}
