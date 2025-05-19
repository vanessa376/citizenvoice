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

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];


$stmt = $conn->prepare("
    SELECT c.id, c.title, c.description, c.status, c.created_at, r.created_at AS response_date 
    FROM complaints c
    LEFT JOIN responses r ON c.id = r.complaint_id
    WHERE c.user_id = ?
    ORDER BY c.created_at DESC
");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback & Responses - CitiVoice</title>
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.theme.default.min.css">
    <link href="./vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <style>
        .container {
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .status-pending {
            color: orange;
        }
        .status-in-progress {
            color: blue;
        }
        .status-resolved {
            color: green;
        }
    </style>
</head>
<body>
    <?php include('copy.php'); ?>

    <div class="container">
        <h2>My Feedback & Responses</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                       
                        <th>Response Date</th>
                        <th>Submitted At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['title']; ?></td>
                            <td><?= $row['description']; ?></td>
                            <td class="status-<?= strtolower($row['status']); ?>"><?= ucfirst($row['status']); ?></td>
                            
                            <td><?= $row['response_date'] ?? 'N/A'; ?></td>
                            <td><?= date('d M Y, H:i', strtotime($row['created_at'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No complaints found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
""
