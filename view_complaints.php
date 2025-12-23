<?php
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch complaints of the logged-in user
$sql = "SELECT * FROM complaints WHERE user_id = ? ORDER BY timestamp DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>My Complaints</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; margin:0; padding:0; }

/* Animated gradient background */
body {
    font-family: 'Roboto', sans-serif;
    background: linear-gradient(135deg, #6a11cb, #2575fc, #00c6ff, #6a11cb);
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    color: #fff;
    padding: 30px;
}
@keyframes gradientBG {
    0% { background-position:0% 50%; }
    50% { background-position:100% 50%; }
    100% { background-position:0% 50%; }
}

.container {
    max-width: 1200px;
    margin: auto;
    background: rgba(255,255,255,0.1);
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}

h2 { text-align:center; margin-bottom:20px; font-size:2rem; text-shadow:2px 2px 8px rgba(0,0,0,0.3); }

table {
    width: 100%;
    border-collapse: collapse;
    background: rgba(255,255,255,0.15);
    border-radius: 12px;
    overflow: hidden;
}
th, td {
    padding: 12px;
    text-align: left;
    color: #fff;
}
th { background: rgba(0,0,0,0.2); }
tr:nth-child(even) { background: rgba(0,0,0,0.1); }

img { max-width: 100px; border-radius: 8px; margin: 5px 0; }

.back-btn {
    display:inline-block;
    margin-top: 20px;
    padding:10px 25px;
    border-radius:12px;
    text-decoration:none;
    font-weight:600;
    background:#03a9f4;
    color:#fff;
    transition: all 0.3s;
}
.back-btn:hover { background:#0288d1; transform: translateY(-2px); }

@media(max-width:768px){
    table, thead, tbody, th, td, tr { display:block; }
    tr { margin-bottom:15px; }
    th { display:none; }
    td { position: relative; padding-left:50%; margin-bottom:10px; }
    td:before {
        position: absolute;
        top:0; left:10px;
        width:45%;
        white-space: nowrap;
        font-weight:bold;
        content: attr(data-label);
    }
}
</style>
</head>
<body>
<div class="container">
    <h2>My Complaints</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Waste Type</th>
            <th>Description</th>
            <th>Images</th>
            <th>Status</th>
            <th>Time</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td data-label="ID"><?php echo $row['id']; ?></td>
            <td data-label="Waste Type"><?php echo htmlspecialchars($row['waste_type']); ?></td>
            <td data-label="Description"><?php echo htmlspecialchars($row['description']); ?></td>
            <td data-label="Images">
                <?php for ($i = 1; $i <= 3; $i++): ?>
                    <?php if (!empty($row["image$i"])): ?>
                        <img src="uploads/<?php echo $row["image$i"]; ?>" alt="Image"><br>
                    <?php endif; ?>
                <?php endfor; ?>
            </td>
            <td data-label="Status"><?php echo ucfirst($row['status']); ?></td>
            <td data-label="Time"><?php echo $row['timestamp']; ?></td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <a href="user_dashboard.php" class="back-btn">&#8592; Back to Dashboard</a>
</div>
</body>
</html>
