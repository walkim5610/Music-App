<?php
include 'includes/db.php';
include 'includes/functions.php';

// Start session only if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $song_id = $_POST['song_id'];
    
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $stmt = $pdo->prepare("INSERT INTO playlists (user_id, song_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $song_id]);

        $message = "<div class='alert alert-success'>Song added to playlist successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>You must be logged in to add songs to the playlist.</div>";
    }
}

$stmt = $pdo->query("SELECT * FROM songs");
$songs = $stmt->fetchAll();

include 'includes/header.php';
?>
<style>
    /* Push content below the navbar */
    .playlist-container {
        max-width: 500px;
        margin: 80px auto 50px; /* Increased top margin to ensure visibility */
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .playlist-title {
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
        font-size: 26px;
    }

    .playlist-form .form-group {
        margin-bottom: 15px;
        text-align: left;
    }

    .form-control {
        border-radius: 5px;
        padding: 10px;
        width: 100%;
    }

    .playlist-btn {
        background-color: #007bff;
        border: none;
        padding: 10px;
        border-radius: 25px;
        font-size: 16px;
        transition: background 0.3s ease-in-out;
        width: 100%;
    }

    .playlist-btn:hover {
        background-color: #0056b3;
    }

    .alert {
        border-radius: 10px;
        padding: 10px;
        font-size: 14px;
        margin-bottom: 15px;
    }
</style>

<div class="playlist-container">
    <h1 class="playlist-title">Add to Playlist</h1>

    <?php if (isset($message)) echo $message; ?>

    <form method="POST" action="" class="playlist-form">
        <div class="form-group">
            <label for="song_id" class="form-label">Select Song</label>
            <select name="song_id" class="form-control" required>
                <?php foreach ($songs as $song): ?>
                    <option value="<?= htmlspecialchars($song['id']) ?>">
                        <?= htmlspecialchars($song['title']) ?> by <?= htmlspecialchars($song['artist']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary playlist-btn">Add to Playlist</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>

