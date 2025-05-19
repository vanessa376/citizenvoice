<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Complaints</title>
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
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .status {
            font-weight: bold;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            background-color: #4CAF50;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h3>Admin Menu</h3>
    <a href="admindash.php">Dashboard</a>
    <a href="view.php">All Complaints</a>
    <a href="pending.php">Pending Complaints</a>
    <a href="resolved.php">Resolved Complaints</a>
    <a href="addcomplaint.php">Add Complaint</a>
    <a href="logout.php">Logout</a>
</div>

<div class="header">
    <h2>All Complaints</h2>
</div>

<div class="container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Citizen Name</th>
                <th>Complaint</th>
                <th>Category</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
        
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

         
            $sql = "SELECT * FROM complaints ORDER BY created_at DESC";
            $stmt = $pdo->query($sql);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['complaint']}</td>
                        <td>{$row['category']}</td>
                        <td class='status'>{$row['status']}</td>
                        <td class='actions'>
                            <a href='view_complain.php?id={$row['id']}' class='btn'>View</a>
                            <a href='status.php?id={$row['id']}' class='btn'>Update Status</a>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
