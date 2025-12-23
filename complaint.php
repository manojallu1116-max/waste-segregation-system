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
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }

/* Gradient animated background */
body {
    font-family: 'Roboto', sans-serif;
    background: linear-gradient(135deg, #6a11cb, #2575fc, #00c6ff, #6a11cb);
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    color: #fff;
}
@keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.form-container {
    max-width: 600px;
    margin: 50px auto;
    background: rgba(255,255,255,0.1);
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}

h2 { text-align: center; margin-bottom: 20px; font-size: 2rem; text-shadow: 2px 2px 8px rgba(0,0,0,0.3); }

input[type=text], textarea {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 10px;
    border: none;
}

input[type=file] {
    margin: 10px 0;
}

input[type=submit] {
    width: 100%;
    padding: 12px;
    background: #ff9800;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    color: #fff;
    cursor: pointer;
    transition: background 0.3s, transform 0.3s;
}
input[type=submit]:hover { background: #f57c00; transform: translateY(-3px); }

label { display: block; margin-top: 15px; font-weight: 500; }
.message { text-align:center; margin-bottom:15px; font-weight:600; color:#00ff99; }

.back-logout {
    text-align: center;
    margin-top: 25px;
}
.back-logout a {
    display: inline-block;
    margin: 0 15px;
    padding: 10px 25px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}
.back-btn { background:#03a9f4; color:#fff; }
.back-btn:hover { background:#0288d1; }
.logout-btn { background:#f44336; color:#fff; }
.logout-btn:hover { background:#d32f2f; }

@media (max-width:768px) { .form-container { padding: 20px; } }
</style>
</head>
<body>
<div class="form-container">
    <h2>Submit Complaint</h2>
    <?php if($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="post" action="" enctype="multipart/form-data">
        <label>Title:</label>
        <input type="text" name="title" placeholder="Title" required>

        <label>Address:</label>
        <input type="text" name="address" placeholder="Address of the place" required>

        <label>Description:</label>
        <textarea name="description" placeholder="Description" rows="5" required></textarea>

        <label>Type of Waste:</label>
        <input type="text" name="waste_type" placeholder="Enter type of waste (e.g., Plastic Bags)" required>

        <label>Upload Photo 1:</label>
        <input type="file" name="file0" accept="image/*">

        <label>Upload Photo 2:</label>
        <input type="file" name="file1" accept="image/*">

        <label>Upload Photo 3:</label>
        <input type="file" name="file2" accept="image/*">

        <input type="submit" value="Submit Complaint">
    </form>

    <div class="back-logout">
        <a href="user_dashboard.php" class="back-btn">&#8592; Back to Dashboard</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>
</body>
</html>
