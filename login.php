<?php require 'includes/header.php'; ?>
<?php
if(isLoggedIn()) { header('Location: index.php'); exit; }
$err = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pass = $_POST['password'] ?? '';
    $sql = "SELECT id, password FROM users WHERE email = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    if(!$stmt) die('Prepare failed: ' . mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if($res && mysqli_num_rows($res) === 1) {
        $u = mysqli_fetch_assoc($res);
        if(password_verify($pass, $u['password'])) {
            $_SESSION['user_id'] = $u['id'];
            header('Location: index.php'); exit;
        } else {
            $err = 'Invalid credentials';
        }
    } else {
        $err = 'Invalid credentials';
    }
}
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <h3>Login</h3>
    <?php if($err): ?><div class="alert alert-danger"><?php echo esc($err); ?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
      <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
      <button class="btn btn-primary">Login</button>
      <a href="register.php" class="btn btn-link">Sign up</a>
    </form>
  </div>
</div>
<?php require 'includes/footer.php'; ?>
