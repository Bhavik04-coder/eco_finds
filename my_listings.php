<?php require 'includes/header.php'; requireLogin(); ?>
<?php
$uid = $_SESSION['user_id'];
$sql = "SELECT * FROM products WHERE user_id = ? ORDER BY created_at DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $uid);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
?>
<h3>My Listings</h3>
<a href="add_product.php" class="btn btn-success mb-3">+ Add New</a>
<div class="row">
<?php while($r = mysqli_fetch_assoc($res)): ?>
  <div class="col-md-4 mb-3">
    <div class="card shadow-sm">
      <?php if($r['image'] && file_exists('uploads/'.$r['image'])): ?>
        <img src="uploads/<?php echo esc($r['image']); ?>" class="card-img-top">
      <?php else: ?>
        <div class="card-img-top">Image Placeholder</div>
      <?php endif; ?>
      <div class="card-body">
        <h5><?php echo esc($r['title']); ?></h5>
        <p>₹ <?php echo number_format($r['price'],2); ?></p>
        <a href="edit_product.php?id=<?php echo $r['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
        <a href="delete_product.php?id=<?php echo $r['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
      </div>
    </div>
  </div>
<?php endwhile; ?>
</div>
<?php require 'includes/footer.php'; ?>
