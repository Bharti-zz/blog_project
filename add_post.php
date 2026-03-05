<?php
include 'db_connect.php';

if(isset($_POST['submit'])){
$title = $_POST['title'];
$content = $_POST['content'];

$sql = "INSERT INTO posts(title,content) VALUES(?,?)";
$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"ss",$title,$content);
mysqli_stmt_execute($stmt);

header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Post</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

<h2>Add New Post</h2>

<form method="POST">

<div class="mb-3">
<label>Title</label>
<input type="text" name="title" class="form-control" required>
</div>

<div class="mb-3">
<label>Content</label>
<textarea name="content" class="form-control" required></textarea>
</div>

<button type="submit" name="submit" class="btn btn-success">Add Post</button>

</form>

</div>

</body>
</html>