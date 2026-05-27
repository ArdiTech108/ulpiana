<?php
$envPath = __DIR__ . '/.env';
$env = file_exists($envPath) ? parse_ini_file($envPath) : [];

return [
    'db_host' => $env['DB_HOST'] ?? '127.0.0.1',
    'db_name' => $env['DB_NAME'] ?? 'ulpiana_db',
    'db_user' => $env['DB_USER'] ?? 'root',
    'db_pass' => $env['DB_PASS'] ?? '',
    'base_url' => $env['BASE_URL'] ?? '',
    'mail_host' => $env['MAIL_HOST'] ?? '',
    'mail_port' => $env['MAIL_PORT'] ?? 587,
    'mail_user' => $env['MAIL_USER'] ?? 'no-reply@ulpiana.local',
    'mail_pass' => $env['MAIL_PASS'] ?? '',
    'mail_from_name' => $env['MAIL_FROM_NAME'] ?? 'Gjimnazi Ulpiana',
    'google_client_id' => $env['GOOGLE_CLIENT_ID'] ?? '',
    'google_client_secret' => $env['GOOGLE_CLIENT_SECRET'] ?? '',
    'private_dashboard_key' => $env['PRIVATE_DASHBOARD_KEY'] ?? '',
    'allow_demo_login' => filter_var($env['ALLOW_DEMO_LOGIN'] ?? false, FILTER_VALIDATE_BOOLEAN)
];
