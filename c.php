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

$query = "SELECT id, title, description, event_date, location FROM community_initiatives ORDER BY event_date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Initiatives</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .initiative-card {
            background-color: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .initiative-card h3 {
            color: #007bff;
        }
        .no-data {
            text-align: center;
            color: gray;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php include('copy.php'); ?>

<div class="content-body" style="margin-left: 250px;">
    <div class="container-fluid">
        <h2 class="text-center mb-4">📌 Community Initiatives</h2>
        
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="initiative-card">
                    <h3><?= htmlspecialchars($row['title']); ?></h3>
                    <p><strong>Date:</strong> <?= htmlspecialchars($row['event_date']); ?></p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($row['location']); ?></p>
                    <p><?= htmlspecialchars($row['description']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-data">❌ No Community Initiatives</p>
        <?php endif; ?>

    </div>
</div>

</body>
</html>
