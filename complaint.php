<?php
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars(trim($_POST['title']));
    $address = htmlspecialchars(trim($_POST['address']));
    $description = htmlspecialchars(trim($_POST['description']));
    $waste_type = htmlspecialchars(trim($_POST['waste_type']));

    $target_dir = UPLOAD_DIR;
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $file_paths = ['', '', ''];

    for ($i = 0; $i < 3; $i++) {
        if (isset($_FILES["file$i"]) && $_FILES["file$i"]["error"] == 0) {
            $filename = basename($_FILES["file$i"]["name"]);
            $filename = time() . "_" . $i . "_" . preg_replace("/[^a-zA-Z0-9\.\-_]/", "", $filename);
            $target_file = $target_dir . $filename;

            if ($_FILES["file$i"]["size"] <= 2 * 1024 * 1024) {
                $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];
                if (in_array($fileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES["file$i"]["tmp_name"], $target_file)) {
                        $file_paths[$i] = $target_file;
                    }
                }
            }
        }
    }

    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("INSERT INTO complaints (user_id, title, address, description, waste_type, image1, image2, image3) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $user_id, $title, $address, $description, $waste_type, $file_paths[0], $file_paths[1], $file_paths[2]);

    if ($stmt->execute()) {
        $message = "Complaint submitted successfully.";
    } else {
        $message = "Error submitting complaint.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Submit Complaint</title>
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

<main class="container">
  <div class="card card-custom mx-auto my-5" style="max-width:600px;">
    <div class="card-body">
      <h3 class="card-title text-center mb-4">Submit Complaint</h3>
      <?php if($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
      <?php endif; ?>
      <form method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
          <label>Title</label>
          <input type="text" name="title" class="form-control form-control-custom" placeholder="Title" required>
        </div>
        <div class="form-group">
          <label>Address</label>
          <input type="text" name="address" class="form-control form-control-custom" placeholder="Address of the place" required>
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="description" class="form-control form-control-custom" placeholder="Description" rows="5" required></textarea>
        </div>
        <div class="form-group">
          <label>Type of Waste</label>
          <select name="waste_type" class="form-control form-control-custom" required>
            <option value="">Select waste type</option>
            <option>Food Scraps</option>
            <option>Garden Waste</option>
            <option>Plastic</option>
            <option>Paper</option>
            <option>Glass</option>
            <option>Batteries</option>
            <option>Chemicals</option>
          </select>
        </div>
        <div class="form-group">
          <label>Upload Photo 1</label>
          <input type="file" name="file0" class="form-control-file">
        </div>
        <div class="form-group">
          <label>Upload Photo 2</label>
          <input type="file" name="file1" class="form-control-file">
        </div>
        <div class="form-group">
          <label>Upload Photo 3</label>
          <input type="file" name="file2" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-custom btn-block">Submit Complaint</button>
      </form>
      <div class="text-center mt-4">
        <a href="user_dashboard.php" class="btn btn-outline-light">&#8592; Back to Dashboard</a>
      </div>
    </div>
  </div>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
