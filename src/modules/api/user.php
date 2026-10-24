<?php

if (isset($_POST['checkemail'])) {
    echo db_query('SELECT id FROM users WHERE email = ? LIMIT 1', [input_string($_POST, 'checkemail')])->num_rows;
    return;
}
if (isset($_POST['checklogin'])) {
    echo db_query('SELECT id FROM users WHERE login = ? LIMIT 1', [input_string($_POST, 'checklogin')])->num_rows;
    return;
}
if (!isset($_GET['rejestruj'])) {
    http_response_code(400);
    return;
}
$email = input_string($_POST, 'email');
$login = input_string($_POST, 'login');
$password = input_string($_POST, 'password');
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 254 ||
    !preg_match('/^[\p{L}0-9_.-]{3,64}$/uD', $login) ||
    strlen($password) < 12 || strlen($password) > 72) {
    http_response_code(400);
    echo 'Podaj prawidłowy login i e-mail oraz hasło od 12 do 72 bajtów.';
    return;
}
if (db_query('SELECT id FROM users WHERE login = ? OR email = ? LIMIT 1', [$login, $email])->num_rows) {
    http_response_code(409);
    echo 'Login lub adres e-mail jest zajęty.';
    return;
}
db_query('INSERT INTO users (login, password, email, picture, aktywacja) VALUES (?, ?, ?, ?, 1)',
    [$login, password_hash($password, PASSWORD_DEFAULT), $email, './img/logo.png']);
echo 'Zarejestrowano';
