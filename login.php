<?php
include 'config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Check if username exists
    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct – start session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit();
        } else {
            $message = "Invalid username or password!";
        }
    } else {
        $message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
  <a class="navbar-brand" href="index.php">WasteSeg</a>
  <div class="ml-auto">
    <a href="register.php" class="btn btn-outline-light btn-sm">Register</a>
  </div>
</nav>
<main class="container d-flex justify-content-center align-items-center" style="min-height:calc(100vh - 56px);">
  <div class="card card-custom p-4" style="max-width:420px; width:100%;">
    <h3 class="text-center mb-4">Login</h3>
    <?php if($message): ?>
      <div class="alert alert-danger"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="post" action="">
      <div class="form-group">
        <input type="text" name="username" class="form-control form-control-custom" placeholder="Username" required>
      </div>
      <div class="form-group">
        <input type="password" name="password" class="form-control form-control-custom" placeholder="Password" required>
      </div>
      <button type="submit" class="btn btn-custom btn-block">Login</button>
    </form>
    <p class="mt-3 text-center">Don't have an account? <a href="register.php">Register here</a></p>
  </div>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
