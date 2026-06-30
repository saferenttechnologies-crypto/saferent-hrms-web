<?php
return [
    'name' => $_ENV['APP_NAME'] ?? 'SafeRent HRMS',
    'url' => $_ENV['APP_URL'] ?? 'http://localhost:8080',
    'session_lifetime' => (int)($_ENV['SESSION_LIFETIME'] ?? 30),
    'security' => [
        'password_algo' => PASSWORD_ARGON2ID,
        'csrf_key' => '_csrf_token',
        'upload_max_bytes' => 10 * 1024 * 1024,
        'allowed_upload_mimes' => ['application/pdf','image/jpeg','image/png','application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
    ],
];
