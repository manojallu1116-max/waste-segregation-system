<?php
include 'config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password
    $role = 'user'; // Default role

    // Check if username or email already exists
    $check = $conn->query("SELECT * FROM users WHERE username='$username' OR email='$email'");
    if ($check->num_rows > 0) {
        $message = "Username or Email already exists!";
    } else {
        // Insert into database
        $conn->query("INSERT INTO users (username, password, email, role) VALUES ('$username', '$password', '$email', '$role')");
        $message = "Registration successful! You can now <a href='login.php'>login</a>.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="index.php">WasteSeg</a>
  <div class="ml-auto">
    <a href="login.php" class="btn btn-outline-light btn-sm">Login</a>
  </div>
</nav>
<main class="container d-flex justify-content-center align-items-center" style="min-height:calc(100vh - 56px);">
  <div class="card card-custom p-4" style="max-width:420px; width:100%;">
    <h3 class="text-center mb-4">Register</h3>
    <?php if($message): ?>
      <div class="alert alert-danger"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="post" action="">
      <div class="form-group">
        <input type="text" name="username" class="form-control form-control-custom" placeholder="Username" required>
      </div>
      <div class="form-group">
        <input type="email" name="email" class="form-control form-control-custom" placeholder="Email" required>
      </div>
      <div class="form-group">
        <input type="password" name="password" class="form-control form-control-custom" placeholder="Password" required>
      </div>
      <button type="submit" class="btn btn-custom btn-block">Register</button>
    </form>
    <p class="mt-3 text-center">Already have an account? <a href="login.php">Login here</a></p>
  </div>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
