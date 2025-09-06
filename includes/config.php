<?php
// config.php - DB connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecofinds_db";

// Connect with selected DB (avoid separate CREATE DB here; import SQL instead)
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

function esc($s) {
    return htmlspecialchars(trim($s), ENT_QUOTES, 'UTF-8');
}
?>
