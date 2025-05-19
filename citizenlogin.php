<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login - CitiVoice</title>

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
                                    <h4 class="text-center mb-4">Sign in to your account</h4>

                                    <?php
                                    session_start();
                                    if (isset($_POST['login'])) {
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

                                       
                                        $email = htmlspecialchars($_POST['email']);
                                        $password = htmlspecialchars($_POST['password']);

                                       
                                        $sql = "SELECT * FROM users WHERE email = :email";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute([':email' => $email]);
                                        $user = $stmt->fetch(PDO::FETCH_ASSOC);

                                      
                                        if ($user && password_verify($password, $user['password'])) {
                                       
                                            $_SESSION['user_id'] = $user['id'];
                                            $_SESSION['user_name'] = $user['name'];
                                            $_SESSION['role'] = $user['role'];

                                         
                                            if ($user['role'] == 'admin') {
                                                header('Location: admindash.php');
                                                exit();
                                            } elseif ($user['role'] == 'citizen') {
                                                header('Location: citizendash.php');
                                                exit();
                                            }
                                        } else {
                                            echo "<div class='alert alert-danger text-center'>Invalid Email or Password</div>";
                                        }
                                    }
                                    ?>

                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label><strong>Email</strong></label>
                                            <input type="email" class="form-control" name="email" required>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Password</strong></label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                                <div class="form-check ml-2">
                                                    <input class="form-check-input" type="checkbox" id="basic_checkbox_1">
                                                    <label class="form-check-label" for="basic_checkbox_1">Remember me</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <a href="forgot.php">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                                        </div>
                                    </form>

                                    <div class="new-account mt-3">
                                        <p>Don't have an account? <a class="text-primary" href="signupcitizen.php">Sign up</a></p>
                                    </div>
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
