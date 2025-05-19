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

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    $approve_query = "UPDATE public_forum SET status = 'approved' WHERE id = '$post_id'";

    if ($conn->query($approve_query) === TRUE) {
        echo "<script>
                alert('Post has been approved successfully.');
                window.location.href='admnforam.php';
              </script>";
    } else {
        echo "<script>
                alert('Error approving post: " . $conn->error . "');
                window.location.href='admnforam.php';
              </script>";
    }
} else {
    echo "<script>
            alert('No post ID specified.');
            window.location.href='admnforam.php';
          </script>";
}
?>
