<?php

function input_string(array $input, string $key): string {
    return isset($input[$key]) && is_string($input[$key]) ? $input[$key] : '';
}

function escape_html(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function verify_stored_password(string $password, string $stored): bool {
    // Migrate the original application's MD5(addslashes(password)) on login.
    if (preg_match('/^[a-f0-9]{32}$/D', $stored)) {
        return hash_equals($stored, md5(addslashes($password)));
    }
    return password_verify($password, $stored);
}

function csrf_valid(string $provided, string $expected): bool {
    return $provided !== '' && $expected !== '' && hash_equals($expected, $provided);
}
