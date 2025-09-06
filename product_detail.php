<?php require 'includes/header.php'; ?>
<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT p.*, u.username FROM products p LEFT JOIN users u ON p.user_id=u.id WHERE p.id = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
if(!$stmt) die('Prepare failed: ' . mysqli_error($conn));
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
if(!$res || mysqli_num_rows($res) == 0) { echo '<div class="alert alert-warning">Product not found</div>'; require 'includes/footer.php'; exit; }
$p = mysqli_fetch_assoc($res);
?>
<div class="row">
  <div class="col-md-6">
    <?php if($p['image'] && file_exists('uploads/'.$p['image'])): ?>
      <img src="uploads/<?php echo esc($p['image']); ?>" class="img-fluid">
    <?php else: ?>
      <div class="border p-5 text-center">Image Placeholder</div>
    <?php endif; ?>
  </div>
  <div class="col-md-6">
    <h2><?php echo esc($p['title']); ?></h2>
    <p class="text-muted">Category: <?php echo esc($p['category']); ?></p>
    <h3>₹ <?php echo number_format($p['price'],2); ?></h3>
    <p><?php echo nl2br(esc($p['description'])); ?></p>
    <p class="small text-muted">Seller: <?php echo esc($p['username']); ?></p>
    <div class="mt-3">
      <form method="post" action="cart_add.php">
        <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
        <button class="btn btn-success">Add to Cart</button>
      </form>
    </div>
  </div>
</div>
<?php require 'includes/footer.php'; ?>
