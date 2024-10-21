<?php
// Ensure no output before session_start()
// Start the session at the very top

require '_dbconnect.php';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $userid = $_SESSION['uid'];
    $getProfilePicSql = mysqli_query($conn, "SELECT user_profile_pic, username FROM `users` WHERE user_id = '$userid'");
    $get_profile_pic = mysqli_fetch_assoc($getProfilePicSql);
    $profile_pic_name = $get_profile_pic['user_profile_pic'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" href="styles.css"> <!-- Your custom CSS -->
    <style>
        body {
            background-color: #f0f2f5; /* Soft background color */
            overflow-x: hidden; /* Prevent horizontal scrolling */
        }

        nav {
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: background-color 0.5s ease;
        }

        .navbar-brand {
            font-size: 30px;
            font-weight: bold;
        }

        .navbar-nav .nav-link {
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #ffe600; /* Highlight color on hover */
        }

        .login-btn, .signup-btn, .logout-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px; /* Slightly rounded corners */
            font-size: 16px; /* Font size */
            font-weight: bold; /* Bold text */
            color: #fff; /* White text */
            text-decoration: none; /* Remove underline */
            transition: all 0.3s ease; /* Smooth transition */
            display: inline-block; /* Align the buttons */
            margin-right: 10px; /* Add space between buttons */
        }

        .signup-btn {
            margin-right: 0; /* Remove margin for the last button */
        }

        /* Login button styling */
        .login-btn {
            background-color: #F2EED7; /* Blue background */
        }

        /* Signup button styling */
        .signup-btn {
            background-color: #F2EED7; /* Green background */
        }

        /* Logout button styling */
        .logout-btn {
            background-color: #F2EED7; /* Red background */
        }

        /* Hover effects */
        .login-btn:hover, .signup-btn:hover, .logout-btn:hover {
            transform: translateY(-2px); /* Lift effect */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); /* Shadow effect */
        }

        /* Active effect */
        .login-btn:active, .signup-btn:active, .logout-btn:active {
            transform: translateY(0); /* Return to original position */
            box-shadow: none; /* Remove shadow on click */
        }

        /* Optional: Responsive adjustments for buttons */
        @media (max-width: 576px) {
            .login-btn, .signup-btn, .logout-btn {
                padding: 8px 15px; /* Adjust padding for smaller screens */
                font-size: 14px; /* Smaller font size */
            }
        }

        .cat-container {
            padding: 20px 0;
        }

        .category-link {
            display: block;
            text-decoration: none;
            color: #000;
            text-align: center;
            background-color: #fff; /* White background for categories */
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .category-link:hover {
            transform: translateY(-4px); /* Lift effect on hover */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        /* Fade-in animation */
        .fade-in {
            opacity: 0;
            animation: fadeIn 0.6s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        /* Additional responsive adjustments */
        @media (max-width: 576px) {
            .category-link {
                font-size: 14px; /* Smaller font for small screens */
            }
        }

        @media (min-width: 768px) {
            .category-link {
                font-size: 16px; /* Larger font for larger screens */
            }
        }

        @media (min-width: 992px) {
            .category-link {
                font-size: 18px; /* Even larger font for extra large screens */
            }
        }
    </style>
</head>

<body onload="fadeInElements()">
<header>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #0B60B0;">
        <a class="navbar-brand text-white" href="#">Threadly</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <form action="/FP/search.php" method="get" class="form-inline my-2 my-lg-0 ml-auto">
                <input class="form-control mr-sm-2 searchbar" type="search" name="search" placeholder="Search here..." aria-label="Search">
                <button id = "search" class="btn search" type="submit"></button>
            </form>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link text-white" href="/FP/index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/FP/about.php">About</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/FP/categories.php">All Categories</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/FP/trending.php">Trending</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/FP/recent.php">Recent</a></li>
                
                <?php 
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                    echo '<li class="nav-item"><a class="nav-link logout-btn" href="partials/_logout.php">Logout</a></li>';
                    echo '<li><a href="/FP/profile.php" class="profile-btn"><img src="/FP/img/'.$profile_pic_name.'" alt="" class="profile-btn-img"></a></li';
                    
                } else {
                    echo '<li class="nav-item"><a class="nav-link login-btn" href="partials/_login.php">Login</a></li>
                          <li class="nav-item"><a class="nav-link signup-btn" href="partials/_signup.php">Signup</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>
    
    <div class="cat-container">
        <div class="container">
            <div class="row">
                <?php
                    require '_dbconnect.php';
                    $sql = "SELECT * FROM `categories`";
                    $result = mysqli_query($conn, $sql);
                    $totalRows = mysqli_num_rows($result);
                    if ($totalRows > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="col-6 col-md-4 col-lg-3 mb-2 fade-in">
                                    <a href="../FP/threadlist.php?catid=' . $row['category_id'] . '" class="category-link">' . $row['category_name'] . '</a>
                                  </div>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</header>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function fadeInElements() {
        const elements = document.querySelectorAll('.fade-in');
        elements.forEach((el, index) => {
            setTimeout(() => {
                el.style.opacity = 1; // Trigger fade-in effect
            }, index * 100); // Staggered effect
        });
    }
</script>
</body>
</html>
