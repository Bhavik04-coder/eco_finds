<?php
require 'includes/config.php';
session_start();
if(!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$id = intval($_POST['id']);
$stmt = mysqli_prepare($conn, "DELETE FROM cart WHERE id = ? AND user_id = ?");
mysqli_stmt_bind_param($stmt, 'ii', $id, $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
header('Location: cart.php'); exit;
