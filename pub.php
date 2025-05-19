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

$query = "SELECT id, title, content, author_name, created_at FROM public_forum ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Forum</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .forum-card {
            background-color: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .forum-card h3 {
            color: #007bff;
        }
        .forum-card p {
            margin: 5px 0;
        }
        .add-btn {
            background-color: #007bff;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: inline-block;
        }
        .add-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php include('copy.php'); ?>

<div class="content-body" style="margin-left: 250px;">
    <div class="container-fluid">
        <h2 class="text-center mb-4">🌐 Public Forum</h2>

        <a href="addnewforam.php" class="add-btn">➕ Add New Post</a>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="forum-card">
                    <h3><?= htmlspecialchars($row['title']); ?></h3>
                    <p><strong>Posted By:</strong> <?= htmlspecialchars($row['author_name']); ?></p>
                    <p><strong>Date:</strong> <?= date('d M Y, H:i', strtotime($row['created_at'])); ?></p>
                    <p><?= htmlspecialchars($row['content']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No forum posts available at the moment.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
