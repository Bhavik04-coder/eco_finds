<?php require 'includes/header.php'; requireLogin(); ?>
<?php
$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $category = trim($_POST['category']);
    $price = floatval($_POST['price']);
    $imgname = null;

    // handle upload
    if(isset($_FILES['image']) && $_FILES['image']['name'] !== '') {
        if(!allowed_image($_FILES['image']['name'])) {
            $msg = 'Invalid image type';
        } elseif($_FILES['image']['size'] > 2 * 1024 * 1024) {
            $msg = 'Image too large (max 2MB)';
        } else {
            $safe = make_safe_filename(basename($_FILES['image']['name']));
            $ext = pathinfo($safe, PATHINFO_EXTENSION);
            $imgname = time() . '_' . rand(100,999) . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $imgname);
        }
    }

    if(!$msg) {
        $sql = "INSERT INTO products (title,description,category,price,image,user_id) VALUES (?,?,?,?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        $uid = $_SESSION['user_id'];
        $desc_s = (string)$desc;
$price_s = (string)$price;
$img_s = (string)$imgname;
$uid_s = (string)$uid;
mysqli_stmt_bind_param($stmt, 'ssssss', $title, $desc_s, $category, $price_s, $img_s, $uid_s);
        // Note: 'd' used for price (double) and 'i' for user id, but bind types must match order - we'll use workaround below
        // Use simple execute with types 'ssdiss' -> but to avoid complexity, we'll build correct param binding:
        mysqli_stmt_close($stmt); // close and reprepare with proper types below

        $sql = "INSERT INTO products (title,description,category,price,image,user_id) VALUES (?,?,?,?,?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        if(!$stmt) { die('Prepare failed: ' . mysqli_error($conn)); }
        $desc_s = (string)$desc;
$price_s = (string)$price;
$img_s = (string)$imgname;
$uid_s = (string)$uid;
mysqli_stmt_bind_param($stmt, 'ssssss', $title, $desc_s, $category, $price_s, $img_s, $uid_s);
        if(mysqli_stmt_execute($stmt)) {
            $msg = 'Listing added';
        } else {
            $msg = 'Unable to add listing';
        }
    }
}
?>
<div class="row justify-content-center">
  <div class="col-md-8">
    <h3>Add New Product</h3>
    <?php if($msg): ?><div class="alert alert-info"><?php echo esc($msg); ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3"><label>Product Title</label><input name="title" class="form-control" required></div>
      <div class="mb-3"><label>Category</label><select name="category" class="form-control">
        <option>Electronics</option><option>Furniture</option><option>Clothing</option><option>Books</option><option>Other</option>
      </select></div>
      <div class="mb-3"><label>Description</label><textarea name="description" class="form-control"></textarea></div>
      <div class="mb-3"><label>Price (INR)</label><input type="number" step="0.01" name="price" class="form-control" required></div>
      <div class="mb-3"><label>Image (optional, max 2MB)</label><input type="file" name="image" class="form-control"></div>
      <button class="btn btn-primary">Submit Listing</button>
    </form>
  </div>
</div>
<?php require 'includes/footer.php'; ?>
