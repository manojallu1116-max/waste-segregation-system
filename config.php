<?php
session_start();

$servername = "sql212.infinityfree.com";
$username = "if0_41303820";
$password = "gmKuFlTIs2u8W";
$dbname = "if0_41303820_waste_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

define('BASE_URL', 'https://waste-segregation.gamer.gd/');
define('UPLOAD_DIR', 'uploads/');
?>