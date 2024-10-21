<?php 
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Threadly</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Global Styles */
        body {
            font-family: "Hind", sans-serif;
            background-color: #f2f2f2;
            color: #333333;
            line-height: 1.6;
            transition: background-color 0.5s ease;
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1,
        h2 {
            color: #0B60B0;
        }

        p {
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            padding-left: 20px;
        }

        /* About Section Styles */
        .about-section {
            margin-top: 40px;
        }

        .about-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }

        .about-info {
            flex: 1;
            margin-right: 20px;
            transition: transform 0.3s ease; /* Transition effect for scaling */
        }

        .about-info:hover {
            transform: scale(1.02); /* Scale effect on hover */
        }

        .about-image {
            flex: 1;
            text-align: center;
        }

        .about-image img {
            max-width: 700px;
            height: 400px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease; /* Transition effect for scaling */
        }

        .about-image img:hover {
            transform: scale(1.05); /* Scale effect on hover */
        }

        .about-features {
            margin-top: 40px;
            display: flex;
            justify-content: space-between; /* Space evenly in row */
            flex-wrap: wrap; /* Wrap features on smaller screens */
        }

        .feature {
            text-align: center;
            transition: transform 0.3s ease; /* Transition effect for scaling */
            margin: 20px; /* Margin between features */
            flex: 1 1 calc(30% - 40px); /* 3 features in a row with margin */
            max-width: 300px; /* Maintain a consistent size */
        }

        .feature img {
            width: 100%;
            height: 200px; /* Set a fixed height */
            border-radius: 10px;
            transition: transform 0.3s ease; /* Transition effect for scaling */
        }

        .feature:hover img {
            transform: scale(1.1); /* Scale effect on hover */
        }

        .feature i {
            font-size: 48px;
            color: #0B60B0;
            margin-bottom: 10px;
        }

        .feature h3 {
            color: #0B60B0;
            margin-bottom: 10px;
        }

        .footer {
            background-color: #0B60B0; /* Background color */
            color: white; /* Text color */
            padding: 40px 0; /* Padding */
            position: relative; /* Positioning */
            bottom: 0; /* Stick to bottom */
            width: 100%; /* Full width */
        }

        .footer h5 {
            font-size: 20px; /* Header font size */
            margin-bottom: 20px; /* Margin below header */
        }

        .footer p {
            line-height: 1.5; /* Line height for text */
        }

        .footer ul {
            list-style-type: none; /* No bullet points */
            padding: 0; /* Remove padding */
        }

        .footer ul li {
            margin-bottom: 10px; /* Space between list items */
        }

        .footer ul li a {
            color: white; /* Link color */
            text-decoration: none; /* No underline */
            transition: color 0.3s ease; /* Transition effect */
        }

        .footer ul li a:hover {
            color: #ffe600; /* Highlight color on hover */
        }

        .footer .social-media {
            display: flex; /* Flexbox layout */
            gap: 10px; /* Space between icons */
        }

        .footer .social-media li {
            display: inline; /* Inline layout */
        }

        .footer .social-media i {
            margin-right: 5px; /* Space between icon and text */
        }

        @media (max-width: 768px) {
            .about-content {
                flex-direction: column; /* Stack elements on small screens */
                align-items: center; /* Center items */
            }

            .about-info {
                margin-right: 0; /* Remove margin on smaller screens */
                margin-bottom: 20px; /* Add bottom margin */
            }

            .about-image img {
                width: 100%; /* Responsive image */
                height: auto; /* Maintain aspect ratio */
            }

            .about-features {
                flex-direction: column; /* Stack features on smaller screens */
                align-items: center; /* Center align */
            }

            .feature {
                margin-bottom: 20px; /* Space between features */
            }

            .footer .row {
                flex-direction: column; /* Stack on small screens */
                align-items: center; /* Center items */
            }
        }
    </style>
</head>

<body>

<?php require 'partials/_navbar.php'; ?>

<div class="container">
    <div class="about-section">
        <div class="about-content">
            <div class="about-info">
                <h2>About Threadly:</h2>
                <p>Threadly is not just a forum platform; it's a vibrant community where passionate individuals come together to explore, learn, and share their knowledge on a wide range of topics. From technology and science to arts and literature, Threadly provides a platform for meaningful conversations and connections.</p>
                <p>Our mission is to foster an inclusive environment where everyone's voice is heard and respected. Whether you're a seasoned expert or a curious learner, Threadly welcomes you to join the discussion and be part of our growing community.</p>
                <p>At Threadly, we strive to:</p>
                <ul>
                    <li>Promote meaningful discussions on diverse topics.</li>
                    <li>Encourage collaboration and knowledge-sharing among members.</li>
                    <li>Provide a safe and inclusive space for all individuals.</li>
                    <li>Foster connections and build a strong community.</li>
                </ul>
                <p>Join us today and become a part of Threadly – where ideas flourish, friendships blossom, and knowledge grows.</p>
            </div>
            <div class="about-image">
                <img src="img/threadly.jpg" alt="Threadly Community">
            </div>
        </div>
    </div>

    <div class="about-features">
        <div class="feature">
            <img src="img/ed.jpg" alt="Engaging-Discussions">
            <h3>Engaging Discussions</h3>
            <p>Join conversations on a diverse range of topics and engage with fellow enthusiasts.</p>
        </div>
        <div class="feature">
            <img src="img/ci.jpg" alt="Community-Interaction">
            <h3>Community Interaction</h3>
            <p>Connect with like-minded individuals and build meaningful relationships.</p>
        </div>
        <div class="feature">
            <img src="img/knowledgesharing.jpg" alt="Knowledge Sharing">
            <h3>Knowledge Sharing</h3>
            <p>Share your expertise, learn from others, and expand your horizons.</p>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>About Threadly</h5>
                <p>Threadly is a vibrant community where passionate individuals explore, learn, and share knowledge on diverse topics. Join us to foster connections and build a strong community.</p>
            </div>
            <div class="col-md-4">
                <h5>Quick Links</h5>
                <ul>
                    <li><a href="/FP/index.php">Home</a></li>
                    <li><a href="/FP/about.php">About Us</a></li>
                    <li><a href="/FP/categories.php">Categories</a></li>
                    <li><a href="/FP/trending.php">Trending</a></li>
                    <li><a href="/FP/recent.php">Recent</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Connect with Us</h5>
                <ul class="social-media">
                    <li><a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                    <li><a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i> Twitter</a></li>
                    <li><a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
                    <li><a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i> LinkedIn</a></li>
                </ul>
            </div>
        </div>
        <div class="text-center">
            <p>&copy; 2024 Threadly. All rights reserved.</p>
        </div>
    </div>
</footer>

</body>

</html>
