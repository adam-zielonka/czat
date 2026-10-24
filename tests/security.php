<?php
require __DIR__ . '/../src/modules/function/security.php';
require __DIR__ . '/../src/modules/function/site.php';

function check(bool $condition, string $message): void {
    if (!$condition) throw new RuntimeException($message);
}

foreach (['../users/info', '../../install', 'function.../install', 'function.unknown', '', 'users.info/../czat'] as $path) {
    check(route_config($path) === null, 'Rejected traversal/unknown route: ' . $path);
}
check(route_config('users.info')[2] === true, 'Profile requires authentication');
check(route_config('function.czat')[2] === true, 'Chat API requires authentication');
check(route_config('function.login')[1] === 'api/login.php', 'Known login route');
foreach (["a long strong password", "quote' slash\\ password", str_repeat('long-password-', 8)] as $password) {
    $legacy = md5(addslashes($password));
    check(verify_stored_password($password, $legacy), 'Existing passwords remain usable');
    check(!verify_stored_password('wrong', $legacy), 'Legacy password rejects incorrect input');
    $modern = password_hash($password, strlen($password) > 72 ? PASSWORD_ARGON2ID : PASSWORD_DEFAULT);
    check(verify_stored_password($password, $modern), 'New password verification');
    check(!verify_stored_password('wrong', $modern), 'New password rejects incorrect input');
    check(password_needs_rehash($legacy, PASSWORD_DEFAULT), 'Legacy hashes require migration');
}
check(!csrf_valid('', ''), 'Empty CSRF tokens rejected');
check(!csrf_valid('attacker', 'session-token'), 'Wrong CSRF token rejected');
check(csrf_valid('session-token', 'session-token'), 'Valid CSRF token accepted');
check(input_string(['login' => ['malformed']], 'login') === '', 'Array inputs rejected');
check(escape_html('<script>"') === '&lt;script&gt;&quot;', 'Untrusted output escaped');
echo "Security regressions passed.\n";
