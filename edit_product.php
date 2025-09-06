<?php require 'includes/header.php'; requireLogin(); ?>
<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM products WHERE id = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
if(!$res || mysqli_num_rows($res) == 0) { echo '<div class="alert alert-warning">Not found</div>'; require 'includes/footer.php'; exit; }
$p = mysqli_fetch_assoc($res);
if($p['user_id'] != $_SESSION['user_id']) { echo '<div class="alert alert-danger">Not allowed</div>'; require 'includes/footer.php'; exit; }

$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $category = trim($_POST['category']);
    $price = floatval($_POST['price']);
    $imgname = $p['image'];

    if(isset($_FILES['image']) && $_FILES['image']['name'] !== '') {
        if(!allowed_image($_FILES['image']['name'])) {
            $msg = 'Invalid image type';
        } elseif($_FILES['image']['size'] > 2 * 1024 * 1024) {
            $msg = 'Image too large (max 2MB)';
        } else {
            // remove old if exists
            if($imgname && file_exists('uploads/'.$imgname)) unlink('uploads/'.$imgname);
            $safe = make_safe_filename(basename($_FILES['image']['name']));
            $ext = pathinfo($safe, PATHINFO_EXTENSION);
            $imgname = time() . '_' . rand(100,999) . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $imgname);
        }
    }

    $sql = "UPDATE products SET title=?, description=?, category=?, price=?, image=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssdsi', $title, $desc, $category, $price, $imgname, $id);
    if(mysqli_stmt_execute($stmt)) {
        $msg = 'Updated';
        // reload product
        $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE id = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $p = mysqli_fetch_assoc($res);
    } else {
        $msg = 'Unable to update';
    }
}
?>
<div class="row">
  <div class="col-md-8">
    <h3>Edit Product</h3>
    <?php if($msg): ?><div class="alert alert-success"><?php echo esc($msg); ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3"><label>Product Title</label><input name="title" value="<?php echo esc($p['title']); ?>" class="form-control" required></div>
      <div class="mb-3"><label>Category</label><select name="category" class="form-control">
        <option<?php if($p['category']=='Electronics') echo ' selected'; ?>>Electronics</option><option<?php if($p['category']=='Furniture') echo ' selected'; ?>>Furniture</option><option<?php if($p['category']=='Clothing') echo ' selected'; ?>>Clothing</option><option<?php if($p['category']=='Books') echo ' selected'; ?>>Books</option><option<?php if($p['category']=='Other') echo ' selected'; ?>>Other</option>
      </select></div>
      <div class="mb-3"><label>Description</label><textarea name="description" class="form-control"><?php echo esc($p['description']); ?></textarea></div>
      <div class="mb-3"><label>Price (INR)</label><input type="number" step="0.01" name="price" value="<?php echo esc($p['price']); ?>" class="form-control" required></div>
      <div class="mb-3"><label>Image (optional)</label><input type="file" name="image" class="form-control"></div>
      <button class="btn btn-primary">Save</button>
    </form>
  </div>
</div>
<?php require 'includes/footer.php'; ?>
