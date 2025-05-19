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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    
    if (isset($_SESSION['user_name'])) {
        $author_name = $_SESSION['user_name']; 
    } else {
        $author_name = "Anonymous";
    }

    
    if (!empty($title) && !empty($content)) {
        $query = "INSERT INTO public_forum (title, content, author_name, status) 
                  VALUES ('$title', '$content', '$author_name', 'pending')";

        if ($conn->query($query) === TRUE) {
            $success_message = "Your post has been successfully submitted and is pending approval.";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    } else {
        $error_message = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Post - Public Forum</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            height: 100vh;
            color: white;
            position: fixed;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 15px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: 100%;
        }
        form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<?php include('copy.php'); ?>
<div class="main-content">
    <h2>📝 Add New Post</h2>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?= $success_message ?></div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="title" class="form-label">Post Title:</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Post Content:</label>
            <textarea name="content" id="content" class="form-control" rows="5" placeholder="Write your content here..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Post</button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
