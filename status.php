<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Complaint Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #333;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 15px;
            text-decoration: none;
            color: white;
            width: 100%;
            text-align: center;
            margin-bottom: 5px;
        }
        .sidebar a:hover {
            background-color: #555;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 15px;
            margin-left: 250px;
        }
        .container {
            margin-left: 250px;
            padding: 20px;
            max-width: 600px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        select {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px;
            background-color:rgb(18, 30, 138);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color:rgb(36, 160, 36);
        }
    </style>
</head>
<body>

<?php include('d.php'); ?>


</div>

<div class="container">
    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $host = 'localhost';
        $db = 'cces';
        $user = 'root';
        $pass = '';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

        if (isset($_POST['update'])) {
            $new_status = $_POST['status'];
            $sql = "UPDATE complaints SET status = :status, updated_at = NOW() WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':status' => $new_status, ':id' => $id]);
            echo "<script>alert('Status updated successfully!'); window.location.href = 'all.php';</script>";
        }

        echo "<form method='POST'>
                <select name='status'>
                    <option value='Pending'>Pending</option>
                    <option value='In Progress'>In Progress</option>
                    <option value='Resolved'>Resolved</option>
                </select>
                <button type='submit' name='update'>Update Status</button>
              </form>";
    } else {
        echo "<p>No complaint ID provided.</p>";
    }
    ?>
</div>

</body>
</html>
