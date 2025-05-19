<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

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
    <title>Admin - Community Initiatives</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .action-btn {
            margin-right: 5px;
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
        }
        .edit-btn { background-color: #007bff; }
        .delete-btn { background-color: #dc3545; }
        .add-btn {
            background-color: #28a745;
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 4px;
            margin-bottom: 15px;
            display: inline-block;
        }
    </style>
</head>
<body>

<?php include('d.php'); ?>

<div class="content-body" style="margin-left: 250px;">
    <div class="container-fluid">
        <h2 class="text-center mb-4">📌 Community Initiatives </h2>
        <a href="addnew.php" class="add-btn">➕ Add New Initiative</a>
        <table border="1" width="60%" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Event Date</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1; while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $counter++; ?></td>
                        <td><?= htmlspecialchars($row['title']); ?></td>
                        <td><?= htmlspecialchars($row['description']); ?></td>
                        <td><?= htmlspecialchars($row['event_date']); ?></td>
                        <td><?= htmlspecialchars($row['location']); ?></td>
                        <td>
                            <a href="up.php?id=<?= $row['id']; ?>" class="action-btn edit-btn">✏️ Edit</a>
                            <a href="deleteadd.php?id=<?= $row['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?');">🗑️ Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
