<?php

$login = input_string($_POST, 'login');
$password = input_string($_POST, 'password');
http_response_code(401);
if ($login === '' || $password === '' || strlen($password) > 1024) {
    echo 'Nieprawidłowy login lub hasło.';
    return;
}
$user = db_query('SELECT id, login, password, aktywacja FROM users WHERE login = ? LIMIT 1', [$login])->fetch_assoc();
if (!$user || !$user['aktywacja'] || !verify_stored_password($password, $user['password'])) {
    echo 'Nieprawidłowy login lub hasło.';
    return;
}
$algorithm = strlen($password) > 72 ? PASSWORD_ARGON2ID : PASSWORD_DEFAULT;
if (password_needs_rehash($user['password'], $algorithm)) {
    db_query('UPDATE users SET password = ? WHERE id = ?', [password_hash($password, $algorithm), $user['id']]);
}
session_regenerate_id(true);
$_SESSION['login'] = $user['login'];
http_response_code(200);
echo 'Zostałeś zalogowany :-)';
