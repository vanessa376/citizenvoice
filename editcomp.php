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
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

 
    $stmt = $conn->prepare("UPDATE complaints SET title = ?, description = ? WHERE id = ?");
    $stmt->bind_param('ssi', $title, $description, $id);
    $stmt->execute();

   
    header('Location: mycomplaint.php');
    exit();
}


$id = $_GET['id'];
$result = $conn->query("SELECT * FROM complaints WHERE id = $id");
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Complaint - CitiVoice</title>
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.theme.default.min.css">
    <link href="./vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .main-container {
            display: flex;
        }
        .content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            width: 500px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4CAF50;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        a.back-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        a.back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>


<?php include('copy.php'); ?>

<div class="main-container">
    <div class="content">
        <div class="form-container">
            <h2>Edit Complaint</h2>
            <form action="editcomp.php" method="POST">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                <input type="text" name="title" value="<?= $data['title'] ?>" placeholder="Enter Title" required>
                <textarea name="description" placeholder="Enter Description" required><?= $data['description'] ?></textarea>
                <button type="submit">💾 Save Changes</button>
            </form>
            <a href="mycomplaint.php" class="back-link">← Back to My Complaints</a>
        </div>
    </div>
</div>

</body>
</html>
