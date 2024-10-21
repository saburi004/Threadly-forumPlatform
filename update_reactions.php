<?php
session_start();
require 'partials/_dbconnect.php';

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $userId = $_SESSION['uid'];
    $postId = $_POST['postId'];
    $action = $_POST['action'];

    // Check if the user has already reacted to the post
    $checkQuery = "SELECT * FROM post_reactions WHERE user_id = $userId AND post_id = $postId";
    $checkResult = mysqli_query($conn, $checkQuery);

    if(mysqli_num_rows($checkResult) > 0) {
        // User has already reacted to the post
        $row = mysqli_fetch_assoc($checkResult);
        $existingReaction = $row['reaction'];
        
        if ($existingReaction === $action) {
            // If the user's existing reaction is the same as the current action (like or dislike),
            // remove the existing reaction from the database (unlike or undislike)
            $deleteQuery = "DELETE FROM post_reactions WHERE user_id = $userId AND post_id = $postId";
            mysqli_query($conn, $deleteQuery);

            // Update the likes_count or dislikes_count in the threads table accordingly
            if($action == 'like') {
                $updateQuery = "UPDATE threads SET likes_count = likes_count - 1 WHERE thread_id = $postId";
            } else if($action == 'dislike') {
                $updateQuery = "UPDATE threads SET dislikes_count = dislikes_count - 1 WHERE thread_id = $postId";
            }
            mysqli_query($conn, $updateQuery);

            echo 'success_un' . $action; // Return success status with action for client-side handling
        } else {
            // If the user's existing reaction is different from the current action,
            // update the existing reaction to the current action
            $updateQuery = "UPDATE post_reactions SET reaction = '$action' WHERE user_id = $userId AND post_id = $postId";
            mysqli_query($conn, $updateQuery);

            // Update the likes_count or dislikes_count in the threads table accordingly
            if($action == 'like') {
                $updateQuery = "UPDATE threads SET likes_count = likes_count + 1, dislikes_count = dislikes_count - 1 WHERE thread_id = $postId";
            } else if($action == 'dislike') {
                $updateQuery = "UPDATE threads SET dislikes_count = dislikes_count + 1, likes_count = likes_count - 1 WHERE thread_id = $postId";
            }
            mysqli_query($conn, $updateQuery);

            echo 'success' . $action; // Return success status with action for client-side handling
        }
    } else {
        // If the user has not reacted to the post before, insert a new reaction into the database
        $insertQuery = "INSERT INTO post_reactions (user_id, post_id, reaction) VALUES ($userId, $postId, '$action')";
        mysqli_query($conn, $insertQuery);

        // Update the likes_count or dislikes_count in the threads table accordingly
        if($action == 'like') {
            $updateQuery = "UPDATE threads SET likes_count = likes_count + 1 WHERE thread_id = $postId";
        } else if($action == 'dislike') {
            $updateQuery = "UPDATE threads SET dislikes_count = dislikes_count + 1 WHERE thread_id = $postId";
        }
        mysqli_query($conn, $updateQuery);

        echo 'success' . $action; // Return success status with action for client-side handling
    }
} else {
    // User is not logged in
    echo 'not_logged_in';
}
?>