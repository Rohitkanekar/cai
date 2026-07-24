<?php

require_once "includes/config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);

    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin["password"])) {

        $_SESSION["admin_id"] = $admin["id"];
        $_SESSION["admin_name"] = $admin["full_name"];

        header("Location: dashboard.php");
        exit();

    } else {

        $error = "Invalid username or password.";

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login | Concrete Arts India</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f5f5;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, Helvetica, sans-serif;
        }

        .login-card {

            width: 100%;
            max-width: 420px;

            background: #fff;

            padding: 40px;

            border-radius: 12px;

            box-shadow: 0 10px 30px rgba(0, 0, 0, .1);

        }

        .login-logo {

            text-align: center;
            margin-bottom: 30px;

        }

        .login-logo h2 {

            color: #b88e2f;
            font-weight: 700;

        }

        .btn-login {

            background: #b88e2f;
            border: none;

        }

        .btn-login:hover {

            background: #9c7627;

        }
    </style>

</head>

<body>

    <div class="login-card">

        <div class="login-logo">

            <h2>Concrete Arts India</h2>

            <p class="text-muted mb-0">
                Admin Login
            </p>

        </div>

        <?php if ($error): ?>

            <div class="alert alert-danger alert-dismissible fade show">

                <?= $error ?>

            </div>

        <?php endif; ?>

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Username
                </label>

                <input type="text" name="username" class="form-control" required>

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Password
                </label>

                <input type="password" name="password" class="form-control" required>

            </div>

            <button type="submit" class="btn btn-login text-white w-100">

                Login

            </button>

        </form>

    </div>

</body>

</html>