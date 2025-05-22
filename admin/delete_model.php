<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user']) || empty($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: /bmw/auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['model_id'])) {
    $modelId = (int) $_POST['model_id'];

    $stmt = $conn->prepare("DELETE FROM models WHERE id = ?");
    $stmt->execute([$modelId]);
}

header('Location: /bmw/admin/dashboard.php');
exit;
