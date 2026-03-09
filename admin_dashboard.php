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
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
  <a class="navbar-brand" href="admin_dashboard.php">WasteSeg</a>
  <div class="ml-auto">
    <span class="navbar-text mr-2">Hello, Admin <?php echo htmlspecialchars($_SESSION['username']); ?></span>
    <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
  </div>
</nav>
<main class="container">
  <div class="text-center my-4">
    <h2>Welcome, Admin <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>Manage complaints and monitor system statistics</p>
  </div>
  <div class="row">
    <div class="col-md-2 col-sm-4 mb-4">
      <div class="card card-custom text-center">
        <div class="card-body">
          <h5 class="card-title">Total Complaints</h5>
          <p class="card-text display-4"><?php echo $total; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 mb-4">
      <div class="card card-custom text-center">
        <div class="card-body">
          <h5 class="card-title">Pending</h5>
          <p class="card-text display-4"><?php echo $pending; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 mb-4">
      <div class="card card-custom text-center">
        <div class="card-body">
          <h5 class="card-title">In-progress</h5>
          <p class="card-text display-4"><?php echo $inprogress; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 mb-4">
      <div class="card card-custom text-center">
        <div class="card-body">
          <h5 class="card-title">Solved</h5>
          <p class="card-text display-4"><?php echo $solved; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-2 col-sm-4 mb-4">
      <div class="card card-custom text-center">
        <div class="card-body">
          <h5 class="card-title">Manage Complaints</h5>
          <a href="admin_complaints.php" class="btn btn-custom">Go</a>
        </div>
      </div>
    </div>
  </div>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
