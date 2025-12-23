<?php
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch complaint statistics
$total_sql = "SELECT COUNT(*) as total FROM complaints";
$pending_sql = "SELECT COUNT(*) as pending FROM complaints WHERE status='pending'";
$inprogress_sql = "SELECT COUNT(*) as inprogress FROM complaints WHERE status='in-progress'";
$solved_sql = "SELECT COUNT(*) as solved FROM complaints WHERE status='solved'";

$total = $conn->query($total_sql)->fetch_assoc()['total'];
$pending = $conn->query($pending_sql)->fetch_assoc()['pending'];
$inprogress = $conn->query($inprogress_sql)->fetch_assoc()['inprogress'];
$solved = $conn->query($solved_sql)->fetch_assoc()['solved'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }

/* Gradient animated background */
body {
    font-family: 'Roboto', sans-serif;
    background: linear-gradient(135deg, #6a11cb, #2575fc, #00c6ff, #6a11cb);
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    color: #fff;
}
@keyframes gradientBG {
    0% { background-position:0% 50%; }
    50% { background-position:100% 50%; }
    100% { background-position:0% 50%; }
}

.container { max-width: 1000px; margin: 50px auto; padding: 20px; text-align:center; }
.header h2 { font-size: 2.5rem; margin-bottom: 10px; text-shadow: 2px 2px 8px rgba(0,0,0,0.3); }
.header p { color: rgba(255,255,255,0.85); margin-bottom: 40px; font-size: 1.1rem; }

.card-grid { display: flex; flex-wrap: wrap; gap: 25px; justify-content: center; }

.card {
    background: rgba(255,255,255,0.15);
    padding: 35px 25px;
    border-radius: 15px;
    flex: 1 1 200px;
    max-width: 220px;
    text-align: center;
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    transition: transform 0.3s, box-shadow 0.3s;
}
.card:hover { transform: translateY(-8px); box-shadow: 0 12px 30px rgba(0,0,0,0.5); }

.card h3 { font-size: 1.3rem; margin-bottom: 15px; }
.card p { font-size: 1.5rem; font-weight: 700; color: #fff; }

.card a {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    background: rgba(255,255,255,0.9);
    color: #333;
    border-radius: 10px;
    font-weight: 500;
    text-decoration: none;
    transition: background 0.3s, transform 0.3s;
}
.card a:hover { background: #fff; transform: translateY(-3px); }

.logout-btn {
    display: inline-block;
    margin: 40px auto 0;
    padding: 12px 35px;
    background: #f44336;
    color: #fff;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: background 0.3s, transform 0.3s;
}
.logout-btn:hover { background: #d32f2f; transform: translateY(-3px); }

@media (max-width:768px) { .card-grid { flex-direction: column; align-items: center; } }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Welcome, Admin <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>Manage complaints and monitor system statistics</p>
    </div>

    <div class="card-grid">
        <div class="card">
            <h3>Total Complaints</h3>
            <p><?php echo $total; ?></p>
        </div>
        <div class="card">
            <h3>Pending</h3>
            <p><?php echo $pending; ?></p>
        </div>
        <div class="card">
            <h3>In-progress</h3>
            <p><?php echo $inprogress; ?></p>
        </div>
        <div class="card">
            <h3>Solved</h3>
            <p><?php echo $solved; ?></p>
        </div>
        <div class="card">
            <h3>Manage Complaints</h3>
            <a href="admin_complaints.php">Go</a>
        </div>
    </div>

    <a class="logout-btn" href="logout.php">Logout</a>
</div>
</body>
</html>
