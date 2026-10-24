<?php

error_reporting(E_ALL);
ini_set('display_errors', '0');
require_once __DIR__ . '/modules/function/utils.php';
require_once __DIR__ . '/modules/function/security.php';
require_once __DIR__ . '/modules/function/site.php';
require_once __DIR__ . '/modules/function/mysql.php';

load_envs();
session_start([
    'use_strict_mode' => true,
    'cookie_httponly' => true,
    'cookie_secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'cookie_samesite' => 'Lax',
]);
$_SESSION['csrf'] ??= bin2hex(random_bytes(32));
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

$route = route_config(requested_route());
if ($route === null) {
    http_response_code(404);
    echo 'Nie znaleziono strony.';
    return;
}
if ($route[0] === 'api') {
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
        header('Allow: POST');
        http_response_code(405);
        return;
    }
    if (!csrf_valid(input_string($_SERVER, 'HTTP_X_CSRF_TOKEN'), $_SESSION['csrf'])) {
        http_response_code(403);
        echo 'Odśwież stronę i spróbuj ponownie.';
        return;
    }
}

try {
    $conn = connect_to_mysql();
    if (is_site()) include __DIR__ . '/modules/section/html.php';
    else view_function();
    $conn->close();
} catch (Throwable $error) {
    error_log('Chat request failed: ' . get_class($error));
    http_response_code(500);
    echo 'Wewnętrzny błąd serwera.';
}
