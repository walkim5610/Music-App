<?php
include 'includes/db.php';
include 'includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Create a new playlist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['playlist_name'])) {
    $playlist_name = trim($_POST['playlist_name']);
    if (!empty($playlist_name)) {
        $stmt = $pdo->prepare("INSERT INTO user_playlists (user_id, name) VALUES (?, ?)");
        $stmt->execute([$user_id, $playlist_name]);
    }
}

// Add a song to a selected playlist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['playlist_id']) && isset($_POST['song_id'])) {
    $playlist_id = $_POST['playlist_id'];
    $song_id = $_POST['song_id'];

    $stmt = $pdo->prepare("INSERT INTO playlist_songs (playlist_id, song_id) VALUES (?, ?)");
    $stmt->execute([$playlist_id, $song_id]);
}

// Remove a song from a playlist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_song_id'])) {
    $remove_song_id = $_POST['remove_song_id'];
    $playlist_id = $_POST['playlist_id'];

    $stmt = $pdo->prepare("DELETE FROM playlist_songs WHERE playlist_id = ? AND song_id = ?");
    $stmt->execute([$playlist_id, $remove_song_id]);
}

// Fetch user playlists
$stmt = $pdo->prepare("SELECT * FROM user_playlists WHERE user_id = ?");
$stmt->execute([$user_id]);
$playlists = $stmt->fetchAll();

// Fetch all songs
$song_stmt = $pdo->query("SELECT * FROM songs");
$songs = $song_stmt->fetchAll();

include 'includes/header.php';
?>

<style>
    .playlist-container {
        max-width: 600px;
        margin: 50px auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .playlist-list {
        list-style: none;
        padding: 0;
    }

    .playlist-list li {
        background: #f8f9fa;
        padding: 10px;
        margin: 5px 0;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        font-weight: bold;
    }

    .playlist-list li:hover {
        background: #e2e6ea;
    }

    .playlist-form, .song-form {
        margin-bottom: 20px;
    }

    .remove-btn {
        background-color: #ff4444;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        color: white;
        cursor: pointer;
        font-size: 14px;
    }

    .remove-btn:hover {
        background-color: #cc0000;
    }

    .song-list {
        list-style: none;
        padding: 0;
    }

    .song-list li {
        background: #f0f0f0;
        padding: 10px;
        margin: 5px 0;
        border-radius: 5px;
        display: flex;
        justify-content: space-between;
    }
</style>

<div class="playlist-container">
    <h2>My Playlists</h2>
    <ul class="playlist-list">
        <?php foreach ($playlists as $playlist): ?>
            <li onclick="loadPlaylist(<?= $playlist['id'] ?>)"><?= htmlspecialchars($playlist['name']) ?></li>
        <?php endforeach; ?>
    </ul>

    <form method="POST" action="" class="playlist-form">
        <input type="text" name="playlist_name" placeholder="New Playlist Name" required>
        <button type="submit">Create Playlist</button>
    </form>

    <div id="playlist-details">
        <h3>Songs in Playlist</h3>
        <ul class="song-list" id="playlist-songs"></ul>
    </div>

    <form method="POST" action="" class="song-form">
        <h3>Add a Song to Playlist</h3>
        <select name="playlist_id" id="playlist-select" required>
            <option value="">Select Playlist</option>
            <?php foreach ($playlists as $playlist): ?>
                <option value="<?= $playlist['id'] ?>"><?= htmlspecialchars($playlist['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <select name="song_id" required>
            <?php foreach ($songs as $song): ?>
                <option value="<?= $song['id'] ?>">
                    <?= htmlspecialchars($song['title']) ?> by <?= htmlspecialchars($song['artist']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Add Song</button>
    </form>
</div>

<script>
    function loadPlaylist(playlistId) {
        fetch('get_playlist_songs.php?playlist_id=' + playlistId)
            .then(response => response.json())
            .then(data => {
                let songList = document.getElementById('playlist-songs');
                songList.innerHTML = '';

                if (data.length === 0) {
                    songList.innerHTML = '<li>No songs in this playlist.</li>';
                } else {
                    data.forEach(song => {
                        songList.innerHTML += `
                            <li>
                                ${song.title} by ${song.artist}
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="remove_song_id" value="${song.song_id}">
                                    <input type="hidden" name="playlist_id" value="${playlistId}">
                                    <button type="submit" class="remove-btn">Remove</button>
                                </form>
                            </li>
                        `;
                    });
                }
            });
    }
</script>

<?php include 'includes/footer.php'; ?>
