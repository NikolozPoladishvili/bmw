<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit;
}

$userId = $_SESSION['user']['id'];

$stmtUser = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmtUser->execute([$userId]);
$user = $stmtUser->fetch();

$stmtFavCount = $conn->prepare("SELECT COUNT(*) FROM favorites WHERE user_id = ?");
$stmtFavCount->execute([$userId]);
$favCount = $stmtFavCount->fetchColumn();

include 'includes/header.php';
?>

<h1>Your Profile</h1>
<p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
<p><strong>Favorites count:</strong> <?= $favCount ?></p>

<a href="/bmw/favorites.php">View your favorite models</a><br><br>
<a href="/bmw/auth/logout.php">Logout</a>

<?php include 'includes/footer.php'; ?>