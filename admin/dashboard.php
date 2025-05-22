<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Check admin
if (!isset($_SESSION['user']) || empty($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: /bmw/auth/login.php');
    exit;
}

// Fetch car models
$stmtModels = $conn->query("SELECT * FROM models ORDER BY id DESC");
$models = $stmtModels->fetchAll();

// Fetch favorites with user and model info
$stmtFavs = $conn->query("
    SELECT f.id AS fav_id, u.name AS user_name, m.name AS model_name 
    FROM favorites f
    JOIN users u ON f.user_id = u.id
    JOIN models m ON f.model_id = m.id
    ORDER BY f.id DESC
");
$favorites = $stmtFavs->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard - BMW</title>
  <link rel="stylesheet" href="/bmw/assets/css/style.css" />
  <style>
    table { border-collapse: collapse; width: 100%; margin-bottom: 30px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background: #007bff; color: white; }
    button { background-color: #dc3545; color: white; border: none; padding: 6px 12px; cursor: pointer; border-radius: 4px; }
    button:hover { background-color: #c82333; }
    form.add-model { max-width: 400px; margin-bottom: 40px; }
    form.add-model input[type="text"] { width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #ccc; }
    form.add-model button { background-color: #28a745; }
    form.add-model button:hover { background-color: #218838; }
  </style>
</head>
<body>
  <header>
    <h1>Admin Dashboard</h1>
    <nav>
      <a href="/bmw/index.php">Home</a>
      <a href="/bmw/auth/logout.php">Logout</a>
    </nav>
  </header>

  <main>
    <section>
      <h2>Car Models</h2>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($models as $model): ?>
          <tr>
            <td><?= htmlspecialchars($model['id']) ?></td>
            <td><?= htmlspecialchars($model['name']) ?></td>
            <td><?= htmlspecialchars($model['category'] ?? 'N/A') ?></td>
            <td>
              <form method="POST" action="delete_model.php" onsubmit="return confirm('Delete this model?');">
                <input type="hidden" name="model_id" value="<?= $model['id'] ?>">
                <button type="submit">Delete</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>

    <section>
      <h2>User Favorites</h2>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>User</th>
            <th>Model</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($favorites as $fav): ?>
          <tr>
            <td><?= htmlspecialchars($fav['fav_id']) ?></td>
            <td><?= htmlspecialchars($fav['user_name']) ?></td>
            <td><?= htmlspecialchars($fav['model_name']) ?></td>
            <td>
              <form method="POST" action="delete_favorite.php" onsubmit="return confirm('Delete this favorite?');">
                <input type="hidden" name="fav_id" value="<?= $fav['fav_id'] ?>">
                <button type="submit">Delete</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>

    <section>
      <h2>Add New Car Model</h2>
      <form method="POST" action="add_model.php" class="add-model">
        <label for="name">Model Name:</label><br>
        <input type="text" id="name" name="name" required><br>

        <label for="category">Category:</label><br>
        <input type="text" id="category" name="category" required><br>

        <button type="submit">Add Model</button>
      </form>
    </section>
  </main>
</body>
</html>
