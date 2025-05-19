<?php

session_start();
ob_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$host = 'localhost';
$db = 'cces';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}


$sql = "SELECT id, name, email, phone, role, created_at FROM users WHERE role='citizen'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citizen Management</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .container {
            margin: 20px auto;
            max-width: 1200px;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .search-bar input {
            width: 300px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .report {
            margin-top: 30px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .report h3 {
            margin-bottom: 10px;
        }

        .btn-container {
            margin-bottom: 20px;
        }

        button {
            margin-right: 10px;
            padding: 10px 15px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

<?php include('d.php'); ?>
<div class="container">
    <h2>Citizen Management</h2>


    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search Citizens..." onkeyup="searchCitizens()">
    </div>

    <div class="btn-container">
        <button onclick="exportToCSV()">Export to Excel</button>
        <button onclick="printReport()">Print Report</button>
    </div>

    <div class="table-container">
        <table id="citizensTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Role</th>
                    <th>Registered Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['phone'] ?></td>
                            <td><?= $row['role'] ?></td>
                            <td><?= date("d M Y", strtotime($row['created_at'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">No Citizens Found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="report">
        <h3>Report Summary</h3>
        <p>Total Citizens Registered: <?= $result->num_rows ?></p>
        <p>Date of Report: <?= date("d M Y, H:i") ?></p>
    </div>
</div>

<script>
  
    function searchCitizens() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("citizensTable");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            tr[i].style.display = "none";
            td = tr[i].getElementsByTagName("td");
            for (var j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        break;
                    }
                }
            }
        }
    }

   
    function exportToCSV() {
        let table = document.getElementById("citizensTable");
        let rows = table.querySelectorAll("tr");
        let csv = [];

        rows.forEach(row => {
            let cols = row.querySelectorAll("td, th");
            let data = Array.from(cols).map(col => col.innerText);
            csv.push(data.join(","));
        });

        let csvContent = csv.join("\n");
        let link = document.createElement("a");
        link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csvContent);
        link.download = "Citizen_Report.csv";
        link.click();
    }


    function printReport() {
        window.print();
    }
</script>

</body>
</html>
