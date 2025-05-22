<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user['name'];
    $_SESSION['is_admin'] = $user['is_admin'];
    header("Location: /bmw/index.php");
    exit;
  } else {
    $error = "Invalid credentials";
  }
}
?>

<?php include '../includes/header.php'; ?>
<h1>Login</h1>
<form method="POST" style="max-width:400px;margin:auto;">
  <input type="email" name="email" placeholder="Email" required><br><br>
  <input type="password" name="password" placeholder="Password" required><br><br>
  <button type="submit">Login</button>
</form>
<?php if (isset($error)) echo "<p style='color:red;text-align:center;'>$error</p>"; ?>
<?php include '../includes/footer.php'; ?>