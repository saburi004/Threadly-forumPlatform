<?php
session_start(); // Start the session to manage login status

require 'partials/_dbconnect.php';

// Check if the user is successfully signed up
if (isset($_GET['signupsuccess'])) {
    $signupsuccess = $_GET['signupsuccess'];
    if ($signupsuccess == "true") {
        echo '<script>alert("Signup Successful! You can now Login..")</script>';
    }
    if ($signupsuccess == "false") {
        echo '<script>alert("Signup Failed, Try Again")</script>';
        header("Location: /FP/index.php");
    }
}

// Check if the user is successfully logged in
if (isset($_GET['loginsuccess'])) {
    $loginsuccess = $_GET['loginsuccess'];
    if ($loginsuccess == "true") {
        echo '<script>alert("You are logged in!")</script>';
    }
}

// If the user is logged in, set the session variables
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    // Use session variables for user data
    $username = $_SESSION['username'];
    $profile_pic_name = $_SESSION['profile_pic']; // Ensure this is set during login
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/footer.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Threadly - Home</title>

</head>

<body>
    <?php require 'partials/_navbar.php'; ?>
    <?php echo '<dialog data-modal class="dialog-container">
        <h1 id="post-dialog-heading">Create New Post</h1>
        <form class="new-post-form" action="handlepost.php" method="post" enctype="multipart/form-data">
            <label for="selected-cat">Category:</label>
            <select name="selected-cat" id="selected-cat" class="selected-cat" required>';
            
                require 'partials/_dbconnect.php';
                $sql = "SELECT * FROM `categories`";
                $result = mysqli_query($conn, $sql);

                $totalRows = mysqli_num_rows($result);
                if($totalRows > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<option value="'.$row['category_name'].'">'.$row['category_name'].'</option>';
                    }
                }
               
           echo '</select>
            <label for="post-title">Title:</label>
            <input type="text" name="post-title" id="post-title" required>
            <label for="post-description">Description:</label>
            <textarea type="text" name="post-description" id="post-description" cols="30" rows="10" required></textarea>
            <input type="file" name="pic" id="pic" class="post-image-upload" accept=".jpg, .jpeg, .png" required>
            <input type="hidden" value="'.$_SESSION['uid'].'" name="uid" id="uid">
            <button type="submit" name="submit" id="submit">Post</button>
            <button formmethod="dialog" id="cancel-post-btn" onclick="location.href=\'index.php\'">Cancel</button>
        </form>
    </dialog>'; ?>

    <?php require 'partials/_addthread.php'?>

    <section class="posts">

        <?php  


    //FUNCTION TO DISPLAY TIME ON POST
function formatDateTime($datetime) {
    // Set timezone to Asia/Kolkata (Indian Standard Time)
    date_default_timezone_set('Asia/Kolkata');
    // Convert MySQL DATETIME to Unix timestamp
    $dateTimeTimestamp = strtotime($datetime);
    
    // Get current Unix timestamp
    $nowTimestamp = time();
    
    // Calculate the time difference in seconds
    $timeDifference = $nowTimestamp - $dateTimeTimestamp;
   

    // Logic to display time difference
    if ($timeDifference < 60) {
        return 'Just now';
    } elseif ($timeDifference < 3600) {
        $minutes = floor($timeDifference / 60);
        return $minutes == 1 ? '1 minute ago' : $minutes . ' minutes ago';
    } elseif ($timeDifference < 86400) {
        $hours = floor($timeDifference / 3600);
        return $hours == 1 ? '1 hour ago' : $hours . ' hours ago';
    } elseif ($timeDifference < 2592000) {
        $days = floor($timeDifference / 86400);
        return $days == 1 ? '1 day ago' : $days . ' days ago';
    } elseif ($timeDifference < 31536000) {
        $months = floor($timeDifference / 2592000);
        return $months == 1 ? '1 month ago' : $months . ' months ago';
    } else {
        $years = floor($timeDifference / 31536000);
        return $years == 1 ? '1 year ago' : $years . ' years ago';
    }
}




if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){

    // Fetch reactions from the database for the current user
    $reactionsSql = "SELECT post_id, reaction FROM post_reactions WHERE user_id = '{$_SESSION['uid']}'";
    $reactionsResult = mysqli_query($conn, $reactionsSql);
    $reactions = array();
    
    // Store reactions in an associative array
    while ($row = mysqli_fetch_assoc($reactionsResult)) {
        $reactions[$row['post_id']] = $row['reaction'];
    }
}



require 'partials/_dbconnect.php';
$sql = "SELECT * FROM `threads` ORDER BY timestamp DESC";
$result = mysqli_query($conn, $sql);
$totalRows = mysqli_num_rows($result);

