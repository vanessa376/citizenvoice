<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: citizenlogin.php');
    exit();
}

$host = 'localhost';
$db = 'cces';
$user = 'root';
$pass = '';

$message = ''; 

try {

    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $categories = $pdo->query("SELECT id, name FROM categories")->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("<div class='error'>Database Error: " . $e->getMessage() . "</div>");
}


if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'] ?? null;
    $user_id = $_SESSION['user_id']; 

    if (empty($category_id)) {
        $message = "<div class='error'>Please select a valid category.</div>";
    } else {
        try {
            $sql = "INSERT INTO complaints (user_id, title, description, category_id, status, created_at) 
                    VALUES (:user_id, :title, :description, :category_id, 'Pending', NOW())";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':user_id' => $user_id,
                ':title' => $title,
                ':description' => $description,
                ':category_id' => $category_id
            ]);

            $message = "<div class='success'>Complaint Submitted Successfully!</div>";
        } catch (PDOException $e) {
            $message = "<div class='error'>Failed to submit complaint: " . $e->getMessage() . "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Complaint - CitiVoice</title>
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.theme.default.min.css">
    <link href="./vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
        }
        .main-container {
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            height: 100vh;
            color: white;
            padding: 20px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 15px;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
        }
        .content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .complaint-container {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            width: 500px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4CAF50;
        }
        input, textarea, select {
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
        .success {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<?php include('copy.php'); ?>
<div class="main-container">
   
    <div class="content">
        <div class="complaint-container">
            <h2>Submit a Complaint</h2>

           
            <?= $message ?? '' ?>

            <form action="" method="POST">
                <input type="text" name="title" placeholder="Complaint Title" required>
                <textarea name="description" placeholder="Describe your complaint..." required></textarea>
                
            
                <select name="category_id" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" name="submit">Submit Complaint</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
