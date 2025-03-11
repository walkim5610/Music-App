<?php
include 'includes/db.php';
include 'includes/functions.php';
include 'includes/header.php';

$stmt = $pdo->query("SELECT * FROM songs");
$songs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Player</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .music-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .favorite-btn {
            background: #ffc107;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .favorite-btn.active {
            background: #ff5722;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Music Player</h1>
    
    <div class="music-container">
        <audio id="audioPlayer" controls class="w-100">
            <source id="audioSource" src="" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
        
        <div class="controls mt-3">
            <label>Volume:</label>
            <input type="range" id="volumeControl" class="form-range" min="0" max="1" step="0.1">
        </div>

        <h4 class="mt-4">Songs</h4>
        <ul class="list-group" id="songList">
            <?php foreach ($songs as $song): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><strong><?= $song['title'] ?></strong> - <?= $song['artist'] ?></span>
                    <button class="play-btn btn btn-primary btn-sm" data-src="<?= $song['file_path'] ?>">
                        <i class="fas fa-play"></i> Play
                    </button>
                    <button class="favorite-btn btn btn-sm" data-id="<?= $song['id'] ?>">
                        <i class="fas fa-heart"></i> Favorite
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const audioPlayer = document.getElementById("audioPlayer");
        const audioSource = document.getElementById("audioSource");
        const volumeControl = document.getElementById("volumeControl");
        const playButtons = document.querySelectorAll(".play-btn");
        const favoriteButtons = document.querySelectorAll(".favorite-btn");

        // Load last played song
        const lastPlayed = localStorage.getItem("lastPlayedSong");
        if (lastPlayed) {
            audioSource.src = lastPlayed;
            audioPlayer.load();
        }

        // Load volume settings
        const savedVolume = localStorage.getItem("audioVolume") || 0.5;
        audioPlayer.volume = savedVolume;
        volumeControl.value = savedVolume;

        // Save volume changes
        volumeControl.addEventListener("input", function () {
            localStorage.setItem("audioVolume", volumeControl.value);
            audioPlayer.volume = volumeControl.value;
        });

        // Play selected song
        playButtons.forEach(button => {
            button.addEventListener("click", function () {
                const songSrc = this.getAttribute("data-src");
                audioSource.src = songSrc;
                audioPlayer.load();
                audioPlayer.play();
                localStorage.setItem("lastPlayedSong", songSrc);
            });
        });

        // Manage favorite songs
        let favoriteSongs = JSON.parse(localStorage.getItem("favoriteSongs")) || [];

        favoriteButtons.forEach(button => {
            const songId = button.getAttribute("data-id");

            // Check if song is already in favorites
            if (favoriteSongs.includes(songId)) {
                button.classList.add("active");
                button.innerHTML = '<i class="fas fa-heart"></i> Unfavorite';
            }

            button.addEventListener("click", function () {
                if (favoriteSongs.includes(songId)) {
                    favoriteSongs = favoriteSongs.filter(id => id !== songId);
                    button.classList.remove("active");
                    button.innerHTML = '<i class="fas fa-heart"></i> Favorite';
                } else {
                    favoriteSongs.push(songId);
                    button.classList.add("active");
                    button.innerHTML = '<i class="fas fa-heart"></i> Unfavorite';
                }

                localStorage.setItem("favoriteSongs", JSON.stringify(favoriteSongs));
            });
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>
