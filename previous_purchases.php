<?php require 'includes/header.php'; requireLogin(); ?>
<?php
$uid = $_SESSION['user_id'];
$sql = "SELECT pr.*, p.title, p.price, p.image, pr.purchase_at FROM purchases pr JOIN products p ON pr.product_id = p.id WHERE pr.user_id = ? ORDER BY pr.purchase_at DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $uid);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
?>
<h3>Previous Purchases</h3>
<?php if(mysqli_num_rows($res) == 0): ?>
  <div class="alert alert-info">No purchases yet</div>
<?php else: ?>
  <div class="row">
    <?php while($r = mysqli_fetch_assoc($res)): ?>
      <div class="col-md-4 mb-3">
        <div class="card shadow-sm">
          <?php if($r['image'] && file_exists('uploads/'.$r['image'])): ?>
            <img src="uploads/<?php echo esc($r['image']); ?>" class="card-img-top">
          <?php else: ?>
            <div class="card-img-top">Image</div>
          <?php endif; ?>
          <div class="card-body">
            <h5><?php echo esc($r['title']); ?></h5>
            <p>₹ <?php echo number_format($r['price'],2); ?></p>
            <small class="text-muted">Purchased at <?php echo $r['purchase_at']; ?></small>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
<?php endif; ?>
<?php require 'includes/footer.php'; ?>
