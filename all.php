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


$stmt = $conn->prepare("SELECT c.id, c.title, c.description, c.status, 
                               IFNULL(cat.name, 'Uncategorized') AS category_name, 
                               u.name AS citizen_name, c.created_at
                        FROM complaints c 
                        JOIN users u ON c.user_id = u.id 
                        LEFT JOIN categories cat ON c.category_id = cat.id 
                        ORDER BY c.created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<?php include('d.php'); ?>
    <title>All Complaints Overview</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }
        .table-container {
            width: 90%;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 80%;
            border-collapse: collapse;
            height: 50%;
            margin-left:20%;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #dddddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .actions a {
            margin-right: 5px;
        }
    </style>
</head>
<body>

    <h2>📊 All Complaints Overview </h2>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Citizen Name</th>
                    <th>Complaint Title</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Date Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1; while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $counter++; ?></td>
                        <td><?= $row['citizen_name']; ?></td>
                        <td><?= $row['title']; ?></td>
                        <td><?= $row['description']; ?></td>
                        <td>
                            <?php if ($row['category_name'] === "Uncategorized"): ?>
                                <span style='color:red;'>Uncategorized</span>
                            <?php else: ?>
                                <?= $row['category_name']; ?>
                            <?php endif; ?>
                        </td>
                        <td><?= ucfirst($row['status']); ?></td>
                        <td><?= date('d M Y, H:i', strtotime($row['created_at'])); ?></td>
                        <td class="actions">
                            <a href="respond.php?id=<?= $row['id']; ?>">Respond</a> | 
                            <a href="resolve.php?id=<?= $row['id']; ?>">Resolve</a> | 
                            <a href="status.php?id=<?= $row['id']; ?>">Update Status</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
