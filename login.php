<?php 
session_start();

include 'includes/functions.php';
include 'includes/header.php';

// Array of AI-generated music quotes
$musicQuotes = [
    "Music can change the world because it can change people. – Bono",
    "Where words fail, music speaks. – Hans Christian Andersen",
    "One good thing about music, when it hits you, you feel no pain. – Bob Marley",
    "Without music, life would be a mistake. – Friedrich Nietzsche",
    "Music is the universal language of mankind. – Henry Wadsworth Longfellow"
];

// Select a random quote
$quote = $musicQuotes[array_rand($musicQuotes)];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Hero Section with background image */
        .hero-section {
            background-image: url('assets/images/hero-bg.jpeg'); /* Replace with your actual image path */
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
        }

        
        .hero-section h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .hero-section p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .hero-section .btn {
            font-size: 1.1rem;
            padding: 0.8rem 2rem;
        }

        /* Trending Section Styles */
        .trending-section {
            background-color: #f9f9f9;
            padding: 40px 0;
            text-align: center;
        }

        .trending-section h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 30px;
        }

        .trending-section ul {
            list-style-type: none;
            padding: 0;
        }

        .trending-section ul li {
            font-size: 1.25rem;
            margin-bottom: 12px;
        }

        .trending-section ul li a {
            color: #1db954; /* Spotify Green */
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .trending-section ul li a:hover {
            color: #17a44c;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section text-center">
        <div class="container py-5">
            <h1>Welcome to the Music App</h1>
            <p>Explore, upload, and share your favorite songs with the world</p>
            <p id="quote"><?= $quote ?></p>
            <a href="play.php" class="btn btn-primary">Browse Songs</a>
        </div>
    </div>

    <!-- Trending Songs Section -->
    <div class="trending-section">
        <h2>🔥 Trending Songs</h2>
        <ul>
            <li><a href="#">Song 1 - Artist A</a></li>
            <li><a href="#">Song 2 - Artist B</a></li>
            <li><a href="#">Song 3 - Artist C</a></li>
            <li><a href="#">Song 4 - Artist D</a></li>
        </ul>
    </div>

    <script>
        // Function to refresh the quote every 5 seconds
        setInterval(function() {
            var quotes = [
                "Music can change the world because it can change people. – Bono",
                "Where words fail, music speaks. – Hans Christian Andersen",
                "One good thing about music, when it hits you, you feel no pain. – Bob Marley",
                "Without music, life would be a mistake. – Friedrich Nietzsche",
                "Music is the universal language of mankind. – Henry Wadsworth Longfellow"
            ];
            var randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
            document.getElementById('quote').innerText = randomQuote;
        }, 5000); // Refresh every 15 seconds
    </script>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
