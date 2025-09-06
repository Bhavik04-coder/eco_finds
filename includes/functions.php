<?php
// helper functions
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
function requireLogin() {
    if(!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}
function allowed_image($filename) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($ext, ['jpg','jpeg','png','webp','gif']);
}
function make_safe_filename($name) {
    $name = preg_replace('/[^A-Za-z0-9._-]/', '_', $name);
    return $name;
}

// Bind params helper for mysqli prepared statements (procedural)
function bind_params_array($stmt, $types, $params) {
    // mysqli_stmt_bind_param requires references
    $bind_names[] = $types;
    for ($i=0; $i<count($params); $i++) {
        $bind_name = 'bind' . $i;
        $$bind_name = $params[$i];
        $bind_names[] = &$$bind_name;
    }
    return call_user_func_array(array($stmt, 'bind_param'), $bind_names);
}
?>
