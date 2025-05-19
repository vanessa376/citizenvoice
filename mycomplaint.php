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


if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];


$stmt = $conn->prepare('SELECT * FROM complaints WHERE user_id = ? ORDER BY created_at DESC');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Complaints - CitiVoice</title>
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="./vendor/owl-carousel/css/owl.theme.default.min.css">
    <link href="./vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
</head>
<body>
    <?php include('copy.php'); ?>

    <div class="container">
        <h2>My Complaints</h2>
        <div class="mb-3">
        <div class="mb-3">
        <a href="submitcomp.php" class="btn btn-primary" style="background-color: #007bff; color: white;">
            ➕ Add New Complaint
        </a>
            <button onclick="printPage()" class="btn btn-primary">Print</button>
            <button onclick="exportToExcel()" class="btn btn-success">Export to Excel</button>
        </div>
        
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped" id="complaintsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Complaint Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Date Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $counter = 1;
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $counter++; ?></td>
                            <td><?= $row['title']; ?></td>
                            <td><?= $row['description']; ?></td>
                            <td><?= ucfirst($row['status']); ?></td>
                            <td><?= date('d M Y, H:i', strtotime($row['created_at'])); ?></td>
                            <td class="action-links">
                                <a href="editcomp.php?id=<?= $row['id']; ?>">✏️ Edit</a>
                                <a href="deletecomp.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this complaint?');">🗑️ Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning">No complaints found.</div>
        <?php endif; ?>
    </div>
    
    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <script src="./js/custom.min.js"></script>
    
    <script>
        function printPage() {
            window.print();
        }

        function exportToExcel() {
            const table = document.getElementById('complaintsTable');
            let csv = [];
            for (let i = 0; i < table.rows.length; i++) {
                let row = [], cols = table.rows[i].querySelectorAll('td, th');
                cols.forEach(col => row.push(col.innerText));
                csv.push(row.join(","));
            }

            let csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
            let downloadLink = document.createElement("a");
            downloadLink.download = "complaints_report.csv";
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = "none";
            document.body.appendChild(downloadLink);
            downloadLink.click();
        }
    </script>
</body>
</html>
