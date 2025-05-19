<?php
session_start();

// Database connection
$host = 'localhost';
$db = 'cces';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Check if the post ID is set in the URL
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Reject the post by updating its status to "rejected"
    $reject_query = "UPDATE public_forum SET status = 'rejected' WHERE id = '$post_id'";

    if ($conn->query($reject_query) === TRUE) {
        echo "<script>
                alert('Post has been rejected successfully.');
                window.location.href='admnforam.php';
              </script>";
    } else {
        echo "<script>
                alert('Error rejecting post: " . $conn->error . "');
                window.location.href='admnform.php';
              </script>";
    }
} else {
    echo "<script>
            alert('No post ID specified.');
            window.location.href='admnforam.php';
          </script>";
}
?>