if ($totalRows > 0) {
    $count = 0; // Initialize count for unique identifier
    while ($row = mysqli_fetch_assoc($result)) {

        // Check if the post has a reaction from the current user
        $likeSrc = isset($reactions[$row['thread_id']]) && $reactions[$row['thread_id']] == 'like' ? 'img/like_select.png' : 'img/like.png';
        $dislikeSrc = isset($reactions[$row['thread_id']]) && $reactions[$row['thread_id']] == 'dislike' ? 'img/dislike_select.png' : 'img/dislike.png';

        // To DISPLAY USERNAME ON POST
        $threadUserId = $row['thread_user_id'];
        $getThreadUserSql = "SELECT username, user_profile_pic FROM `users` WHERE user_id = $threadUserId";
        $getThreadUserSqlResult = mysqli_query($conn, $getThreadUserSql);
        $threadUserName = mysqli_fetch_assoc($getThreadUserSqlResult);

        // Check if the user data was retrieved successfully
        if ($threadUserName) {
            $profilePic = $threadUserName["user_profile_pic"] ?? 'default_profile_pic.png';
            $username = $threadUserName["username"] ?? 'Unknown User';
        } else {
            // Fallback values if user data is not found
            $profilePic = 'default_profile_pic.png'; // Replace with your default image
            $username = 'Unknown User';
        }

        $mysqlDateTime = $row['timestamp'];
        $threadDateTime = formatDateTime($mysqlDateTime);

        echo '<div class="post-container">
                <div class="post-info-container">
                    <div class="post-profile-picture">
                        <img src="img/' . htmlspecialchars($profilePic) . '" alt="Profile Picture">
                    </div>
                    <div class="post-info">
                        <h4 class="post-username">' . htmlspecialchars($username) . '</h4>
                        <p>Posted ' . htmlspecialchars($threadDateTime) . '</p>
                    </div>
                </div>
                <div class="post-title-container">
                    <h3>' . htmlspecialchars($row['thread_title']) . '</h3>';

        $desc_string = $row['thread_desc'];
        $string_length = strlen($desc_string);
        $right_trimmed_desc = substr($desc_string, 0, 169);
        $left_trimmed_desc = substr($desc_string, 169);

        if ($string_length > 169) {
            // Show only starting text by default
            echo '<p>
                    <span id="desc_start_' . $count . '">' . htmlspecialchars($right_trimmed_desc) . '</span>
                    <span id="desc_more_' . $count . '" style="display:none;">' . htmlspecialchars($left_trimmed_desc) . '</span>
                    <span id="dots_' . $count . '">...</span>
                    <button onclick="readMore(' . $count . ')" class="read-more" id="read-more-btn_' . $count . '">&#40;Read more&#41;</button>
                  </p>';
        } else {
            echo '<p>' . htmlspecialchars($row['thread_desc']) . '</p>';
        }

        echo '</div>
              <div class="post-image-container">
                  <img src="img/' . htmlspecialchars($row['thread_img']) . '" alt="Post Image">
              </div>
              <div class="post-reaction-container">
                  <div class="like-dislike">
                      <button><img id="like-btn-' . $row['thread_id'] . '" src="' . htmlspecialchars($likeSrc) . '" onClick="likePost(' . $row['thread_id'] . ')" alt="Like"></button>
                      <button><img id="dislike-btn-' . $row['thread_id'] . '" src="' . htmlspecialchars($dislikeSrc) . '" onClick="dislikePost(' . $row['thread_id'] . ')" alt="Dislike"></button>
                  </div>
                  <button onclick="readComments(' . $count . ');"><img src="img/comment.png" alt="Comment"></button>
              </div>
              <div class="comment-container" style="display: none;">';

        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            $username = $_SESSION['username'];
            echo '<div class="add-comment-container">
                    <img src="img/' . htmlspecialchars($profile_pic_name) . '" alt="User Profile Picture">
                    <form action="handlecomment.php" class="add-comment-form" method="POST">
                        <input type="text" name="add-comment" placeholder="Add a Comment" class="comment-input" required>
                        <input type="hidden" value="' . htmlspecialchars($username) . '" name="comment-by" id="comment-by">
                        <input type="hidden" value="' . htmlspecialchars($row['thread_id']) . '" name="thread-id" id="thread-id">
                        <input type="submit" name="submit" value="Add comment" class="add-comment-btn">
                    </form>
                  </div>';
        } else {
            echo '<h3 class="comment-h3">Log in to comment</h3>';
        }

        echo '<div class="view-comments-container">';

        $sql2 = "SELECT * FROM `comments` WHERE `thread_id` = {$row['thread_id']}";
        $result2 = mysqli_query($conn, $sql2);
        $totalRows = mysqli_num_rows($result2);

        if ($totalRows > 0) {
            while ($row2 = mysqli_fetch_assoc($result2)) {
                $comment_by_id = $row2['comment_by'];
                $getCommentUsernameSql = "SELECT username, user_profile_pic FROM `users` WHERE user_id = '$comment_by_id'";
                $getCommentUsernameSqlResult = mysqli_query($conn, $getCommentUsernameSql);
                $comment_username = mysqli_fetch_assoc($getCommentUsernameSqlResult);

                // Check if the comment user data was retrieved successfully
                if ($comment_username) {
                    echo '<div class="post-comment">
                            <div class="comment-by-profile-picture">
                                <img src="img/' . htmlspecialchars($comment_username['user_profile_pic']) . '" alt="Commenter Profile Picture">
                            </div>
                            <div class="comment-by-info">
                                <h4 class="comment-by-username">' . htmlspecialchars($comment_username['username']) . '</h4>
                                <p class="post-comment-content">' . htmlspecialchars($row2['comment_content']) . '</p>
                            </div>
                          </div>';
                }
            }
        }

        echo '</div></div></div>'; // Close comment-container, post-reaction-container, and post-container divs
        $count++; // Increment count for the next iteration
    }
}

        ?>
    </section>

    <!-- Footer -->

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>About Threadly</h5>
                    <p>Threadly is a vibrant community where passionate individuals explore, learn, and share knowledge
                        on diverse topics. Join us to foster connections and build a strong community.</p>
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
                        <li><a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-f"></i>
                                Facebook</a></li>
                        <li><a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i> Twitter</a>
                        </li>
                        <li><a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i>
                                Instagram</a></li>
                        <li><a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i>
                                LinkedIn</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center">
                <p>&copy; 2024 Threadly. All rights reserved.</p>
            </div>



            <script>
            $(document).ready(function() {
                console.log("jQuery version: " + $.fn.jquery);
            });
            </script>








            <script>
            const openButton = document.querySelectorAll("[data-open-modal]");
            const closeButton = document.querySelector("[data-close-modal]");
            const modal = document.querySelector("[data-modal]");

            for (let i = 0; i < openButton.length; i++) {
                openButton[i].addEventListener("click", function() {
                    modal.showModal();
                });
            }
            </script>

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

            function readComments(postIndex) {
                var commentContainer = document.querySelectorAll('.comment-container')[postIndex];

                if (commentContainer.style.display === "none" || commentContainer.style.display === "") {
                    commentContainer.style.display = "block";
                } else {
                    commentContainer.style.display = "none";
                }
            }
            </script>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <!-- LIKE DISLIKE SCRIPT -->
            <script>
            // Function to handle like button click
            function likePost(postId) {
                var likeBtn = document.getElementById('like-btn-' + postId);
                var dislikeBtn = document.getElementById('dislike-btn-' + postId);
                var likeSrc = likeBtn.src;
                var dislikeSrc = dislikeBtn.src;
                console.log("liked button clicked" + postId);


                $.ajax({
                    type: 'POST',
                    url: 'update_reactions.php',
                    data: {
                        postId: postId,
                        action: 'like'
                    },
                    success: function(response) {
                        console.log("success");
                        // Handle success

                        if (likeSrc.includes('like_select.png')) {
                            likeBtn.src = 'img/like.png'; // Change like to default
                        } else {
                            likeBtn.src = 'img/like_select.png'; // Change like to selected
                            // If dislike button is selected, change it back to default
                            if (dislikeSrc.includes('dislike_select.png')) {
                                dislikeBtn.src = 'img/dislike.png';
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        alert('Error liking post');
                    }
                });
            }

            // Function to handle dislike button click
            function dislikePost(postId) {
                var likeBtn = document.getElementById('like-btn-' + postId);
                var dislikeBtn = document.getElementById('dislike-btn-' + postId);
                var likeSrc = likeBtn.src;
                var dislikeSrc = dislikeBtn.src;

                $.ajax({
                    type: 'POST',
                    url: 'update_reactions.php',
                    data: {
                        postId: postId,
                        action: 'dislike'
                    },
                    success: function(response) {
                        // Handle success

                        if (dislikeSrc.includes('dislike_select.png')) {
                            dislikeBtn.src = 'img/dislike.png'; // Change dislike to default
                        } else {
                            dislikeBtn.src = 'img/dislike_select.png'; // Change dislike to selected
                            // If like button is selected, change it back to default
                            if (likeSrc.includes('like_select.png')) {
                                likeBtn.src = 'img/like.png';
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        alert('Error disliking post');
                    }
                });
            }
            </script>
</body>

</html>