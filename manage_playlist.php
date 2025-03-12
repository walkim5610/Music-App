<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Create a New Playlist
    if ($action === 'create' && isset($_POST['playlist_name'])) {
        $playlist_name = trim($_POST['playlist_name']);
        
        if (!empty($playlist_name)) {
            $stmt = $pdo->prepare("INSERT INTO user_playlists (user_id, name) VALUES (?, ?)");
            $stmt->execute([$user_id, $playlist_name]);

            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["error" => "Playlist name is required"]);
        }
    }

    // Add Song to Playlist
    elseif ($action === 'add_song' && isset($_POST['playlist_id'], $_POST['song_id'])) {
        $playlist_id = $_POST['playlist_id'];
        $song_id = $_POST['song_id'];

        $stmt = $pdo->prepare("INSERT INTO playlist_songs (playlist_id, song_id) VALUES (?, ?)");
        $stmt->execute([$playlist_id, $song_id]);

        echo json_encode(["success" => true]);
    }

    // Remove Song from Playlist
    elseif ($action === 'remove_song' && isset($_POST['playlist_id'], $_POST['song_id'])) {
        $playlist_id = $_POST['playlist_id'];
        $song_id = $_POST['song_id'];

        $stmt = $pdo->prepare("DELETE FROM playlist_songs WHERE playlist_id = ? AND song_id = ?");
        $stmt->execute([$playlist_id, $song_id]);

        echo json_encode(["success" => true]);
    }

    exit();
}
?>
