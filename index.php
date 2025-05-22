<?php
require 'config/db.php';
include 'includes/header.php';

$stmt = $conn->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();
?>

<h1>BMW Models Showcase</h1>

<?php foreach ($categories as $category): ?>
  <section class="category">
    <h2><?= htmlspecialchars($category['name']) ?></h2>
    <?php
    $stmt2 = $conn->prepare("SELECT * FROM models WHERE category_id = ?");
    $stmt2->execute([$category['id']]);
    $models = $stmt2->fetchAll();
    ?>
    <?php if (!$models): ?>
      <p>No models available.</p>
    <?php else: ?>
      <div class="models">
        <?php foreach ($models as $model): ?>
          <div class="model-card">
            <img src="../assets/images/<?= htmlspecialchars($model['image']) ?>" alt="<?= htmlspecialchars($model['name']) ?>">
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
  </section>
<?php endforeach; ?>

<?php include 'includes/footer.php'; ?>