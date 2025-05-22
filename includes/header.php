<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Include DB connection here so $conn is available
require_once __DIR__ . '/../config/db.php'; // Adjust path if needed
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BMW Showcase</title>
  <link rel="stylesheet" href="/bmw/assets/css/style.css">
</head>
<body>
<nav>
  <a href="/bmw/index.php">Home</a>

  <?php if (isset($_SESSION['user']) && is_array($_SESSION['user'])): ?>
    <?php if ($_SESSION['is_admin']): ?>
      <a href="/bmw/admin/dashboard.php">Admin</a>
    <?php endif; ?>

    <?php
    // Fetch favorites count for logged-in user
    $userId = $_SESSION['user']['id'];
    $stmtFavCount = $conn->prepare("SELECT COUNT(*) FROM favorites WHERE user_id = ?");
    $stmtFavCount->execute([$userId]);
    $favCount = $stmtFavCount->fetchColumn();
    ?>

    <a href="/bmw/favorites.php">Favorites (<?= $favCount ?>)</a>
    <a href="/bmw/auth/logout.php">Logout</a>

  <?php else: ?>
    <a href="/bmw/auth/login.php">Login</a>
    <a href="/bmw/auth/register.php">Register</a>
  <?php endif; ?>
</nav>
