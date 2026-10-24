<?php

function requested_route(): string {
    return isset($_GET['strona']) ? input_string($_GET, 'strona') : 'start';
}

function route_config(string $route): ?array {
    // Never turn a request parameter into a filesystem path.
    $routes = [
        'start' => ['page', 'page/start.php', false],
        'rejestracja' => ['page', 'page/rejestracja.php', false],
        'aktywacja' => ['page', 'page/aktywacja.php', false],
        'users.info' => ['page', 'users/info.php', true],
        'users.czat' => ['page', 'users/czat.php', true],
        'function.login' => ['api', 'api/login.php', false],
        'function.logout' => ['api', 'api/logout.php', true],
        'function.user' => ['api', 'api/user.php', false],
        'function.czat' => ['api', 'api/czat.php', true],
    ];
    return $routes[$route] ?? null;
}

function is_site(): bool {
    $route = route_config(requested_route());
    return $route === null || $route[0] === 'page';
}

function view_sub_site(): void {
    $route = route_config(requested_route());
    if ($route === null) {
        http_response_code(404);
        include __DIR__ . '/../page/404.php';
    } elseif ($route[2] && !isset($_SESSION['login'])) {
        http_response_code(401);
        include __DIR__ . '/../page/401.php';
    } else {
        include __DIR__ . '/../' . $route[1];
    }
}

function view_function(): void {
    $route = route_config(requested_route());
    if ($route === null || $route[0] !== 'api') {
        http_response_code(404);
        return;
    }
    if ($route[2] && !isset($_SESSION['login'])) {
        http_response_code(401);
        echo 'Zaloguj się.';
        return;
    }
    include __DIR__ . '/../' . $route[1];
}
