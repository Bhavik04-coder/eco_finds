<?php require 'includes/header.php'; requireLogin(); ?>
<?php
$uid = $_SESSION['user_id'];
$sql = "SELECT c.id AS cart_id, c.qty, p.id AS product_id, p.title, p.price, p.image FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $uid);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$total = 0;
?>
<h3>Your Cart</h3>
<?php if(mysqli_num_rows($res) == 0): ?>
  <div class="alert alert-info">Cart is empty</div>
<?php else: ?>
  <div class="row">
    <?php while($r = mysqli_fetch_assoc($res)): $subtotal = $r['qty'] * $r['price']; $total += $subtotal; ?>
      <div class="col-md-4 mb-3">
        <div class="card p-2 shadow-sm">
          <?php if($r['image'] && file_exists('uploads/'.$r['image'])): ?>
            <img src="uploads/<?php echo esc($r['image']); ?>" class="card-img-top">
          <?php else: ?>
            <div class="card-img-top">Image</div>
          <?php endif; ?>
          <div class="card-body">
            <h5><?php echo esc($r['title']); ?></h5>
            <p>₹ <?php echo number_format($r['price'],2); ?> x <?php echo $r['qty']; ?></p>
            <form method="post" action="cart_remove.php" class="d-inline">
              <input type="hidden" name="id" value="<?php echo $r['cart_id']; ?>">
              <button class="btn btn-sm btn-danger">Remove</button>
            </form>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
  <div class="d-flex justify-content-between align-items-center">
    <h4>Total: ₹ <?php echo number_format($total,2); ?></h4>
    <a href="checkout.php" class="btn btn-success">Checkout</a>
  </div>
<?php endif; ?>
<?php require 'includes/footer.php'; ?>
