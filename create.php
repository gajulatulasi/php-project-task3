<?php
require 'config.php';
if(!isset($_SESSION['user_id'])){ header("Location: login.php"); exit; }

if($_POST){
    $title   = $_POST['title'];
    $content = $_POST['content'];
    $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?,?)");
    $stmt->bind_param("ss",$title,$content);
    $stmt->execute();
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
 <title>Create Post</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
 <style>
  body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(12px);
    border: none;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    color: white;
    width: 100%;
    max-width: 600px;
  }
  .form-control {
    background: rgba(255,255,255,0.2);
    border: none;
    border-radius: 10px;
    color: white;
  }
  .form-control::placeholder {
    color: #ddd;
  }
  .form-control:focus {
    background: rgba(255,255,255,0.25);
    color: white;
    box-shadow: none;
  }
  textarea {
    min-height: 150px;
  }
  .btn-gradient {
    background: linear-gradient(45deg, #42e695, #3bb2b8);
    border: none;
    color: white;
    font-weight: 500;
    padding: 10px 20px;
    border-radius: 30px;
    transition: 0.3s;
  }
  .btn-gradient:hover {
    background: linear-gradient(45deg, #3bb2b8, #42e695);
    transform: scale(1.05);
    color: white;
  }
  .btn-back {
    position: absolute;
    top: 20px;
    left: 20px;
  }
 </style>
</head>
<body>
<div class="container">
  <a href="index.php" class="btn btn-outline-light btn-back">⬅ Back</a>
  
  <div class="card p-4">
    <h3 class="text-center mb-3">📝 Create New Post</h3>
    <form method="POST">
      <input class="form-control mb-3" type="text" name="title" placeholder="Enter title..." required>
      <textarea class="form-control mb-3" name="content" placeholder="Write your content here..." required></textarea>
      <div class="d-grid">
        <button class="btn btn-gradient">✅ Publish Post</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>
