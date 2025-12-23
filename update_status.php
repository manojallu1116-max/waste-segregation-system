<?php
include 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complaint_id = intval($_POST['complaint_id']);
    $status = $_POST['status'];

    // Update the status in the database
    $stmt = $conn->prepare("UPDATE complaints SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $complaint_id);
    if ($stmt->execute()) {
        header("Location: admin_complaints.php");
    } else {
        echo "Error updating status: " . $conn->error;
    }
    $stmt->close();
}
?>
