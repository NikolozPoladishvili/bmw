<?php
session_start();
require 'config/db.php';
include 'includes/header.php';

$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? '';

$orderBy = '';
if ($sort === 'price_asc') {
    $orderBy = ' ORDER BY m.price ASC';
} elseif ($sort === 'price_desc') {
    $orderBy = ' ORDER BY m.price DESC';
} elseif ($sort === 'year_asc') {
    $orderBy = ' ORDER BY m.year ASC';
} elseif ($sort === 'year_desc') {
    $orderBy = ' ORDER BY m.year DESC';
}

if ($search) {
    $stmt = $conn->prepare("SELECT m.*, c.name AS category_name FROM models m JOIN categories c ON m.category_id = c.id WHERE m.name LIKE ? OR m.type LIKE ?" . $orderBy);
    $likeSearch = "%$search%";
    $stmt->execute([$likeSearch, $likeSearch]);
} else {
    $stmt = $conn->query("SELECT m.*, c.name AS category_name FROM models m JOIN categories c ON m.category_id = c.id" . $orderBy);
}
$models = $stmt->fetchAll();
?>

<h1>BMW Models Showcase</h1>

<form method="GET" action="index.php" style="margin-bottom:20px;">
  <input style ="margin: 10px; width: auto;" type="text" name="search" placeholder="Search by name or type" value="<?= htmlspecialchars($search) ?>">

  <select name="sort">
    <option value="">Sort By</option>
    <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
    <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
    <option value="year_asc" <?= $sort === 'year_asc' ? 'selected' : '' ?>>Year: Oldest First</option>
    <option value="year_desc" <?= $sort === 'year_desc' ? 'selected' : '' ?>>Year: Newest First</option>
  </select>

  <button class = "btn" type="submit">Search</button>
</form>

<div class="models">
  <?php if (!$models): ?>
    <p>No models found.</p>
  <?php else: ?>
<?php foreach ($models as $model): ?>
  <div class="model-card">
    <img src="./assets/images/<?= htmlspecialchars($model['image']) ?>" alt="<?= htmlspecialchars($model['name']) ?>">
    <div class="details">
      <h3><?= htmlspecialchars($model['name']) ?></h3>
      <p><strong>Type:</strong> <?= htmlspecialchars($model['type']) ?></p>
      <p><strong>Year:</strong> <?= $model['year'] ?></p>
      <p><strong>Price:</strong> $<?= number_format($model['price'], 2) ?></p>
      <p><strong>Category:</strong> <?= htmlspecialchars($model['category_name']) ?></p>

      <?php if (isset($_SESSION['user']) && is_array($_SESSION['user'])): ?>
        <form method="POST" action="favorite.php" class="favorite-form">
          <input type="hidden" name="model_id" value="<?= $model['id'] ?>">
          <button type="submit" class="favorite-btn">❤️ Favorite</button>
        </form>
      <?php else: ?>
        <p><a href="/bmw/auth/login.php">Login to favorite</a></p>
      <?php endif; ?>
    </div>
  </div>
<?php endforeach; ?>

  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
