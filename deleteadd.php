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
    echo "<script>alert('No Initiative ID found!'); window.location.href = 'admin_initiatives.php';</script>";
    exit();
}

$id = $_GET['id'];

$deleteQuery = "DELETE FROM community_initiatives WHERE id = ?";
$stmt = $conn->prepare($deleteQuery);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Initiative deleted successfully!'); window.location.href = 'cm.php';</script>";
} else {
    echo "<script>alert('Failed to delete initiative.'); window.location.href = 'cm.php';</script>";
}
?>
