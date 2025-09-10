<?php
require 'config.php';
if(!isset($_SESSION['user_id'])){ header("Location: login.php"); exit; }

$id   = $_GET['id'];
$post = $conn->query("SELECT * FROM posts WHERE id=$id")->fetch_assoc();

if($_POST){
    $title   = $_POST['title'];
    $content = $_POST['content'];
    $stmt = $conn->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
    $stmt->bind_param("ssi", $title,$content,$id);
    $stmt->execute();
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
 <title>Edit Post</title>
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
    max-width: 650px;
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
    background: rgba(255,255,255,0.3);
    color: white;
    box-shadow: none;
  }
  textarea {
    min-height: 160px;
  }
  .btn-gradient {
    background: linear-gradient(45deg, #ff9966, #ff5e62);
    border: none;
    color: white;
    font-weight: 500;
    padding: 10px 20px;
    border-radius: 30px;
    transition: 0.3s;
  }
  .btn-gradient:hover {
    background: linear-gradient(45deg, #ff5e62, #ff9966);
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
    <h3 class="text-center mb-3">✏️ Edit Post</h3>
    <form method="POST">
      <input class="form-control mb-3" type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
      <textarea class="form-control mb-3" name="content" required><?= htmlspecialchars($post['content']) ?></textarea>
      <div class="d-grid">
        <button class="btn btn-gradient">💾 Update Post</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>
