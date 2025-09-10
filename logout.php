<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Logout</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #74ebd5, #ACB6E5);
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }
    .logout-container {
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.2);
      text-align: center;
      max-width: 400px;
    }
    h2 {
      color: #333;
      margin-bottom: 15px;
    }
    p {
      color: #555;
      margin-bottom: 20px;
    }
    .btn {
      background: #007bff;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      text-decoration: none;
      font-size: 16px;
      cursor: pointer;
    }
    .btn:hover {
      background: #0056b3;
    }
    .redirect {
      margin-top: 15px;
      color: #666;
      font-size: 14px;
    }
  </style>
  <meta http-equiv="refresh" content="3;url=login.php">
</head>
<body>
  <div class="logout-container">
    <h2>✅ You have been logged out</h2>
    <p>Thank you for using our system. You will be redirected shortly.</p>
    <a href="login.php" class="btn">Go to Login</a>
    <p class="redirect">Redirecting in 3 seconds...</p>
  </div>
</body>
</html>
