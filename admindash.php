<?php
session_start();
$host = 'localhost';
$db = 'cces';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$total_complaints = $conn->query("SELECT COUNT(*) AS total FROM complaints")->fetch_assoc()['total'];


$pending_complaints = $conn->query("SELECT COUNT(*) AS total FROM complaints WHERE status = 'pending'")->fetch_assoc()['total'];


$resolved_complaints = $conn->query("SELECT COUNT(*) AS total FROM complaints WHERE status = 'resolved'")->fetch_assoc()['total'];


$in_progress_complaints = $conn->query("SELECT COUNT(*) AS total FROM complaints WHERE status = 'in progress'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reports & Analytics</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            gap: 30px;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            width: 80%;
        }

        .report-card {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 2px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .report-card:hover {
            transform: translateY(-5px);
        }

        .report-card h3 {
            margin-bottom: 15px;
            font-size: 18px;
        }

        .report-card p {
            font-size: 24px;
            font-weight: bold;
        }

        #complaintsChart {
            width: 80%;
            max-width: 600px;
        }
    </style>
</head>
<body>

    <?php include('d.php'); ?>

    <div class="container">
        <div class="card-container">
            <div class="report-card">
                <h3>Total Complaints</h3>
                <p><?= $total_complaints ?></p>
            </div>

            <div class="report-card">
                <h3>Pending Complaints</h3>
                <p><?= $pending_complaints ?></p>
            </div>

            <div class="report-card">
                <h3>Resolved Complaints</h3>
                <p><?= $resolved_complaints ?></p>
            </div>

            <div class="report-card">
                <h3>In Progress Complaints</h3>
                <p><?= $in_progress_complaints ?></p>
            </div>
        </div>

      
        <canvas id="complaintsChart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('complaintsChart').getContext('2d');
        const complaintsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pending', 'Resolved', 'In Progress'],
                datasets: [{
                    label: 'Number of Complaints',
                    data: [<?= $pending_complaints ?>, <?= $resolved_complaints ?>, <?= $in_progress_complaints ?>],
                    backgroundColor: [
                        '#f39c12',
                        '#28a745',
                        '#17a2b8'
                    ],
                    borderColor: [
                        '#e67e22',
                        '#218838',
                        '#117a8b'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    </script>
</body>
</html>
