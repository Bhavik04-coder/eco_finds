<?php require 'includes/header.php'; requireLogin(); ?>
<?php
$uid = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $uid);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$u = mysqli_fetch_assoc($res);
$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $imgname = $u['profile_img'];

    if(isset($_FILES['profile_img']) && $_FILES['profile_img']['name'] !== '') {
        if(!allowed_image($_FILES['profile_img']['name'])) {
            $msg = 'Invalid image type';
        } elseif($_FILES['profile_img']['size'] > 2 * 1024 * 1024) {
            $msg = 'Image too large (max 2MB)';
        } else {
            if($imgname && file_exists('uploads/'.$imgname)) unlink('uploads/'.$imgname);
            $safe = make_safe_filename(basename($_FILES['profile_img']['name']));
            $ext = pathinfo($safe, PATHINFO_EXTENSION);
            $imgname = 'pf_' . time() . '_' . rand(10,99) . '.' . $ext;
            move_uploaded_file($_FILES['profile_img']['tmp_name'], 'uploads/' . $imgname);
        }
    }

    if(!$msg) {
        $sql = "UPDATE users SET username = ?, profile_img = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ssi', $username, $imgname, $uid);
        if(mysqli_stmt_execute($stmt)) {
            $msg = 'Saved';
            // reload
            $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ? LIMIT 1");
            mysqli_stmt_bind_param($stmt, 'i', $uid);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            $u = mysqli_fetch_assoc($res);
        } else {
            $msg = 'Unable to save';
        }
    }
}
?>
<h3>Profile</h3>
<?php if($msg): ?><div class="alert alert-success"><?php echo esc($msg); ?></div><?php endif; ?>
<div class="row">
  <div class="col-md-4">
    <?php if($u['profile_img'] && file_exists('uploads/'.$u['profile_img'])): ?>
      <img src="uploads/<?php echo esc($u['profile_img']); ?>" class="img-fluid rounded">
    <?php else: ?>
      <div class="border p-5 text-center">No image</div>
    <?php endif; ?>
  </div>
  <div class="col-md-8">
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3"><label>Username</label><input name="username" value="<?php echo esc($u['username']); ?>" class="form-control"></div>
      <div class="mb-3"><label>Profile Image</label><input type="file" name="profile_img" class="form-control"></div>
      <button class="btn btn-primary">Save</button>
    </form>
  </div>
</div>
<?php require 'includes/footer.php'; ?>
