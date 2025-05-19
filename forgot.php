<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="./css/style.css" rel="stylesheet">
    <style>
    .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo-container img {
            width: 120px;
        }
        </style>
</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                <div class="logo-container">
                                        <img src="logo.png" alt="CitiVoice Logo">
                                    </div>
                                    <h4 class="text-center mb-4">Forgot Password</h4>
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label><strong>Enter your Username</strong></label>
                                            <input type="text" class="form-control" name="username" required>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                                        </div>
                                    </form>
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

                                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                        $username = $_POST['username'];
                                        $sql = "SELECT * FROM admin WHERE username = :username";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute([':username' => $username]);
                                        $user = $stmt->fetch(PDO::FETCH_ASSOC);

                                        if ($user) {
                                            $newPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
                                            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                                            $updateSql = "UPDATE admin SET password = :password WHERE username = :username";
                                            $updateStmt = $pdo->prepare($updateSql);
                                            $updateStmt->execute([
                                                ':password' => $hashedPassword,
                                                ':username' => $username
                                            ]);
                                            echo "<div class='alert alert-success mt-3'>Your new password is: <strong>$newPassword</strong></div>";
                                        } else {
                                            echo "<div class='alert alert-danger mt-3'>Username not found!</div>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./vendor/global/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <script src="./js/custom.min.js"></script>
</body>

</html>
