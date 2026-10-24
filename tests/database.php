<?php
require __DIR__ . '/../src/modules/function/utils.php';
require __DIR__ . '/../src/modules/function/mysql.php';
require __DIR__ . '/../src/modules/function/security.php';

$conn = connect_to_mysql();
$conn->begin_transaction();
try {
    $name = "test' OR 1=1 --";
    $password = "migration test ' password";
    db_query('INSERT INTO users (login, password, email, aktywacja) VALUES (?, ?, ?, 1)',
        [$name, md5(addslashes($password)), 'regression@example.invalid']);
    $row = db_query('SELECT id, password FROM users WHERE login = ?', [$name])->fetch_assoc();
    if (!$row || !verify_stored_password($password, $row['password'])) throw new RuntimeException('Prepared query or legacy login failed');
    db_query('UPDATE users SET password = ? WHERE id = ?', [password_hash($password, PASSWORD_DEFAULT), $row['id']]);
    $updated = db_query('SELECT password FROM users WHERE id = ?', [$row['id']])->fetch_assoc();
    if (!password_verify($password, $updated['password'])) throw new RuntimeException('Password migration failed');
    $count = db_query('SELECT id FROM users WHERE login = ?', ["' OR 1=1 --"])->num_rows;
    if ($count !== 0) throw new RuntimeException('SQL injection regression');
    db_query('INSERT INTO czat (user, msg) VALUES (?, ?)', [$name, escape_html('<img src=x onerror=alert(1)>')]);
    echo "Prepared SQL, legacy migration and message storage passed.\n";
} finally {
    $conn->rollback();
    $conn->close();
}
