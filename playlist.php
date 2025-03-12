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

// Fetch all playlists for the user
$stmt = $pdo->prepare("SELECT * FROM user_playlists WHERE user_id = ?");
$stmt->execute([$user_id]);
$playlists = $stmt->fetchAll();

// Fetch all songs
$song_stmt = $pdo->query("SELECT * FROM songs");
$songs = $song_stmt->fetchAll();

include 'includes/header.php';
?>
<style>
/* Container and Layout */
.container {
    max-width: 900px;
    margin: 20px auto;
}

/* Playlist and Song Display */
.playlist-container {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.playlist-list, .song-list {
    list-style: none;
    padding: 0;
}

.playlist-list li, .song-list li {
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

.song-list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f0f0f0;
}

/* Forms and Buttons */
.form-group {
    margin-bottom: 15px;
}

.form-group input, 
.form-group select, 
.form-group button {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.form-group button {
    background-color: #007bff;
    color: white;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: background 0.3s;
}

.form-group button:hover {
    background-color: #0056b3;
}

/* Remove Button */
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

/* Music Player */
#music-player {
    text-align: center;
    margin-top: 20px;
}

/* Responsive Design */
@media (max-width: 600px) {
    .container {
        width: 90%;
    }
}
</style>

<div class="container">
    <div class="row">
        <!-- Left Side: Create Playlists -->
        <div class="col-md-4">
            <div class="playlist-container">
                <h3>Create Playlist</h3>
                <form id="create-playlist-form" class="form-group">
                    <input type="text" id="playlist_name" placeholder="New Playlist Name" required>
                    <button type="submit">Create</button>
                </form>

                <h4>Your Playlists</h4>
                <ul class="playlist-list" id="playlist-list">
                    <?php foreach ($playlists as $playlist): ?>
                        <li onclick="loadPlaylist(<?= $playlist['id'] ?>)">
                            <?= htmlspecialchars($playlist['name']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Middle: Music Player -->
        <div class="col-md-4">
            <div id="music-player">
                <h3>Now Playing</h3>
                <p id="current-song">Select a song to play</p>
                <audio id="audio-player" controls></audio>
                <div>
                    <button onclick="prevSong()">⏮ Prev</button>
                    <button onclick="togglePlay()">⏯ Play/Pause</button>
                    <button onclick="nextSong()">⏭ Next</button>
                </div>
            </div>
        </div>

        <!-- Right Side: Display Playlist Songs -->
        <div class="col-md-4">
            <div class="playlist-container">
                <h3>Playlist Songs</h3>
                <ul class="song-list" id="playlist-songs">
                    <li class="text-muted">Select a playlist to view songs.</li>
                </ul>

                <!-- Add Songs to Playlist -->
                <div id="add-song-section" class="mt-4">
                    <h4>Add Song to Playlist</h4>
                    <form id="add-song-form" class="form-group">
                        <select id="playlist-select" required>
                            <option value="">Select Playlist</option>
                            <?php foreach ($playlists as $playlist): ?>
                                <option value="<?= $playlist['id'] ?>"><?= htmlspecialchars($playlist['name']) ?></option>
                            <?php endforeach; ?>
                        </select>

                        <select id="song-select" required>
                            <option value="">Select Song</option>
                            <?php foreach ($songs as $song): ?>
                                <option value="<?= $song['id'] ?>">
                                    <?= htmlspecialchars($song['title']) ?> by <?= htmlspecialchars($song['artist']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <button type="submit">Add Song</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const audioPlayer = document.getElementById('audio-player');
    const currentSongTitle = document.getElementById('current-song');
    let currentPlaylist = [];
    let currentSongIndex = 0;

    // Load playlists when the page loads
    function loadPlaylists() {
        fetch('get_playlists.php')
            .then(response => response.json())
            .then(data => {
                console.log("Playlists:", data); // Debugging
                let playlistList = document.getElementById('playlist-list');
                playlistList.innerHTML = '';

                if (data.length === 0) {
                    playlistList.innerHTML = '<li class="text-muted">No playlists available.</li>';
                } else {
                    data.forEach(playlist => {
                        let listItem = document.createElement('li');
                        listItem.textContent = playlist.name;
                        listItem.dataset.playlistId = playlist.id;

                        // Clicking a playlist loads its songs
                        listItem.addEventListener('click', function () {
                            loadPlaylist(playlist.id);
                        });

                        playlistList.appendChild(listItem);
                    });
                }
            })
            .catch(error => console.error("Error loading playlists:", error));
    }

    // Load songs from selected playlist
    function loadPlaylist(playlistId) {
        fetch('get_playlist_songs.php?playlist_id=' + playlistId)
            .then(response => response.json())
            .then(data => {
                console.log("Playlist Songs:", data); // Debugging
                let songList = document.getElementById('playlist-songs');
                songList.innerHTML = '';

                currentPlaylist = data; // Store songs in playlist
                currentSongIndex = 0; // Reset song index

                if (data.length === 0) {
                    songList.innerHTML = '<li class="text-muted">No songs in this playlist.</li>';
                } else {
                    data.forEach((song, index) => {
                        let listItem = document.createElement('li');
                        listItem.innerHTML = `${song.title} by ${song.artist} 
                            <button class="remove-btn" onclick="removeSong(${playlistId}, ${song.song_id})">Remove</button>`;
                        
                        // Clicking a song will play it
                        listItem.addEventListener('click', function () {
                            playSong(index);
                        });

                        songList.appendChild(listItem);
                    });
                }
            })
            .catch(error => console.error("Error loading playlist:", error));
    }

    // Play a song by its index in the playlist
    function playSong(index) {
        if (currentPlaylist.length === 0) {
            alert("No songs in playlist!");
            return;
        }

        if (index >= currentPlaylist.length) {
            index = 0; // Loop back to the first song
        } else if (index < 0) {
            index = currentPlaylist.length - 1; // Go to the last song
        }

        currentSongIndex = index;
        const song = currentPlaylist[currentSongIndex];

        if (!song.file_url) {
            alert("Song URL is missing!");
            return;
        }

        currentSongTitle.textContent = `Now Playing: ${song.title} by ${song.artist}`;
        audioPlayer.src = song.file_url;
        audioPlayer.play().catch(error => console.error("Playback error:", error));
    }

    // Play next song automatically when current song ends
    audioPlayer.addEventListener('ended', function () {
        playSong(currentSongIndex + 1);
    });

    // Controls for next and previous song
    window.nextSong = function () {
        playSong(currentSongIndex + 1);
    };

    window.prevSong = function () {
        playSong(currentSongIndex - 1);
    };

    window.togglePlay = function () {
        if (audioPlayer.paused) {
            audioPlayer.play();
        } else {
            audioPlayer.pause();
        }
    };

    // Add song to playlist
    document.getElementById('add-song-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const playlistId = document.getElementById('playlist-select').value;
        const songId = document.getElementById('song-select').value;

        if (!playlistId || !songId) {
            alert("Please select a playlist and a song.");
            return;
        }

        fetch('manage_playlist.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=add_song&playlist_id=${playlistId}&song_id=${songId}`
        })
        .then(response => response.json())
        .then(() => {
            alert("Song added successfully!");
            loadPlaylist(playlistId);
        })
        .catch(() => alert("Failed to add song. Try again!"));
    });

    // Remove song from playlist
    window.removeSong = function (playlistId, songId) {
        fetch('manage_playlist.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=remove_song&playlist_id=${playlistId}&song_id=${songId}`
        })
        .then(() => {
            alert("Song removed successfully!");
            loadPlaylist(playlistId);
        })
        .catch(() => alert("Failed to remove song. Try again!"));
    };

    // Load playlists on page load
    loadPlaylists();
});

</script>

<?php include 'includes/footer.php'; ?>
