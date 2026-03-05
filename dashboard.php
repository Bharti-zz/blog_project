<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

    <!-- Logout Button -->
    <a href="logout.php" class="btn btn-danger mt-3">Logout</a>

    <!-- Blog Project Link Button -->
    <a href="index.php" class="btn btn-success mt-3 ms-2">Go to Blog Project</a>
</div>
</body>
</html>