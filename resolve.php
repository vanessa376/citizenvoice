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

$complaint_id = $_GET['id'];


$stmt = $conn->prepare("UPDATE complaints SET status = 'resolved' WHERE id = ?");
$stmt->bind_param("i", $complaint_id);

if ($stmt->execute()) {
    echo "<script>alert('Complaint resolved successfully!'); window.location.href = 'all.php';</script>";
} else {
    echo "<script>alert('Failed to resolve complaint.');</script>";
}
?>
