<?php
include 'db_connect.php';

$id = $_GET['id'];

if(isset($_POST['update'])){
$title = $_POST['title'];
$content = $_POST['content'];

$sql = "UPDATE posts SET title=?,content=? WHERE id=?";
$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"ssi",$title,$content,$id);
mysqli_stmt_execute($stmt);

header("Location:index.php");
}

$sql = "SELECT * FROM posts WHERE id=?";
$stmt = mysqli_prepare($conn,$sql);
mysqli_stmt_bind_param($stmt,"i",$id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Post</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

<h2>Edit Post</h2>

<form method="POST">

<div class="mb-3">
<label>Title</label>
<input type="text" name="title" class="form-control" value="<?= $row['title'] ?>">
</div>

<div class="mb-3">
<label>Content</label>
<textarea name="content" class="form-control"><?= $row['content'] ?></textarea>
</div>

<button type="submit" name="update" class="btn btn-primary">Update Post</button>

</form>

</div>

</body>
</html>