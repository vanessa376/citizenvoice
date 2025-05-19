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

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Complaint ID not found!'); window.location.href = 'all.php';</script>";
    exit;
}

$complaint_id = $_GET['id'];


$stmt = $conn->prepare("SELECT title, description FROM complaints WHERE id = ?");
$stmt->bind_param("i", $complaint_id);
$stmt->execute();
$result = $stmt->get_result();
$complaint = $result->fetch_assoc();

if (!$complaint) {
    echo "<script>alert('Complaint not found!'); window.location.href = 'all.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response_text = $_POST['response_text'];
    $admin_id = 1; 

    $insertStmt = $conn->prepare("INSERT INTO responses (complaint_id, admin_id, response_text, created_at) VALUES (?, ?, ?, NOW())");
    $insertStmt->bind_param("iis", $complaint_id, $admin_id, $response_text);

    if ($insertStmt->execute()) {
        echo "<script>alert('Response sent successfully!'); window.location.href = 'all.php';</script>";
    } else {
        echo "<script>alert('Failed to send response.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Respond to Complaint</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
        }
        .main-content {
            margin-left: 400px;
            padding: 20px;
            
        }
        textarea {
            width: 200%;
            height: 200px;
            
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

   
    <?php include('d.php'); ?>

    <center>
    <div class="main-content">
        <h2>Respond to: <?= htmlspecialchars($complaint['title']); ?></h2>
        <p><strong>Description:</strong> <?= htmlspecialchars($complaint['description']); ?></p>

        <form method="post">
            <textarea name="response_text" placeholder="Write your response here..."></textarea><br>
            <button type="submit">Send Response</button>
        </form>
    </div>
</body>
</html>
