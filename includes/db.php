<?php
$host = 'localhost';
$dbname = 'music_app';
$username = 'root';
$password = '';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=music_app', 'root', '');  // Adjust with your credentials
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

