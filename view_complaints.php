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
<main class="container my-5">
  <h2 class="text-center mb-4">My Complaints</h2>
  <div class="table-responsive">
    <table class="table table-dark table-striped table-bordered table-hover">
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
          <td><?php echo $row['id']; ?></td>
          <td><?php echo htmlspecialchars($row['waste_type']); ?></td>
          <td><?php echo htmlspecialchars($row['description']); ?></td>
          <td>
            <?php for ($i = 1; $i <= 3; $i++): ?>
              <?php if (!empty($row["image$i"])): ?>
                <img src="<?php echo htmlspecialchars($row["image$i"]); ?>" alt="Image" class="img-thumbnail mb-1" style="max-width:100px;"><br>
              <?php endif; ?>
            <?php endfor; ?>
          </td>
          <td><?php echo ucfirst($row['status']); ?></td>
          <td><?php echo $row['timestamp']; ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <a href="user_dashboard.php" class="btn btn-outline-light">&#8592; Back to Dashboard</a>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
