<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Font Awesome CDN for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Make the body fill the whole viewport */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        /* Main content should take all available space */
        .content {
            flex: 1;
        }

        /* Footer remains at the bottom and stretches full width */
        footer {
            background: #111;
            color: #fff;
            padding: 40px 0;
            font-size: 14px;
            width: 100%;
        }

        footer h5 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        /* Footer Links */
        footer ul {
            padding: 0;
            list-style: none;
        }

        footer ul li {
            margin-bottom: 8px;
        }

        footer ul li a {
            color: #bbb;
            text-decoration: none;
            transition: 0.3s;
        }

        footer ul li a:hover {
            color: #1db954;
            text-decoration: underline;
        }

        /* Social Media Icons */
        footer .social-links a {
            font-size: 18px;
            display: inline-block;
            background: #222;
            color: white;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            border-radius: 50%;
            margin-right: 10px;
            transition: 0.3s;
        }

        footer .social-links a:hover {
            background: #1db954;
            color: #fff;
        }

        /* Newsletter Input */
        footer .input-group input {
            border-radius: 25px 0 0 25px;
            padding: 10px;
        }

        footer .input-group button {
            border-radius: 0 25px 25px 0;
            background: #1db954;
            color: white;
            border: none;
            transition: 0.3s;
        }

        footer .input-group button:hover {
            background: #17a44c;
        }

        /* Copyright Section */
        footer .border-top {
            border-color: rgba(255, 255, 255, 0.2) !important;
            padding-top: 15px;
            margin-top: 20px;
        }

        footer p {
            font-size: 13px;
            color: #bbb;
        }
    </style>
</head>

    <footer class="bg-dark text-white pt-5">
        <div class="container">
            <div class="row">
                <!-- Quick Links -->
                <div class="col-md-3 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white text-decoration-none">Home</a></li>
                        <li><a href="play.php" class="text-white text-decoration-none">Browse Songs</a></li>
                        <li><a href="upload.php" class="text-white text-decoration-none">Upload</a></li>
                        <li><a href="playlist.php" class="text-white text-decoration-none">My Playlist</a></li>
                        <li><a href="login.php" class="text-white text-decoration-none">Login</a></li>
                        <li><a href="register.php" class="text-white text-decoration-none">Register</a></li>
                    </ul>
                </div>

                <!-- Social Media -->
                <div class="col-md-3 mb-4">
                    <h5>Connect With Us</h5>
                    <div class="social-links">
                        <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="col-md-3 mb-4">
                    <h5>Newsletter</h5>
                    <form id="newsletterForm">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Enter your email" required>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-envelope"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="col-md-3 mb-4">
                    <h5>Contact Us</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-map-marker-alt me-2"></i> Nairobi, Kenya</li>
                        <li><i class="fas fa-phone me-2"></i> +254 707 816 510</li>
                        <li><i class="fas fa-envelope me-2"></i> info@musicapp.com</li>
                    </ul>
                </div>
            </div>

            <div class="border-top pt-3 mt-4 text-center">
                <p>&copy; 2025 Music App. All rights reserved. | Developed by Walter Kim</p>
            </div>
        </div>
    </footer
