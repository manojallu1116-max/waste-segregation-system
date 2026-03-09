

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
  <h1 class="text-center mb-4">Waste Types</h1>
  <p class="description text-center">
    Proper waste management is essential for a clean and sustainable environment. 
    Below, waste is divided into Organic, Recyclable, and Hazardous categories for easy understanding. 
    Click each section to learn how to manage these types effectively.
  </p>

  <?php foreach($wasteTypes as $category => $items) { ?>
  <div class="section mb-5">
      <h2 class="mb-3"><?php echo $category; ?> Waste</h2>
      <div class="row">
          <?php foreach($items as $w) {
              $imageFilename = strtolower(str_replace(' ','_',$w['name'])) . ".jpg";
              $filesystemPath = __DIR__ . '/images/' . $imageFilename;
              if (file_exists($filesystemPath)) {
                  $displayPath = 'images/' . $imageFilename;
              } else {
                  $displayPath = 'https://via.placeholder.com/250x150?text=No+Image';
              }
          ?>
          <div class="col-md-4 mb-4">
              <div class="card card-custom h-100 text-center">
                <img src="<?php echo $displayPath; ?>" class="card-img-top card-img-custom" alt="<?php echo htmlspecialchars($w['name']); ?>">
                <div class="card-body">
                  <h5 class="card-title"><?php echo htmlspecialchars($w['name']); ?></h5>
                  <p class="card-text"><?php echo htmlspecialchars($w['description']); ?></p>
                </div>
              </div>
          </div>
          <?php } ?>
      </div>
  </div>
  <?php } ?>

  <div class="text-center mt-4">
      <a href="user_dashboard.php" class="btn btn-custom mr-2">&#8592; Back to Dashboard</a>
      <a href="logout.php" class="btn btn-outline-light">Logout</a>
  </div>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
