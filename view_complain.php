<?php

$host = 'localhost';
$db = 'cces';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (!isset($_GET['id'])) {
    echo "<p style='color: red;'>Invalid Request!</p>";
    exit();
}

$id = $_GET['id'];


$sql = "SELECT * FROM complaints WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$complaint = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$complaint) {
    echo "<p style='color: red;'>Complaint not found!</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Complaint</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .complaint-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
            width: 500px;
        }
        h2 {
            text-align: center;
            color: #333333;
        }
        p {
            margin: 10px 0;
        }
        .back-link {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="complaint-container">
        <h2>Complaint Details</h2>
        <p><strong>ID:</strong> <?= $complaint['id'] ?></p>
        <p><strong>Citizen Name:</strong> <?= $complaint['citizen_name'] ?></p>
        <p><strong>Complaint:</strong> <?= $complaint['complaint'] ?></p>
        <p><strong>Category:</strong> <?= $complaint['category'] ?></p>
        <p><strong>Status:</strong> <?= $complaint['status'] ?></p>
        <a href='admin_dashboard.php' class='back-link'>← Back to Dashboard</a>
    </div>
</body>
</html>
