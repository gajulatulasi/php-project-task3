<?php
session_start();
require "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first    = trim($_POST['first_name']);
    $last     = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $pass     = $_POST['password'];
    $cpass    = $_POST['confirm_password'];

    if ($pass !== $cpass) {
        $error = "Passwords do not match!";
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE email=? OR username=?");
        $check->bind_param("ss", $email, $username);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows > 0) {
            $error = "Email or username already registered!";
        } else {
            $hash = password_hash($pass, PASSWORD_BCRYPT);

            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, password) VALUES (?,?,?,?,?)");
            $stmt->bind_param("sssss", $first, $last, $username, $email, $hash);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit;
            } else {
                $error = "Something went wrong. Try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #4b6cb7;  /* fallback */
            background: linear-gradient(to right, #182848, #4b6cb7);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-box {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            width: 350px;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 15px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .terms {
            font-size: 12px;
            color: #555;
            margin: 10px 0;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background: linear-gradient(to right, #56ab2f, #a8e063);
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .login-link {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }
        .error {
            background: #ffdddd;
            border: 1px solid #ff5c5c;
            padding: 8px;
            color: #a00;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Register</h2>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="POST" action="">
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="text" name="username" placeholder="username" required>
            <input type="text" name="email" placeholder="Email"required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            
            <div class="terms">
                <input type="checkbox" required> I accept the <a href="#">Terms of Use</a> & <a href="#">Privacy Policy</a>.
            </div>
            
            <button type="submit" class="btn">Register Now</button>
        </form>
        <div class="login-link">
            Already have an account? <a href="login.php">Sign in</a>
        </div>
    </div>
</body>
</html>
