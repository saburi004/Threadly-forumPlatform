
<?php 

require 'partials/_dbconnect.php';


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Your custom CSS -->
    <style>
        /* General Styles */
        body {
            background-color: #f0f2f5;
            overflow-x: hidden;
        }

        nav {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: #0B60B0;
            transition: background-color 0.5s ease;
        }

        .navbar-brand {
            font-size: 30px;
            font-weight: bold;
            color: white;
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-nav .nav-link {
            color: white;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #ffe600;
        }

        /* Searchbar styles */
        .form-inline .form-control {
            border-radius: 20px;
        }

        .search {
            background: transparent;
            color: #fff;
            border: 1px solid #fff;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        /* Button styles */
        .login-btn, .signup-btn, .logout-btn {
            background-color: #F2EED7;
            color: #0B60B0;
            border-radius: 20px;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }

        .login-btn:hover, .signup-btn:hover, .logout-btn:hover {
            background-color: #0B60B0;
            color: #fff;
        }

        /* Responsive Navbar */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 24px;
            }
        }

        /* Category Section Styles */
        .cat-container {
            padding: 20px 0;
        }

        .category-link {
            display: block;
            text-decoration: none;
            color: #000;
            text-align: center;
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .category-link:hover {
            transform: translateY(-4px);
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

        /* Optional: Responsive adjustments for buttons */
        @media (max-width: 576px) {
            .login-btn, .signup-btn, .logout-btn {
                padding: 8px 15px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body onload="fadeInElements()">
    <?php
require 'partials/_navbar.php';
?>
<header>
    

  

    <!-- Threads Section -->
    <div class="container my-4">
        <h2 class="text-center">Threads</h2>
        <div class="row">
            <?php 
            $id = isset($_GET['catid']) ? $_GET['catid'] : 0; // Assuming you have a category ID to filter threads
            $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
            $result = mysqli_query($conn, $sql);
            $totalRows = mysqli_num_rows($result);
            if($totalRows > 0){
                $count = 1;
                while($row = mysqli_fetch_assoc($result)){
                    echo '<div class="col-12 col-md-6 col-lg-4 mb-4">'; // Responsive column
                    echo '<div class="thread-card card p-3">';
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
                        <button onclick="readMore('.$count.')" class="btn btn-link read-more" id="read-more-btn_'.$count.'">&#40;Read more&#41;</button></p>';
                    } else {
                        echo '<p>'.$row['thread_desc'].'</p>';
                    }
                    echo '</div>'; // Close the thread-card div
                    echo '</div>'; // Close the column div
                    $count++;
                }
                echo '</div>'; // Close the row div
                echo '<div class="horizontal-separator"></div>';
            } else {
                echo '<div class="col-12 text-center">No threads available in this category.</div>';
            }
            ?>
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
                el.style.opacity = 1;
            }, index * 100);
        });
    }

    function readMore(count) {
        const descStart = document.getElementById('desc_start_' + count);
        const descMore = document.getElementById('desc_more_' + count);
        const dots = document.getElementById('dots_' + count);
        const readMoreBtn = document.getElementById('read-more-btn_' + count);
        
        descStart.style.display = 'none';
        descMore.style.display = 'inline';
        dots.style.display = 'none';
        readMoreBtn.style.display = 'none';
    }
</script>
</body>
</html>
