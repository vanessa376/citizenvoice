<?php
session_start();
$host = 'localhost';
$db = 'cces';
$user = 'root';
$pass = '';


$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}


$result = $conn->query("SELECT * FROM community_initiatives ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Initiatives - CitiVoice</title>
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.theme.default.min.css">
    <link href="./vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
</head>
<body>
    <?php include('copy.php'); ?>

    <div class="container mt-5">
        <h2>Community Initiatives</h2>
        <?php if ($result->num_rows > 0): ?>
            <div class="list-group">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="mb-1"><?= $row['title']; ?></h5>
                        <p class="mb-1"><?= $row['description']; ?></p>
                        <small>Posted on <?= date('d M Y', strtotime($row['created_at'])); ?></small>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">No community initiatives found.</div>
        <?php endif; ?>
    </div>
</body>
</html>
