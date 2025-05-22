<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user']) || empty($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: /bmw/auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');

    if ($name && $category) {
        $stmt = $conn->prepare("INSERT INTO models (name, category) VALUES (?, ?)");
        $stmt->execute([$name, $category]);
    }
}

header('Location: /bmw/admin/dashboard.php');
exit;
