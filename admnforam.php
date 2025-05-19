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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Forum</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
<?php include('d.php'); ?>
<center>
    <h2 >🗣️ Public Forum - Citizen Discussions</h2>
    
    <div class="forum-container">
        <?php
        $query = "SELECT * FROM public_forum WHERE status = 'approved' ORDER BY created_at DESC";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='forum-post'>";
                echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['content']) . "</p>";
                echo "<small>Posted by: " . htmlspecialchars($row['author_name']) . " on " . $row['created_at'] . "</small>";
                echo "</div>";
            }
        } else {
            echo "<p>No posts available at the moment.</p>";
        }
        ?>
    </div>

    <!-- Admin Forum Management Page -->
    <!-- admin_forum_management.php -->
    <h2>🗂️ Admin Forum Management</h2>
    <?php
    $admin_query = "SELECT * FROM public_forum ORDER BY created_at DESC";
    $admin_result = $conn->query($admin_query);
    if ($admin_result->num_rows > 0) {
        while ($row = $admin_result->fetch_assoc()) {
            echo "<div class='forum-post'>";
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['content']) . "</p>";
            echo "<small>Posted by: " . htmlspecialchars($row['author_name']) . " on " . $row['created_at'] . "</small>";
            echo "<a  href='approve_post.php?id=" . $row['id'] . "'>Approve</a> | ";
            echo "<a href='reject_post.php?id=" . $row['id'] . "'>Reject</a>";
            echo "</div>";
        }
    } else {
        echo "<p>No posts available for review.</p>";
    }
    ?>

</body>
</html>
