<?php

$envFile = dirname(__DIR__) . '/.env';

if (!file_exists($envFile)) {
    die("Database configuration file not found.");
}

$env = parse_ini_file($envFile);

if ($env === false) {
    die("Failed to load database configuration.");
}

$host = $env['DB_HOST'] ?? '';
$user = $env['DB_USER'] ?? '';
$password = $env['DB_PASSWORD'] ?? '';
$database = $env['DB_NAME'] ?? '';
$port = (int) ($env['DB_PORT'] ?? 3306);

if ($host === '' || $user === '' || $database === '' || $port <= 0) {
    die("Incomplete database configuration.");
}

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>
