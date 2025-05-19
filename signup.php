<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - CitiVoice</title>
    <link rel="stylesheet" href="./css/style.css">
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
                                    <h4 class="text-center mb-4">Create Your Account</h4>
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label><strong>Full Name</strong></label>
                                            <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control" placeholder="Enter Email Address" required>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Phone Number</strong></label>
                                            <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number" required>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Password</strong></label>
                                            <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Confirm Password</strong></label>
                                            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Select Role</strong></label>
                                            <select name="role" class="form-control" required>
                                                <option value="">-- Select Role --</option>
                                                <option value="citizen">Citizen</option>
                                                <option value="admin">Admin(agency)</option>
                                            </select>
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" name="signup" class="btn btn-primary btn-block">Sign Up</button>
                                        </div>
                                    </form>

                                    <div class="new-account mt-3 text-center">
                                        <p>Already have an account? <a class="text-primary" href="login.php">Login here</a></p>
                                    </div>

                                    <?php
                                    if (isset($_POST['signup'])) {
                                        $name = $_POST['name'];
                                        $email = $_POST['email'];
                                        $phone = $_POST['phone'];
                                        $password = $_POST['password'];
                                        $confirm_password = $_POST['confirm_password'];
                                        $role = $_POST['role'];

                                        if ($password !== $confirm_password) {
                                            echo "<div class='error text-center'>Passwords do not match.</div>";
                                            exit();
                                        }

                                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                                        $host = 'localhost';
                                        $db = 'cces';
                                        $user = 'root';
                                        $pass = '';

                                        try {
                                            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
                                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                            $checkEmail = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                                            $checkEmail->execute([':email' => $email]);

                                            if ($checkEmail->rowCount() > 0) {
                                                echo "<div class='error text-center'>This email is already registered. <a href='login.php'>Login here</a></div>";
                                            } else {
                                                $sql = "INSERT INTO users (name, email, phone, password, role) VALUES (:name, :email, :phone, :password, :role)";
                                                $stmt = $pdo->prepare($sql);
                                                $stmt->execute([
                                                    ':name' => $name,
                                                    ':email' => $email,
                                                    ':phone' => $phone,
                                                    ':password' => $hashed_password,
                                                    ':role' => $role
                                                ]);
                                                echo "<div class='success text-center'>Account Created Successfully! <a href='login.php'>Login Here</a></div>";
                                            }
                                        } catch (PDOException $e) {
                                            echo "<div class='error text-center'>Failed to Register: " . $e->getMessage() . "</div>";
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
</body>

</html>
