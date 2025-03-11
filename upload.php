<?php
include 'includes/db.php'; // Database connection
include 'includes/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Song</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- External CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .upload-container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .alert {
            border-radius: 10px;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="upload-container">
    <h1>Upload Song</h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $artist = $_POST['artist'];
        $file = $_FILES['song'];

        $uploadDir = 'assets/uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filePath = $uploadDir . basename($file['name']);

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            $stmt = $pdo->prepare("INSERT INTO songs (title, artist, file_path) VALUES (?, ?, ?)");
            $stmt->execute([$title, $artist, $filePath]);

            echo "<div class='alert alert-success'>Song uploaded successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Failed to upload song.</div>";
        }
    }
    ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Song Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="artist" class="form-label">Artist</label>
            <input type="text" name="artist" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="song" class="form-label">Song File</label>
            <input type="file" name="song" class="form-control" accept=".mp3,.wav" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
