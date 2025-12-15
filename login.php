<?php
// Use centralized session config
require_once "session_config.php";

require_once "User.php";
$userObj = new User();

$email = "";
$error = ["email" => "", "password" => ""];
$submit_error = "";
$login_success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim(htmlspecialchars($_POST["email"]));
    $password = $_POST["password"];

    if (empty($email)) {
        $error["email"] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error["email"] = "Invalid email format";
    }

    if (empty($password)) {
        $error["password"] = "Password is required";
    }

    if (empty(array_filter($error))) {
        $user = $userObj->login($email, $password);
    
        if ($user) {
            if ($user['role'] == 'customer' && $user['is_verified'] == 0) {
                $submit_error = "Please verify your email before logging in. <a href='resendVerification.php?email=" . urlencode($email) . "'>Resend verification email</a>";
            } else {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                
                // Force save session
                session_write_close();
                session_start();

                $login_success = true;
            }
        } else {
            $submit_error = "Invalid email or password";
        }
    } else {
        $submit_error = "Please fill out all required fields";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Salon Booking System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #764ba2 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            width: 100%;
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .container h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            color: #333;
        }

        .success-box {
            background: #d4edda;
            color: #155724;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 2px solid #c3e6cb;
        }

        .success-box h2 {
            margin-bottom: 15px;
            font-size: 24px;
        }

        .success-box .session-info {
            background: white;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            font-size: 14px;
        }

        .success-box a {
            display: inline-block;
            margin-top: 15px;
            padding: 15px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
        }

        .success-box a:hover {
            background: #5568d3;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 15px;
            color: #333;
        }

        label span {
            color: red;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 15px;
        }

        input:focus {
            border-color: #667eea;
            outline: none;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 4px;
        }

        input[type="submit"] {
            margin-top: 25px;
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }

        input[type="submit"]:hover {
            transform: translateY(-2px);
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
        }

        .home-link {
            text-align: center;
            margin-top: 15px;
        }

        .home-link a {
            color: #999;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($login_success): ?>
            <div class="success-box">
                <h2>✅ Login Successful!</h2>
                <p>Welcome back, <strong><?php echo htmlspecialchars($_SESSION['full_name']); ?></strong>!</p>
                
                <div class="session-info">
                    <strong>Session Information:</strong><br>
                    User ID: <?php echo $_SESSION['user_id']; ?><br>
                    Role: <?php echo strtoupper($_SESSION['role']); ?><br>
                    Session ID: <?php echo substr(session_id(), 0, 20); ?>...
                </div>
                
                <p style="margin-top: 15px;">Click below to access your dashboard:</p>
                
                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'staff'): ?>
                    <a href="admin/test_dashboard.php">Go to Dashboard →</a>
                <?php else: ?>
                    <a href="index.php">Go to Home →</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <h1>Login</h1>

            <form action="" method="post">
                <label for="email">Email <span>*</span></label>
                <input type="email" name="email" id="email" value="<?= $email; ?>" autofocus>
                <p class="error"><?= $error["email"]; ?></p>

                <label for="password">Password <span>*</span></label>
                <input type="password" name="password" id="password">
                <p class="error"><?= $error["password"]; ?></p>

                <input type="submit" value="Login">

                <?php if($submit_error): ?>
                    <p class="error" style="text-align: center; margin-top: 10px;"><?= $submit_error; ?></p>
                <?php endif; ?>
            </form>

            <div class="register-link">
                Don't have an account? <a href="register.php">Register here</a>
            </div>

            <div class="home-link">
                <a href="index.php">← Back to Home</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>