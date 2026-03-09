<?php
session_start();

// load credentials from external file if present
$envPath = __DIR__ . '/.env.php';
if (file_exists($envPath)) {
    require $envPath;
} else {
    // fallback defaults - adjust for your environment or create .env.php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'waste_system');
}

// open database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    // on production hide details but for debugging show message
    die("Connection failed: " . $conn->connect_error);
}

define('BASE_URL', 'https://waste-segregation.gamer.gd/');
define('UPLOAD_DIR', 'uploads/');
?>