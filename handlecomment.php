<?php
require 'partials/_dbconnect.php';
if(isset($_REQUEST['submit']))
{
    $add_comment = $_REQUEST['add-comment'];
    $thread_id = $_REQUEST['thread-id'];
    $comment_by = $_REQUEST['comment-by'];

    $getCommentUserIdSql = "SELECT user_id FROM `users` WHERE username = '$comment_by'";
    $getCommentUserIdSqlResult = mysqli_query($conn, $getCommentUserIdSql);
    $get_comment_by_id = mysqli_fetch_assoc($getCommentUserIdSqlResult);
    $comment_by_id = $get_comment_by_id['user_id'];


    $add_comment = str_replace("<", "&lt;", $add_comment);
    $add_comment = str_replace(">", "&gt;", $add_comment);
    $add_comment = str_replace("'", "&apos;", $add_comment);

    $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$add_comment', '$thread_id', '$comment_by_id', current_timestamp())";
    $result = mysqli_query($conn, $sql);

    if($result)
        {
            if(isset($_REQUEST['thread_page_comment'])){
                $comment_thread_id = $_REQUEST['thread_page_comment'];
                echo '<script>
                window.location = "thread.php?tid='.$comment_thread_id.'";
                </script>';
            }
            else{

                echo '<script>
                
                window.location = "index.php";
                </script>';
            }
        }

}


?>