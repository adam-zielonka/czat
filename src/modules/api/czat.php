<?php

$user = $_SESSION['login'];
if (isset($_POST['msg'])) {
    $message = input_string($_POST, 'msg');
    if ($message === '' || strlen($message) > 1024) {
        http_response_code(400);
        return;
    }
    // Keep the existing escaped storage format for older chat history.
    db_query('INSERT INTO czat (user, msg) VALUES (?, ?)', [$user, escape_html($message)]);
}
$last = filter_var(input_string($_POST, 'nr'), FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
if ($last === false) {
    http_response_code(400);
    return;
}
if (db_query('SELECT user FROM online WHERE user = ? LIMIT 1', [$user])->num_rows) {
    db_query('UPDATE online SET time = CURRENT_TIMESTAMP WHERE user = ?', [$user]);
} else {
    db_query('INSERT INTO online (user) VALUES (?)', [$user]);
}
$messages = $last > 0
    ? db_query('SELECT id,time,user,msg FROM czat WHERE id > ? ORDER BY id LIMIT 200', [$last])
    : db_query('SELECT id,time,user,msg FROM czat WHERE time >= DATE_SUB(NOW(), INTERVAL 1 HOUR) ORDER BY id LIMIT 200');
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'users' => db_query('SELECT user FROM online WHERE time >= DATE_SUB(NOW(), INTERVAL 5 SECOND)')->fetch_all(MYSQLI_ASSOC),
    'msg' => $messages->fetch_all(MYSQLI_ASSOC),
], JSON_THROW_ON_ERROR);
