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
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="user_dashboard.php">WasteSeg</a>
  <div class="ml-auto">
    <span class="navbar-text mr-2">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
    <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
  </div>
</nav>

<main class="container">
  <div class="text-center my-4">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>Your interactive dashboard</p>
  </div>
  <div class="row">
    <div class="col-md-4 mb-4">
      <div class="card card-custom h-100 text-center">
        <div class="card-body d-flex flex-column">
          <div class="mb-3"><i class="fas fa-exclamation-circle fa-3x"></i></div>
          <h5 class="card-title">Submit a Complaint</h5>
          <p class="card-text">Report any issue easily and quickly.</p>
          <a href="complaint.php" class="btn btn-custom mt-auto">Submit Now</a>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card card-custom h-100 text-center">
        <div class="card-body d-flex flex-column">
          <div class="mb-3"><i class="fas fa-eye fa-3x"></i></div>
          <h5 class="card-title">View My Complaints</h5>
          <p class="card-text">Track your complaints and check their status.</p>
          <a href="view_complaints.php" class="btn btn-custom mt-auto">View</a>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card card-custom h-100 text-center">
        <div class="card-body d-flex flex-column">
          <div class="mb-3"><i class="fas fa-recycle fa-3x"></i></div>
          <h5 class="card-title">Waste Types</h5>
          <p class="card-text">Learn about different types of waste and proper disposal methods.</p>
          <a href="waste_types.php" class="btn btn-custom mt-auto">Explore</a>
        </div>
      </div>
    </div>
  </div>
</main>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
