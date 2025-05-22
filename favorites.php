<?php
session_start();
require 'config/db.php';

// Redirect if not logged in
if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    header("Location: /bmw/auth/login.php");
    exit;
}

$userId = $_SESSION['user']['id'];

// Fetch favorites models with their details
$stmt = $conn->prepare("
    SELECT m.* FROM models m
    JOIN favorites f ON m.id = f.model_id
    WHERE f.user_id = ?
");
$stmt->execute([$userId]);
$favorites = $stmt->fetchAll();

include 'includes/header.php';
?>

<h1>Your Favorite BMW Models</h1>

<?php if (!$favorites): ?>
    <p>You have no favorite models yet.</p>
<?php else: ?>
    <div class="models">
        <?php foreach ($favorites as $model): ?>
            <div class="model-card">
                <img src="/bmw/assets/images/<?= htmlspecialchars($model['image']) ?>" alt="<?= htmlspecialchars($model['name']) ?>">
                <div class="details">
                    <h3><?= htmlspecialchars($model['name']) ?></h3>
                    <p><strong>Type:</strong> <?= htmlspecialchars($model['type']) ?></p>
                    <p><strong>Year:</strong> <?= $model['year'] ?></p>
                    <p><strong>Price:</strong> $<?= number_format($model['price'], 2) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
