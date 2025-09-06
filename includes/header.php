<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EcoFinds</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="assets/images/logo.svg" alt="EcoFinds" style="height:48px; margin-right:10px;">
      <span class="d-none d-md-inline">Sustainable second-hand marketplace</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <form class="d-flex ms-auto me-3" action="index.php" method="get">
        <input class="form-control me-2" type="search" placeholder="Search title..." name="q" value="<?php echo isset($_GET['q'])?esc($_GET['q']):'';?>">
        <select class="form-select me-2" name="category">
          <option value="">All</option>
          <option<?php if(isset($_GET['category']) && $_GET['category']=='Electronics') echo ' selected'; ?>>Electronics</option>
          <option<?php if(isset($_GET['category']) && $_GET['category']=='Furniture') echo ' selected'; ?>>Furniture</option>
          <option<?php if(isset($_GET['category']) && $_GET['category']=='Clothing') echo ' selected'; ?>>Clothing</option>
          <option<?php if(isset($_GET['category']) && $_GET['category']=='Books') echo ' selected'; ?>>Books</option>
          <option<?php if(isset($_GET['category']) && $_GET['category']=='Other') echo ' selected'; ?>>Other</option>
        </select>
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      <ul class="navbar-nav mb-2 mb-lg-0">
        <?php if(isLoggedIn()): ?>
          <li class="nav-item"><a class="nav-link" href="my_listings.php">My Listings</a></li>
          <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="btn btn-sm btn-outline-danger nav-link" href="logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <li class="nav-item"><a class="btn btn-sm btn-primary nav-link text-white" href="register.php">Sign up</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container my-4">
