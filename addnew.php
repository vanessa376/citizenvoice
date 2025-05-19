<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$host = 'localhost';
$db = 'cces';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

$title = $description = $event_date = $location = "";
$success_message = $error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];

    if (empty($title) || empty($description) || empty($event_date) || empty($location)) {
        $error_message = "All fields are required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO community_initiatives (title, description, event_date, location) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $description, $event_date, $location);

        if ($stmt->execute()) {
            $success_message = "New initiative added successfully!";
            $title = $description = $event_date = $location = "";
        } else {
            $error_message = "Failed to add initiative.";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Initiative</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        form {
            width: 50%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .success {
            color: green;
            text-align: center;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
<?php include('d.php'); ?>
<h2 style="text-align: center;">➕ Add New Community Initiative</h2>

<?php if ($success_message): ?>
    <p class="success"><?= $success_message; ?></p>
<?php endif; ?>

<?php if ($error_message): ?>
    <p class="error"><?= $error_message; ?></p>
<?php endif; ?>

<form method="POST" action="">
    <input type="text" name="title" placeholder="Title" value="<?= htmlspecialchars($title); ?>" required>
    <textarea name="description" placeholder="Description" required><?= htmlspecialchars($description); ?></textarea>
    <input type="date" name="event_date" value="<?= htmlspecialchars($event_date); ?>" required>
    <input type="text" name="location" placeholder="Location" value="<?= htmlspecialchars($location); ?>" required>
    <button type="submit">Add Initiative</button>
</form>

</body>
</html>
