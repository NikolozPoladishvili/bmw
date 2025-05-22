<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user']) || empty($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: /bmw/auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['fav_id'])) {
    $favId = (int) $_POST['fav_id'];

    $stmt = $conn->prepare("DELETE FROM favorites WHERE id = ?");
    $stmt->execute([$favId]);
}

header('Location: /bmw/admin/dashboard.php');
exit;
