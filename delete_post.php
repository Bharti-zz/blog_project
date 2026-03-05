<?php
include 'db_connect.php';

$id = $_GET['id'];

$sql = "DELETE FROM posts WHERE id=?";
$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$id);
mysqli_stmt_execute($stmt);

header("Location:index.php");
?>