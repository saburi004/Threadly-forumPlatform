<?php
require 'partials/_dbconnect.php';
$id = $_GET['tid'];
$sql = "SELECT * FROM `threads` WHERE thread_id=$id";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $thread_title = $row['thread_title'];
    $thread_desc = $row['thread_desc'];
    $thread_img = $row['thread_img'];
    $thread_time = $row['timestamp'];
    $threadUserId = $row['thread_user_id'];
    $getThreadUserSql = "SELECT username, user_profile_pic FROM `users` WHERE user_id = $threadUserId";
    $getThreadUserSqlResult = mysqli_query($conn, $getThreadUserSql);
    $threadUserName = mysqli_fetch_assoc($getThreadUserSqlResult);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/thread.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>Document</title>
</head>

<body>
    <?php require 'partials/_navbar.php'; ?>
    <section class="posts container mt-4">
        <?php  
        // FUNCTION TO DISPLAY TIME ON POST
        function formatDateTime($datetime) {
            date_default_timezone_set('Asia/Kolkata');
            $dateTimeTimestamp = strtotime($datetime);
            $nowTimestamp = time();
            $timeDifference = $nowTimestamp - $dateTimeTimestamp;

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

        $mysqlDateTime = $thread_time; 
        $threadDateTime = formatDateTime($mysqlDateTime);

        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            $reactionsSql = "SELECT post_id, reaction FROM post_reactions WHERE user_id = '{$_SESSION['uid']}'";
            $reactionsResult = mysqli_query($conn, $reactionsSql);
            $reactions = array();

            while ($row = mysqli_fetch_assoc($reactionsResult)) {
                $reactions[$row['post_id']] = $row['reaction'];
            }
        }

        $likeSrc = isset($reactions[$id]) && $reactions[$id] == 'like' ? 'img/like_select.png' : 'img/like.png';
        $dislikeSrc = isset($reactions[$id]) && $reactions[$id] == 'dislike' ? 'img/dislike_select.png' : 'img/dislike.png';

        echo '<div class="post-container card mb-4">
                <div class="card-body">
                    <div class="post-info-container d-flex align-items-center">
                        <div class="post-profile-picture me-3">
                            <img src="img/'.$threadUserName['user_profile_pic'].'" class="rounded-circle" alt="">
                        </div>
                        <div class="post-info">
                            <h4 class="post-username">'.$threadUserName["username"].'</h4>
                            <p class="text-muted">Posted '.$threadDateTime.'</p>
                        </div>
                    </div>
                    <div class="post-image-container">
                        <img src="img/'.$thread_img.'" class="img-fluid" alt="">
                    </div>
                    <div class="post-title-container mt-3">
                        <h3>'.$thread_title.'</h3>
                        <p>'.$thread_desc.'</p>
                    </div>
                    <div class="post-reaction-container mt-3">
                        <div class="like-dislike d-flex">
                            <button class="btn btn-light me-2"><img id="like-btn-'.$id.'" src="'.$likeSrc.'" onClick="likePost('.$id.')" alt=""></button>
                            <button class="btn btn-light"><img id="dislike-btn-'.$id.'" src="'.$dislikeSrc.'" onClick="dislikePost('.$id.')" alt=""></button>
                        </div>
                    </div>';
        
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            echo '<div class="comment-container mt-4">
                    <div class="add-comment-container d-flex align-items-center">
                        <img src="img/'.$profile_pic_name.'" class="rounded-circle me-2" alt="">
                        <form action="handlecomment.php" class="add-comment-form d-flex flex-grow-1">
                            <input type="text" name="add-comment" placeholder="Add a Comment" class="form-control me-2">
                            <input type="hidden" value="1" name="comment-by" id="comment-by">
                            <input type="hidden" value="'.$id.'" name="thread_page_comment" id="thread_page_comment">
                            <input type="hidden" value="'.$id.'" name="thread-id" id="thread-id">
                            <input type="submit" name="submit" value="Add comment" class="btn btn-primary">
                        </form>
                    </div>';
        }

        echo '<div class="view-comments-container mt-3">';

        $sql2 = "SELECT * FROM `comments` WHERE `thread_id` = '$id'";
        $result2 = mysqli_query($conn, $sql2);
        $totalRows = mysqli_num_rows($result2);
        if ($totalRows > 0) {
            while ($row2 = mysqli_fetch_assoc($result2)) {
                $comment_by_id = $row2['comment_by'];
                $getCommentUsernameSql = "SELECT username, user_profile_pic FROM `users` WHERE user_id = '$comment_by_id'";
                $getCommentUsernameSqlResult = mysqli_query($conn, $getCommentUsernameSql);
                $comment_username = mysqli_fetch_assoc($getCommentUsernameSqlResult);

                echo '<div class="post-comment d-flex align-items-start mt-2">
                        <div class="comment-by-profile-picture me-2">
                            <img src="img/'.$comment_username['user_profile_pic'].'" class="rounded-circle" alt="">
                        </div>
                        <div class="comment-by-info">
                            <h4 class="comment-by-username">'.$comment_username['username'].'</h4>
                            <p class="post-comment-content">'.$row2['comment_content'].'</p>
                        </div>
                    </div>';
            }
        } else {
            echo '<div class="no-comments-container">
                    <h3>No comments yet, be the first to start the conversation</h3>
                </div>';     
        }
        echo '</div></div></div>'; // Closing divs for post container
        ?>
    </section>

    <!-- LIKE DISLIKE SCRIPT -->
    <script>
        // Function to handle like button click
        function likePost(postId) {
            var likeBtn = document.getElementById('like-btn-' + postId);
            var dislikeBtn = document.getElementById('dislike-btn-' + postId);
            var likeSrc = likeBtn.src;
            var dislikeSrc = dislikeBtn.src;

            $.ajax({
                type: 'POST',
                url: 'update_reactions.php',
                data: { postId: postId, action: 'like' },
                success: function(response) {
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
                    alert('Error occurred while liking the post.');
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
                data: { postId: postId, action: 'dislike' },
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
                    alert('Error occurred while disliking the post.');
                }
            });
        }
    </script>
</body>

</html>
