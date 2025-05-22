<?php
session_start();
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
  header("Location: /bmw-project/index.php");
  exit;
}
?>

<?php include '../includes/header.php'; ?>
<h1 style="text-align:center;">Admin Dashboard</h1>
<p style="text-align:center;">You can add/edit/delete models here (future steps)</p>
<?php include '../includes/footer.php'; ?>