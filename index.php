<?php
include 'db_connect.php';

$limit = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Blog Project</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-4">

<h2 class="text-center mb-4">My Blog Project</h2>

<!-- Add Post Button -->

<a href="add_post.php" class="btn btn-success mb-3">Add New Post</a>

<!-- Search Form -->

<form method="GET" class="mb-4">

<div class="input-group">

<input type="text" class="form-control" name="search" placeholder="Search by title or content"
value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">

<button class="btn btn-primary">Search</button>

</div>

</form>

<hr>

<div class="row">

<?php

if($search != ""){

$sql = "SELECT * FROM posts 
WHERE title LIKE ? OR content LIKE ? 
LIMIT ?, ?";

$stmt = mysqli_prepare($conn, $sql);

$search_param = "%".$search."%";

mysqli_stmt_bind_param($stmt,"ssii",$search_param,$search_param,$start,$limit);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$total_sql = "SELECT COUNT(*) as total FROM posts WHERE title LIKE ? OR content LIKE ?";
$total_stmt = mysqli_prepare($conn,$total_sql);

mysqli_stmt_bind_param($total_stmt,"ss",$search_param,$search_param);
mysqli_stmt_execute($total_stmt);

$total_result = mysqli_stmt_get_result($total_stmt);
$total_row = mysqli_fetch_assoc($total_result);

$total_posts = $total_row['total'];

}

else{

$sql = "SELECT * FROM posts LIMIT ?, ?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"ii",$start,$limit);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$total_query = mysqli_query($conn,"SELECT COUNT(*) as total FROM posts");
$total_row = mysqli_fetch_assoc($total_query);

$total_posts = $total_row['total'];

}

$total_pages = ceil($total_posts/$limit);

if(mysqli_num_rows($result)>0){

while($row = mysqli_fetch_assoc($result)){
?>

<div class="col-md-4 mb-3">

<div class="card h-100">

<div class="card-body">

<h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>

<p class="card-text"><?= htmlspecialchars($row['content']) ?></p>

<!-- Edit Delete Buttons -->

<a href="edit_post.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>

<a href="delete_post.php?id=<?= $row['id'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Are you sure you want to delete this post?')">
Delete
</a>

</div>

</div>

</div>

<?php
}

}else{

echo "<p>No posts found.</p>";

}
?>

</div>

<!-- Pagination -->

<?php if($total_pages>1): ?>

<nav>

<ul class="pagination justify-content-center mt-4">

<?php for($i=1;$i<=$total_pages;$i++): ?>

<li class="page-item <?= ($page==$i)?'active':'' ?>">

<a class="page-link"
href="?page=<?= $i ?><?= ($search!='')?'&search='.$search:'' ?>">
<?= $i ?>
</a>

</li>

<?php endfor; ?>

</ul>

</nav>

<?php endif; ?>

</div>

</body>
</html>