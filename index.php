<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Blog Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4 text-center">My Blog Project</h2>

    <!-- Bootstrap Search Form -->
    <form method="GET" action="" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search by title or content" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <hr>

<?php
$limit = 3;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search Query
if(isset($_GET['search']) && $_GET['search'] != ''){
    $search = $_GET['search'];
    $sql = "SELECT * FROM posts 
            WHERE title LIKE '%$search%' 
            OR content LIKE '%$search%' 
            LIMIT $start, $limit";

    $total_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM posts 
                                        WHERE title LIKE '%$search%' 
                                        OR content LIKE '%$search%'");
} else {
    $sql = "SELECT * FROM posts LIMIT $start, $limit";
    $total_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM posts");
}

$result = mysqli_query($conn, $sql);
$total_result = mysqli_fetch_assoc($total_query);
$total_posts = $total_result['total'];
$total_pages = ceil($total_posts / $limit);
?>

<!-- Posts in Bootstrap Cards -->
<div class="row">
<?php
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        ?>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['title'] ?></h5>
                    <p class="card-text"><?= $row['content'] ?></p>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo "<p>No posts found.</p>";
}
?>
</div>

<!-- Bootstrap Pagination -->
<nav>
    <ul class="pagination justify-content-center mt-4">
        <?php for($i=1; $i<=$total_pages; $i++): ?>
            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?><?= isset($search) ? '&search='.$search : '' ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

</div> <!-- End container -->
</body>
</html>