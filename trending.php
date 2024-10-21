<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Your custom CSS -->
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/threadlist.css">
    
    <title><?php echo $catname;?> Threads</title>

    <style>
        /* Custom Styles for thread cards */
        body {
            background-color: #f7f9fc; /* Soft background for better contrast */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #212529;
        }

        .thread-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transitions */
        }

        .thread-card:hover {
            transform: translateY(-3px); /* Lift effect on hover */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Deeper shadow on hover */
        }

        .horizontal-separator {
            height: 2px;
            background-color: #f0f0f0;
            margin: 10px 0;
        }

        /* Read more button styling */
        .read-more {
            background-color: transparent;
            border: none;
            color: #007bff;
            cursor: pointer;
            padding: 0;
            font-size: 0.9rem;
            transition: color 0.2s ease, transform 0.2s ease; /* Button transitions */
        }

        .read-more:hover {
            color: #0056b3; /* Darker shade on hover */
            transform: scale(1.05); /* Slightly increase size on hover */
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            h3 a {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 576px) {
            h3 a {
                font-size: 1rem;
            }
            .thread-card {
                padding: 15px;
            }
        }

        /* Fade-in animation */
        .fade-in {
            opacity: 0;
            animation: fadeIn 0.5s forwards; /* Fade-in animation */
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
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
         
    <!-- Navbar inclusion -->
    <?php require 'partials/_navbar.php'?>

    <!-- Threadlist section -->
    <section class="threadlist-container-section container">
        <div class="row">
            <div class="col-12 threadlist-container">
                <!-- PHP Thread loop -->
                <?php 
                    $sql = "SELECT t.thread_id, t.thread_title, t.thread_desc, t.timestamp, COUNT(pr.reaction_id) AS reaction_count, pr.reaction 
                            FROM threads t 
                            LEFT JOIN post_reactions pr 
                            ON t.thread_id = pr.post_id AND pr.reaction = 'like' AND pr.created_at >= NOW() - INTERVAL 24 HOUR 
                            GROUP BY t.thread_id, t.thread_title, t.thread_desc, t.timestamp, pr.reaction 
                            ORDER BY reaction_count DESC;";
                    
                    $result = mysqli_query($conn, $sql);
                    $totalRows = mysqli_num_rows($result);
                    
                    if($totalRows > 0){
                        $count = 1;
                        while($row = mysqli_fetch_assoc($result)){
                            echo '<div class="thread-card fade-in">'; // Added fade-in class
                            echo '<h3><a href="thread.php?tid='.$row['thread_id'].'">'.$row['thread_title'].'</a></h3>';

                            $desc_string = $row['thread_desc'];
                            $string_length = strlen($desc_string);
                            $right_trimmed_desc = substr($desc_string, 0, 169);
                            $left_trimmed_desc = substr($desc_string, 169);

                            if($string_length > 169){
                                // Show only starting text by default
                                echo '<p><span id="desc_start_'.$count.'">'.$right_trimmed_desc.'</span>
                                      <span id="desc_more_'.$count.'" style="display:none;">'.$left_trimmed_desc.'</span>
                                      <span id="dots_'.$count.'">...</span>
                                      <button onclick="readMore('.$count.')" class="read-more" id="read-more-btn_'.$count.'">&#40;Read more&#41;</button></p>';
                            } else {
                                echo '<p>'.$row['thread_desc'].'</p>';
                            }
                            echo '<div class="horizontal-separator"></div></div>';
                            $count++;
                        }
                    } else {
                        echo '<div><h1>No Threads Yet, Be the first to Start a Conversation</h1></div>';
                    }
                ?>
            </div>
        </div>
    </section>
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
    
    <!-- JavaScript to handle Read More/Read Less -->
    <script>
        function readMore(count) {
            var dots = document.getElementById("dots_" + count);
            var moreText = document.getElementById("desc_more_" + count);
            var btnText = document.getElementById("read-more-btn_" + count);
            var descStart = document.getElementById("desc_start_" + count);
        
            if (dots.style.display === "none") {
                dots.style.display = "inline";
                btnText.innerHTML = "&#40;Read more&#41;";
                moreText.style.display = "none";
                descStart.style.display = "inline"; // Display the starting text
            } else {
                dots.style.display = "none";
                btnText.innerHTML = "&#40;Read less&#41;";
                moreText.style.display = "inline";
                // Do not hide the starting text when "Read more" is clicked
            }
        }
    </script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
