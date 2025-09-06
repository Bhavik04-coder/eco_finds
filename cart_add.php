<?php
require 'includes/config.php';
session_start();
if(!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$pid = intval($_POST['product_id']);
$uid = $_SESSION['user_id'];

$sql = "SELECT id FROM cart WHERE user_id = ? AND product_id = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ii', $uid, $pid);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

if($res && mysqli_num_rows($res) > 0) {
    $stmt = mysqli_prepare($conn, "UPDATE cart SET qty = qty + 1 WHERE user_id = ? AND product_id = ?");
    mysqli_stmt_bind_param($stmt, 'ii', $uid, $pid);
    mysqli_stmt_execute($stmt);
} else {
    $stmt = mysqli_prepare($conn, "INSERT INTO cart (user_id, product_id, qty) VALUES (?, ?, 1)");
    mysqli_stmt_bind_param($stmt, 'ii', $uid, $pid);
    mysqli_stmt_execute($stmt);
}
header('Location: cart.php'); exit;
