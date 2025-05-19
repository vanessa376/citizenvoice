<?php
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'citizen') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name']; 

$host = 'localhost';
$db = 'cces';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}


$totalComplaintsQuery = "SELECT COUNT(*) AS total FROM complaints WHERE user_id = '$user_id'";
$totalResult = $conn->query($totalComplaintsQuery);
$totalComplaints = $totalResult->fetch_assoc()['total'];

$resolvedQuery = "SELECT COUNT(*) AS total FROM complaints WHERE status = 'resolved' AND user_id = '$user_id'";
$resolvedResult = $conn->query($resolvedQuery);
$resolvedComplaints = $resolvedResult->fetch_assoc()['total'];

$pendingQuery = "SELECT COUNT(*) AS total FROM complaints WHERE status = 'pending' AND user_id = '$user_id'";
$pendingResult = $conn->query($pendingQuery);
$pendingComplaints = $pendingResult->fetch_assoc()['total'];


$monthlyQuery = "
    SELECT 
        MONTH(created_at) AS month,
        COUNT(*) AS total
    FROM complaints 
    WHERE user_id = '$user_id'
    GROUP BY MONTH(created_at)
";
$monthlyResult = $conn->query($monthlyQuery);

$monthlyData = [];
while ($row = $monthlyResult->fetch_assoc()) {
    $monthlyData[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CitiVoice - Dashboard</title>
    <link href="./css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>


<?php include('copy.php'); ?>
    <div class="content-body"> 
        <div class="container-fluid">
            <div class="row text-center">
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Complaints</h5>
                            <p class="card-text">
                                <span id="total-complaints"><?= $totalComplaints; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Resolved Complaints</h5>
                            <p class="card-text">
                                <span id="resolved-complaints"><?= $resolvedComplaints; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pending Complaints</h5>
                            <p class="card-text">
                                <span id="pending-complaints"><?= $pendingComplaints; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Complaints Overview (Monthly)</h5>
                            <canvas id="complaintsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
      
        const monthlyData = <?= json_encode($monthlyData); ?>;
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const graphData = new Array(12).fill(0);

        monthlyData.forEach(entry => {
            graphData[entry.month - 1] = entry.total;
        });

        const ctx = document.getElementById('complaintsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Complaints per Month',
                    data: graphData,
                    backgroundColor: '#2196F3',
                    borderColor: '#2196F3',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
