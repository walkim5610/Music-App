<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Prevent function redeclaration
if (!function_exists('isLoggedIn')) {
    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}

if (!function_exists('redirect')) {
    function redirect($url) {
        if (!headers_sent()) {
            header("Location: $url");
            exit();
        } else {
            echo "<script>window.location.href='$url';</script>";
            exit();
        }
    }
}
?>
