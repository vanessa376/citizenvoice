""<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CitiVoice - Sidebar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        .sidebar {
            position: fixed;
            width: 250px;
            height: 100vh;
            background-color: #2c3e50;
            color: white;
            overflow-y: auto;
            transition: all 0.3s;
        }

        .sidebar .logo {
            text-align: center;
            padding: 15px 0;
            font-size: 22px;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar ul li a {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            padding: 15px 20px;
            font-size: 16px;
            transition: background 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #34495e;
        }

        .sidebar ul li a.active {
            background-color: #2980b9;
        }

        .sidebar ul li a i {
            margin-right: 10px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 10px 0;
            z-index: 999;
            height:45px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo">
            <img src="logo.png" alt="CitiVoice Logo" style="height: 70px;">
        </div>
        <ul>
            <li><a href="citizendash.php" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="mycomplaint.php"><i class="fas fa-file-alt"></i> My Complaints Overview</a></li>
            <li><a href="feed.php"><i class="fas fa-comments"></i> Feedback & Status</a></li>
            <li><a href="res.php"><i class="fas fa-history"></i> Resolution History</a></li>
            <li><a href="c.php"><i class="fas fa-hand-holding-heart"></i> Community Initiatives</a></li>
            <li><a href="pub.php"><i class="fas fa-users"></i> Public Forum</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h2>Welcome to Citizendash Dashboard</h2>
        <p>Select an option from the sidebar to get started.</p>
    </div>

    <div class="footer">
        <div class="copyright">
            <p>Copyright © Designed & Developed by <a href="#" target="_blank" style="color: #ecf0f1;">Vanessa</a> 2025</p>
        </div>
    </div>
</body>

</html>
""
