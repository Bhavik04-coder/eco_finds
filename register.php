<?php require 'includes/header.php'; ?>
<?php
if(isLoggedIn()) { header('Location: index.php'); exit; }
$err = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $pass = $_POST['password'] ?? '';
    if(strlen($pass) < 6) { $err = 'Password must be at least 6 characters'; }
    if(!$err) {
        // check email exists
        $sql = "SELECT id FROM users WHERE email = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($res && mysqli_num_rows($res) > 0) {
            $err = 'Email already used';
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username,email,password) VALUES (?,?,?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'sss', $username, $email, $hash);
            if(mysqli_stmt_execute($stmt)) {
                header('Location: login.php'); exit;
            } else {
                $err = 'Unable to create account';
            }
        }
    }
}
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <h3>Create account</h3>
    <?php if($err): ?><div class="alert alert-danger"><?php echo esc($err); ?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3"><label>Username</label><input type="text" name="username" class="form-control" required></div>
      <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
      <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
      <button class="btn btn-primary">Sign up</button>
      <a href="login.php" class="btn btn-link">Login</a>
    </form>
  </div>
</div>
<?php require 'includes/footer.php'; ?>
