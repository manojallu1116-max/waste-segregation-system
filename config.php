<?php
// Start the session to use session variables
session_start();

// Database configuration
$servername = "localhost";      // Database server
$username = "root";             // XAMPP default username
$password = "";                 // XAMPP default password (usually empty)
$dbname = "waste_system";      // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define reusable paths
define('BASE_URL', 'http://localhost/waste_system/');
define('UPLOAD_DIR', 'uploads/');
?>
