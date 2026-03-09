<?php
include 'config.php';

// require login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// validate complaint_id param
$complaint_id = isset($_GET['complaint_id']) ? intval($_GET['complaint_id']) : 0;

// check that complaint belongs to user and is solved
$stmt = $conn->prepare("SELECT status FROM complaints WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $complaint_id, $user_id);
$stmt->execute();
$stmt->bind_result($status);
if(!$stmt->fetch() || $status !== 'solved') {
    // invalid access
    header("Location: view_complaints.php");
    exit();
}
$stmt->close();

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = intval($_POST['rating']);
    $comment = $conn->real_escape_string($_POST['comment']);

    // insert feedback
    $stmt2 = $conn->prepare("INSERT INTO feedback (user_id, complaint_id, rating) VALUES (?, ?, ?)");
    $stmt2->bind_param("iii", $user_id, $complaint_id, $rating);
    if ($stmt2->execute()) {
        $message = "Thank you for your feedback!";
    } else {
        $message = "Error submitting feedback.";
    }
    $stmt2->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Submit Feedback</title>
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
<main class="container my-5" style="max-width:600px;">
  <h2 class="text-center mb-4">Leave Feedback</h2>
  <?php if($message): ?>
    <div class="alert alert-info"><?php echo $message; ?></div>
  <?php endif; ?>
  <form method="post" action="">
    <div class="form-group">
      <label>Rating (1‑5)</label>
      <select name="rating" class="form-control form-control-custom" required>
        <option value="">Select</option>
        <?php for($i=1;$i<=5;$i++): ?>
          <option value="<?php echo $i;?>"><?php echo $i;?></option>
        <?php endfor; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Comments (optional)</label>
      <textarea name="comment" class="form-control form-control-custom" rows="4"></textarea>
    </div>
    <button type="submit" class="btn btn-custom btn-block">Submit Feedback</button>
  </form>
  <div class="text-center mt-4">
    <a href="view_complaints.php" class="btn btn-alt">&#8592; Back</a>
  </div>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>