<?php
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Dashboard</title>
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
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.container { max-width: 1000px; margin: 50px auto; padding: 20px; }
.header { text-align: center; margin-bottom: 50px; }
.header h2 { font-size: 2.5rem; color: #fff; text-shadow: 2px 2px 8px rgba(0,0,0,0.3); }
.header p { color: rgba(255,255,255,0.85); margin-top: 8px; font-size: 1rem; }

.card-grid { display: flex; flex-wrap: wrap; gap: 25px; justify-content: center; }

.card {
    background: rgba(255,255,255,0.15);
    color: #fff;
    padding: 35px 25px;
    border-radius: 15px;
    flex: 1 1 250px;
    max-width: 280px;
    text-align: center;
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    transition: transform 0.3s, box-shadow 0.3s;
    position: relative;
    overflow: hidden;
}
.card:hover { transform: translateY(-8px); box-shadow: 0 12px 30px rgba(0,0,0,0.5); }

.card i { font-size: 50px; margin-bottom: 15px; display: block; transition: transform 0.3s; }
.card:hover i { transform: scale(1.2); }

.card h3 { font-size: 1.5rem; margin-bottom: 10px; }
.card p { font-size: 0.95rem; color: rgba(255,255,255,0.85); }

.card a {
    text-decoration: none;
    display: inline-block;
    margin-top: 15px;
    padding: 12px 25px;
    background: rgba(255,255,255,0.9);
    color: #333;
    border-radius: 10px;
    font-weight: 500;
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
    text-align: center;
}
.logout-btn:hover { background: #d32f2f; transform: translateY(-3px); }

@media (max-width: 768px) { .card-grid { flex-direction: column; align-items: center; } }
</style>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>Your interactive dashboard</p>
    </div>

    <div class="card-grid">
        <div class="card">
            <i class="fas fa-exclamation-circle"></i>
            <h3>Submit a Complaint</h3>
            <p>Report any issue easily and quickly.</p>
            <a href="complaint.php">Submit Now</a>
        </div>

        <div class="card">
            <i class="fas fa-eye"></i>
            <h3>View My Complaints</h3>
            <p>Track your complaints and check their status.</p>
            <a href="view_complaints.php">View Complaints</a>
        </div>

        <div class="card">
            <i class="fas fa-recycle"></i>
            <h3>Waste Types</h3>
            <p>Learn about different types of waste and proper disposal methods.</p>
            <a href="waste_types.php">Explore Waste Types</a>
        </div>
    </div>

    <a class="logout-btn" href="logout.php">Logout</a>
</div>
</body>
</html>
