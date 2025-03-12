
<?php 
include 'includes/db.php';

if (!isset($_GET['playlist_id'])) {
    echo json_encode([]);
    exit();
}

$playlist_id = intval($_GET['playlist_id']); // Convert to integer for safety

$stmt = $pdo->prepare("
    SELECT 
        songs.id AS song_id, 
        songs.title, 
        songs.artist, 
        songs.file_url  -- Ensure file_url is included
    FROM playlist_songs 
    JOIN songs ON playlist_songs.song_id = songs.id 
    WHERE playlist_songs.playlist_id = ?
");
$stmt->execute([$playlist_id]);

$songs = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($songs as &$song) {
    // Ensure a valid URL or correct local file path
    if (!empty($song['file_url'])) {
        if (!filter_var($song['file_url'], FILTER_VALIDATE_URL)) {
            // Assuming local files are stored in 'uploads/' directory
            $song['file_url'] = 'uploads/' . ltrim($song['file_url'], '/');
        }
    } else {
        $song['file_url'] = ''; // Prevent undefined errors
    }
}

header('Content-Type: application/json');
echo json_encode($songs);
?>
