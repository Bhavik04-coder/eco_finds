<?php
require 'includes/config.php';
session_start();
if(!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$uid = $_SESSION['user_id'];
// Begin simple process: insert purchases for each cart item
$stmt = mysqli_prepare($conn, "SELECT product_id FROM cart WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $uid);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
while($r = mysqli_fetch_assoc($res)) {
    $stmt2 = mysqli_prepare($conn, "INSERT INTO purchases (user_id, product_id) VALUES (?,?)");
    mysqli_stmt_bind_param($stmt2, 'ii', $uid, $r['product_id']);
    mysqli_stmt_execute($stmt2);
}
// clear cart
$stmt = mysqli_prepare($conn, "DELETE FROM cart WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $uid);
mysqli_stmt_execute($stmt);
header('Location: previous_purchases.php'); exit;
