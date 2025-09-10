<?php
require 'config.php';
if(!isset($_SESSION['user_id'])){ 
    header("Location: login.php"); 
    exit; 
}

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM posts WHERE id=$id");
    $post = $result->fetch_assoc();

    if(!$post){
        echo "<h2 style='color:red;text-align:center;'>Post not found!</h2>";
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}

// If confirmed delete
if(isset($_POST['confirm_delete'])){
    $conn->query("DELETE FROM posts WHERE id=$id");
    header("Location: index.php?msg=Post+deleted+successfully");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Post</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-xl p-8 max-w-lg w-full text-center">
        <h2 class="text-2xl font-bold text-red-600 mb-4">⚠️ Confirm Delete</h2>
        <p class="text-gray-700 mb-6">
            Are you sure you want to delete this post?<br>
            <span class="font-semibold text-black">"<?= htmlspecialchars($post['title']); ?>"</span>
        </p>

        <form method="post">
            <button type="submit" name="confirm_delete" 
                class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg mr-4">
                Yes, Delete
            </button>
            <a href="index.php" 
               class="bg-gray-300 hover:bg-gray-400 text-black px-6 py-2 rounded-lg">
               Cancel
            </a>
        </form>
    </div>

</body>
</html>
