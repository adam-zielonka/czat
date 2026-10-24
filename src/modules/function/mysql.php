<?php

function connect_to_mysql(): mysqli {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $password = env('DB_PASSWORD');
    if (!is_string($password) || $password === '') {
        throw new RuntimeException('DB_PASSWORD is required.');
    }
    $connection = new mysqli(env('DB_HOST', 'mariadb'), env('DB_USERNAME', 'chat'), $password, env('DB_NAME', 'chat'));
    $connection->set_charset('utf8mb4');
    return $connection;
}

function db_query(string $sql, array $params = []): mysqli_result|bool {
    global $conn;
    return $conn->execute_query($sql, $params);
}
