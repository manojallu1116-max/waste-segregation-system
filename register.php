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
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; margin:0; padding:0; }

/* Animated gradient background */
body {
    font-family: 'Roboto', sans-serif;
    background: linear-gradient(135deg, #6a11cb, #2575fc, #00c6ff, #6a11cb);
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #fff;
}
@keyframes gradientBG {
    0% { background-position:0% 50%; }
    50% { background-position:100% 50%; }
    100% { background-position:0% 50%; }
}

.form-container {
    background: rgba(255,255,255,0.1);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

h2 {
    margin-bottom: 20px;
    font-size: 2rem;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
}

input[type=text], input[type=email], input[type=password] {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 10px;
    border: none;
    outline: none;
}

input[type=submit] {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: none;
    background: #4caf50;
    color: #fff;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}
input[type=submit]:hover {
    background: #388e3c;
    transform: translateY(-2px);
}

.message {
    margin-top: 15px;
    color: #ff5252;
    font-weight: 500;
}

a {
    color: #03a9f4;
    text-decoration: none;
    font-weight: 500;
}
a:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="form-container">
    <h2>Register</h2>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" value="Register">
    </form>
    <?php if($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>
</body>
</html>
