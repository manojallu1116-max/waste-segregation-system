<?php
include 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all complaints
$sql = "SELECT complaints.*, users.username FROM complaints JOIN users ON complaints.user_id = users.id ORDER BY complaints.timestamp DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Complaints</title>
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
<main class="container my-5">
  <h2 class="text-center mb-4">Manage Complaints</h2>
  <div class="table-responsive">
    <table class="table table-dark table-striped table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>User</th>
          <th>Waste Type</th>
          <th>Description</th>
          <th>Images</th>
          <th>Status</th>
          <th>Time</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo htmlspecialchars($row['username']); ?></td>
          <td><?php echo htmlspecialchars($row['waste_type']); ?></td>
          <td><?php echo htmlspecialchars($row['description']); ?></td>
          <td>
            <?php for ($i = 1; $i <= 3; $i++): ?>
              <?php if (!empty($row["image$i"])): ?>
                <img src="<?php echo htmlspecialchars($row["image$i"]); ?>" alt="Image" class="img-thumbnail mb-1" style="max-width:80px;"><br>
              <?php endif; ?>
            <?php endfor; ?>
          </td>
          <td><?php echo ucfirst($row['status']); ?></td>
          <td><?php echo $row['timestamp']; ?></td>
          <td>
            <form method="post" action="update_status.php" class="form-inline">
              <input type="hidden" name="complaint_id" value="<?php echo $row['id']; ?>">
              <select name="status" class="form-control form-control-sm mr-2">
                  <option value="pending" <?php if($row['status']=='pending') echo 'selected'; ?>>Pending</option>
                  <option value="in-progress" <?php if($row['status']=='in-progress') echo 'selected'; ?>>In-progress</option>
                  <option value="solved" <?php if($row['status']=='solved') echo 'selected'; ?>>Solved</option>
              </select>
              <button type="submit" class="btn btn-sm btn-custom">Update</button>
            </form>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <a href="admin_dashboard.php" class="btn btn-outline-light">&#8592; Back to Dashboard</a>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
