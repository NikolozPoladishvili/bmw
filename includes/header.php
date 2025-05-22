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
<nav style="display: flex; align-items: center; gap: 20px; padding: 10px;">
  <a href="/bmw/index.php">
    <img src="/bmw/assets/images/bmw-logo.png" alt="BMW Logo" style="height: 40px;">
  </a>
  <a href="/bmw/index.php">Home</a>


  <?php
  if (isset($_SESSION['user']) && is_array($_SESSION['user'])):
    if (!isset($conn)) {
      require_once __DIR__ . '/../config/db.php';
    }
    $userId = $_SESSION['user']['id'];
    $stmt = $conn->prepare("SELECT COUNT(*) FROM favorites WHERE user_id = ?");
    $stmt->execute([$userId]);
    $favCount = $stmt->fetchColumn();
  ?>
    <a href="/bmw/favorites.php">Favorites (<?= $favCount ?>)</a>
    <a href="/bmw/profile.php">View Profile</a>
    <?php if (!empty($_SESSION['is_admin'])): ?>
      <a href="/bmw/admin/dashboard.php">Admin</a>
    <?php endif; ?>
    <a href="/bmw/auth/logout.php">Logout</a>
  <?php else: ?>
    <a href="/bmw/auth/login.php">Login</a>
    <a href="/bmw/auth/register.php">Register</a>
  <?php endif; ?>
</nav>


