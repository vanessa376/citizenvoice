<?php
session_start();
$host = 'localhost';
$db = 'cces';
$user = 'root';
$pass = '';

// Guhuza na Database
$conn = new mysqli($host, $user, $pass, $db);

// Reba niba connection yakunze
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Kureba niba user yinjiriye muri login
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];


$stmt = $conn->prepare("
    SELECT c.id, c.title, c.description, c.status, c.created_at, r.response_text, r.created_at AS response_date 
    FROM complaints c
    LEFT JOIN responses r ON c.id = r.complaint_id
    WHERE c.user_id = ? AND c.status = 'Resolved'
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
    <title>Resolution History - CitiVoice</title>
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.theme.default.min.css">
    <link href="./vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
</head>
<body>
 
    <?php include('copy.php'); ?>

    <div class="container mt-5">
        <h2>Resolution History</h2>

        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Complaint Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Response</th>
                        <th>Complaint Date</th>
                        <th>Response Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $counter = 1;
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $counter++; ?></td>
                            <td><?= $row['title']; ?></td>
                            <td><?= $row['description']; ?></td>
                            <td><span class="badge bg-danger"><?= ucfirst($row['status']); ?></span></td>
                            <td><?= $row['response_text'] ? $row['response_text'] : 'No Response Yet'; ?></td>
                            <td><?= date('d M Y, H:i', strtotime($row['created_at'])); ?></td>
                            <td><?= $row['response_text'] ? date('d M Y, H:i', strtotime($row['response_date'])) : '—'; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning">You have no resolved complaints yet.</div>
        <?php endif; ?>
    </div>

    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <script src="./js/custom.min.js"></script>
</body>
</html>
