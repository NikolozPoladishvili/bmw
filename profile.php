<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit;
}

$userId = $_SESSION['user']['id'];
$userName = $_SESSION['user']['name'];

// Get count of favorites
$stmtFav = $conn->prepare("SELECT COUNT(*) FROM favorites WHERE user_id = ?");
$stmtFav->execute([$userId]);
$favoritesCount = $stmtFav->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Your Profile</title>
  <link rel="stylesheet" href="/bmw/assets/css/style.css" />
</head>
<body>
  <h1>Welcome, <?= htmlspecialchars($userName) ?></h1>
  <p>Your favorites count: <?= $favoritesCount ?></p>
  <p><a href="/bmw/index.php">Back to Home</a></p>
</body>
</html>
