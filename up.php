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

// Kureba niba ID iri muri URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('No Initiative ID found!'); window.location.href = 'admin_initiatives.php';</script>";
    exit();
}

$id = $_GET['id'];

// Kwerekana amakuru ari muri database
$query = "SELECT * FROM community_initiatives WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$initiative = $result->fetch_assoc();

if (!$initiative) {
    echo "<script>alert('Initiative not found!'); window.location.href = 'admin_initiatives.php';</script>";
    exit();
}

// Iyo form ishyikirijwe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];

    $updateQuery = "UPDATE community_initiatives SET title = ?, description = ?, event_date = ?, location = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssssi", $title, $description, $event_date, $location, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Initiative updated successfully!'); window.location.href = 'cm.php';</script>";
    } else {
        echo "<script>alert('Failed to update initiative.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('d.php'); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Initiative</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        form {
            width: 50%;
            margin: 0 auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        input, textarea {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
    </style>
</head>
<body>

<h2 style="text-align:center;">📝 Update Initiative</h2>

<form method="post">
    <input type="text" name="title" value="<?= htmlspecialchars($initiative['title']); ?>" placeholder="Title" required>
    <textarea name="description" placeholder="Description" required><?= htmlspecialchars($initiative['description']); ?></textarea>
    <input type="date" name="event_date" value="<?= htmlspecialchars($initiative['event_date']); ?>" required>
    <input type="text" name="location" value="<?= htmlspecialchars($initiative['location']); ?>" placeholder="Location" required>
    <button type="submit">Update Initiative</button>
</form>

</body>
</html>
