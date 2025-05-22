<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit;
}

$userId = $_SESSION['user']['id'] ?? null;
$modelId = $_POST['model_id'] ?? null;

if (!$userId || !$modelId) {
    exit('Invalid request');
}

$stmt = $conn->prepare("INSERT IGNORE INTO favorites (user_id, model_id) VALUES (?, ?)");
$stmt->execute([$userId, $modelId]);

header("Location: index.php");
exit;
