<?php
include 'config.php';

// require login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// fetch upcoming schedules (pending or future)
$today = date('Y-m-d');
$stmt = $conn->prepare("SELECT id, task_name, date, time, status FROM schedules WHERE date >= ? ORDER BY date,time");
$stmt->bind_param('s', $today);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Schedules</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
  <a class="navbar-brand" href="user_dashboard.php">WasteSeg</a>
  <div class="ml-auto">
    <span class="navbar-text mr-2">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
    <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
  </div>
</nav>

<main class="container my-5">
  <h2 class="text-center mb-4">Upcoming Schedules</h2>
  <?php if($result->num_rows): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="thead-light">
          <tr>
            <th>Task</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['task_name']); ?></td>
            <td><?php echo htmlspecialchars($row['date']); ?></td>
            <td><?php echo htmlspecialchars($row['time']); ?></td>
            <td><?php echo ucfirst($row['status']); ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-center">No upcoming schedules.</p>
  <?php endif; ?>

  <div class="text-center mt-4">
    <a href="user_dashboard.php" class="btn btn-alt">&#8592; Back to Dashboard</a>
  </div>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>