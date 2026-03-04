<?php
session_start();

require '.env.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

define('BASE_URL', 'https://waste-segregation.gamer.gd/');
define('UPLOAD_DIR', 'uploads/');
?>