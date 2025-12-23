

<?php
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Sample data (you can replace these with your database fetch later)
$wasteTypes = [
    'Organic' => [
        ['name' => 'Food Scraps', 'description' => 'Vegetable peels, fruit waste, and leftovers.'],
        ['name' => 'Garden Waste', 'description' => 'Leaves, grass clippings, branches, etc.']
    ],
    'Recyclable' => [
        ['name' => 'Plastic', 'description' => 'Bottles, containers, and packaging materials.'],
        ['name' => 'Paper', 'description' => 'Newspapers, cardboard, magazines, and paper sheets.'],
        ['name' => 'Glass', 'description' => 'Bottles, jars, and other glass items.']
    ],
    'Hazardous' => [
        ['name' => 'Batteries', 'description' => 'Used batteries that need special disposal.'],
        ['name' => 'Chemicals', 'description' => 'Cleaning agents, paints, solvents, etc.']
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Waste Types</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Roboto', sans-serif;
    margin:0;
    padding:0;
    background: linear-gradient(135deg, #6a11cb, #2575fc, #00c6ff, #6a11cb);
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    color:#fff;
}
@keyframes gradientBG {
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
}
.container { max-width:1200px; margin:50px auto; padding:20px; text-align:center; }

h1 { font-size:3rem; margin-bottom:20px; text-shadow: 2px 2px 8px rgba(0,0,0,0.3); }
p.description { font-size:1.1rem; margin-bottom:40px; color: rgba(255,255,255,0.9); line-height:1.6; }

.section { margin-bottom:50px; text-align:left; }
.section h2 { margin-bottom:20px; color:#ffeb3b; border-bottom:2px solid #fff; display:inline-block; padding-bottom:5px; }
.card-container { display:flex; flex-wrap:wrap; gap:20px; justify-content:flex-start; }

.card {
    background: rgba(255,255,255,0.15);
    padding:20px;
    border-radius:20px;
    width:250px;
    box-shadow:0 8px 25px rgba(0,0,0,0.3);
    transition: transform 0.3s, box-shadow 0.3s;
    text-align:center;
}
.card:hover { transform: translateY(-8px); box-shadow:0 12px 30px rgba(0,0,0,0.5); }
.card img { width:100%; height:150px; object-fit:cover; border-radius:12px; margin-bottom:10px; }
.card h3 { color:#fff; margin-bottom:5px; }
.card p { color:#e0e0e0; font-size:0.95rem; }

.buttons { text-align:center; margin-top:40px; }
.buttons a {
    display:inline-block;
    margin:0 10px;
    padding:12px 25px;
    border-radius:12px;
    font-weight:600;
    text-decoration:none;
    transition: all 0.3s;
}
.back-btn { background:#ff9800; color:#fff; }
.back-btn:hover { background:#f57c00; }
.logout-btn { background:#f44336; color:#fff; }
.logout-btn:hover { background:#d32f2f; }

@media (max-width:768px) { .card-container { flex-direction:column; align-items:center; } .section{text-align:center;} }
</style>
</head>
<body>

<div class="container">
<h1>Waste Types</h1>
<p class="description">
    Proper waste management is essential for a clean and sustainable environment. 
    Below, waste is divided into Organic, Recyclable, and Hazardous categories for easy understanding. 
    Click each section to learn how to manage these types effectively.
</p>

<?php foreach($wasteTypes as $category => $items) { ?>
<div class="section">
    <h2><?php echo $category; ?> Waste</h2>
    <div class="card-container">
        <?php foreach($items as $w) { 
            $imagePath = "images/" . strtolower(str_replace(' ','_',$w['name'])) . ".jpg";
            if(!file_exists($imagePath)) { $imagePath = "images/default.jpg"; }
        ?>
        <div class="card">
            <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($w['name']); ?>">
            <h3><?php echo htmlspecialchars($w['name']); ?></h3>
            <p><?php echo htmlspecialchars($w['description']); ?></p>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>

<div class="buttons">
    <a href="user_dashboard.php" class="back-btn">&#8592; Back to Dashboard</a>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>
</div>

</body>
</html>
