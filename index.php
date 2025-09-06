<?php require 'includes/header.php'; ?>
<?php
// Search and category handling with prepared statements
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$cat = isset($_GET['category']) ? trim($_GET['category']) : '';

$sql = "SELECT p.*, u.username FROM products p LEFT JOIN users u ON p.user_id=u.id WHERE 1=1";
$params = [];
$types = '';

if($q !== '') {
    $sql .= " AND p.title LIKE ?";
    $params[] = '%' . $q . '%';
    $types .= 's';
}
if($cat !== '') {
    $sql .= " AND p.category = ?";
    $params[] = $cat;
    $types .= 's';
}
$sql .= " ORDER BY p.created_at DESC LIMIT 100";

$stmt = mysqli_prepare($conn, $sql);
if($stmt === false) {
    die('DB prepare failed: ' . mysqli_error($conn));
}
if(count($params) > 0) {
    // bind params using helper
    bind_params_array($stmt, $types, $params);
}
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
if($res === false) {
    die('Query failed: ' . mysqli_error($conn));
}
?>
<div class="hero d-flex justify-content-between align-items-center">
  <div>
    <h1 class="mb-1">Find pre-loved treasures</h1>
    <p class="mb-0 text-muted">Buy and sell second-hand items. Sustainable, affordable, local.</p>
  </div>
  <div>
    <?php if(isLoggedIn()): ?>
      <a href="add_product.php" class="btn btn-primary btn-lg">+ Add Product</a>
    <?php else: ?>
      <a href="login.php" class="btn btn-outline-primary">Login / Sign up to sell</a>
    <?php endif; ?>
  </div>
</div>

<div class="row mt-4">
<?php while($row = mysqli_fetch_assoc($res)): ?>
  <div class="col-md-4 mb-4">
    <div class="card h-100 shadow-sm">
      <?php if($row['image'] && file_exists('uploads/'.$row['image'])): ?>
        <img src="uploads/<?php echo esc($row['image']); ?>" class="card-img-top" alt="<?php echo esc($row['title']); ?>">
      <?php else: ?>
        <div class="card-img-top">Image Placeholder</div>
      <?php endif; ?>
      <div class="card-body d-flex flex-column">
        <h5 class="card-title"><?php echo esc($row['title']); ?></h5>
        <p class="card-text mb-1"><strong>₹ <?php echo number_format($row['price'],2); ?></strong></p>
        <p class="text-muted small mb-2">Category: <?php echo esc($row['category']); ?></p>
        <div class="mt-auto d-flex justify-content-between">
          <a href="product_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">View</a>
          <form method="post" action="cart_add.php" class="d-inline">
            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
            <button class="btn btn-sm btn-success">Add to Cart</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php endwhile; ?>
</div>

<?php require 'includes/footer.php'; ?>
