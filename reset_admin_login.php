<?php
require __DIR__ . '/db.php';

$email = 'admin@ulpiana.edu';
$passwordPlain = '12345';
$hash = password_hash($passwordPlain, PASSWORD_BCRYPT);

$st = db()->prepare("INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, 'admin') ON DUPLICATE KEY UPDATE full_name=VALUES(full_name), password_hash=VALUES(password_hash), role='admin'");
$st->execute(['Admin Ulpiana', $email, $hash]);

echo "Admin reset OK\n";
echo "Email: {$email}\n";
echo "Password: {$passwordPlain}\n";
