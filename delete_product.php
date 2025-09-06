<?php require 'includes/header.php'; requireLogin(); ?>
<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM products WHERE id = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
if($res && mysqli_num_rows($res)) {
    $p = mysqli_fetch_assoc($res);
    if($p['user_id'] == $_SESSION['user_id']) {
        if($p['image'] && file_exists('uploads/'.$p['image'])) unlink('uploads/'.$p['image']);
        $stmt = mysqli_prepare($conn, "DELETE FROM products WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
    }
}
header('Location: my_listings.php'); exit;
