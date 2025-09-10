<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$keyword = isset($_GET['search']) ? $_GET['search'] : '';
$page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit   = 5;
$offset  = ($page - 1) * $limit;

$query = "SELECT * FROM posts";
if ($keyword != '') {
   $query .= " WHERE title LIKE '%$keyword%' OR content LIKE '%$keyword%'";
}
$query .= " ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Blog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-radius: 15px;
    }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0px 5px 15px rgba(0,0,0,0.15);
      transition: transform 0.2s;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .page-link {
      border-radius: 50% !important;
      margin: 0 5px;
    }
    .btn-gradient {
      background: linear-gradient(45deg, #42e695, #3bb2b8);
      border: none;
      color: white;
      transition: 0.3s;
    }
    .btn-gradient:hover {
      background: linear-gradient(45deg, #3bb2b8, #42e695);
      color: white;
    }
  </style>
</head>
<body>
  <div class="container py-4">

    <nav class="navbar navbar-expand-lg p-3 mb-4 shadow-sm">
      <div class="container-fluid">
        <h3 class="text-white mb-0">My Blog</h3>
        <div>
          <a href="create.php" class="btn btn-gradient me-2">➕ New Post</a>
          <a href="logout.php" class="btn btn-outline-light">Logout</a>
        </div>
      </div>
    </nav>

    <form class="d-flex mb-4" method="GET">
      <input type="text" class="form-control me-2" name="search" placeholder="🔍 Search posts..."
             value="<?= htmlspecialchars($keyword) ?>">
      <button class="btn btn-light">Search</button>
    </form>

    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card mb-4">
          <div class="card-body">
            <h4 class="card-title text-primary"><?= htmlspecialchars($row['title']); ?></h4>
            <p class="card-text"><?= nl2br(htmlspecialchars(substr($row['content'], 0, 200))); ?>...</p>
            <div class="d-flex justify-content-between">
              <small class="text-muted">Posted on <?= date("M d, Y", strtotime($row['created_at'])); ?></small>
              <div>
                <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">🗑️ Delete</a>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="alert alert-light text-center shadow-sm">No posts found!</div>
    <?php endif; ?>

    <?php
      $countQuery = "SELECT COUNT(*) AS total FROM posts";
      if ($keyword != '') {
        $countQuery .= " WHERE title LIKE '%$keyword%' OR content LIKE '%$keyword%'";
      }
      $totalRows  = $conn->query($countQuery)->fetch_assoc()['total'];
      $totalPages = ceil($totalRows / $limit);
    ?>
    <?php if ($totalPages > 1): ?>
      <nav class="d-flex justify-content-center">
        <ul class="pagination">
          <?php for ($i=1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= ($i==$page ? 'active':'') ?>">
              <a class="page-link" href="?page=<?= $i ?>&search=<?= $keyword ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
    <?php endif; ?>

  </div>
</body>
</html>
