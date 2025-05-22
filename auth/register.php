<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

  $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
  $stmt->execute([$name, $email, $password]);

  header("Location: login.php");
  exit;
}
?>

<?php include '../includes/header.php'; ?>
<h1>Register</h1>
<form method="POST" style="max-width:400px;margin:auto;">
  <input type="text" name="name" placeholder="Name" required><br><br>
  <input type="email" name="email" placeholder="Email" required><br><br>
  <input type="password" name="password" placeholder="Password" required><br><br>
  <button class="btn" type="submit">Register</button>
</form>
<?php include '../includes/footer.php'; ?>