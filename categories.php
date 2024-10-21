<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/categories.css">

    <title>Threadly - Top Categories</title>
    
    <style>
        body {
            background-color: #f7f9fc; /* Light background for contrast */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #212529;
            margin: 0;
            padding: 0;
        }

        .top-category-container {
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 2.5rem;
            color: #333;
        }

        .category-card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .category-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 300px;
            text-align: left;
            position: relative;
        }

        .category-card:hover {
            transform: translateY(-5px); /* Lift effect on hover */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Deeper shadow on hover */
        }

        .category-card img {
            width: 100%;
            height: 200px; /* Fixed height for images */
            object-fit: cover; /* Maintain aspect ratio */
            transition: opacity 0.3s ease; /* Transition for image */
        }

        .category-card-info {
            padding: 15px;
        }

        .category-card-info h2 {
            margin: 10px 0;
            font-size: 1.5rem;
        }

        .category-card-info p {
            font-size: 1rem;
            color: #555;
        }

        .view-threads-btn {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 10px;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease; /* Button transitions */
        }

        .view-threads-btn:hover {
            background-color: #0056b3; /* Darker shade on hover */
            transform: scale(1.05); /* Slightly increase size on hover */
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
         @media (max-width: 768px){
            .footer .row {
                flex-direction: column; /* Stack on small screens */
                align-items: center; /* Center items */
            }
         }

</style>

</head>

<body>
    <?php require 'partials/_navbar.php'; ?>

    <div class="top-category-container">
        <h1>All Categories</h1>
        <div class="category-card-container">
            <?php 
                require 'partials/_dbconnect.php';
                $sql = "SELECT * FROM `categories`";
                $result = mysqli_query($conn, $sql);
                $totalRows = mysqli_num_rows($result);
                if($totalRows > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        // Generate a random image based on the category name
                        $imageUrl = "https://picsum.photos/seed/".$row['category_name']."/500/400"; // Placeholder image API
                        echo '<div class="category-card">
                            <img src="'.$imageUrl.'" alt="'.$row['category_name'].'">
                            <div class="category-card-info">
                                <h2>'.$row['category_name'].'</h2>
                                <p>'.$row['category_desc'].'</p>
                                <a href="threadlist.php?catid='.$row['category_id'].'" class="view-threads-btn">View threads</a>
                            </div>
                        </div>';
                    }
                }
            ?>
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
