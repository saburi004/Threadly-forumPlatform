<?php
require 'partials/_dbconnect.php';

$pic_uploaded = 0;
if(isset($_REQUEST["submit"]))
{
    $thread_title = $_REQUEST['post-title'];
    $thread_desc = $_REQUEST['post-description'];
    $thread_cat_name = $_REQUEST['selected-cat'];
    $thread_user_id = $_REQUEST['uid'];


        $thread_title = str_replace("<", "&lt;", $thread_title);
        $thread_title = str_replace(">", "&gt;", $thread_title);
        $thread_title = str_replace("'", "&apos;", $thread_title);

        $thread_desc = str_replace("<", "&lt;", $thread_desc);
        $thread_desc = str_replace(">", "&gt;", $thread_desc);
        $thread_desc = str_replace("'", "&apos;", $thread_desc);


    
    
    $sql = "SELECT category_id FROM `categories` WHERE category_name = '$thread_cat_name'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $thread_cat_id = $row['category_id'];


    $image = time().$_FILES["pic"]['name'];
    if(move_uploaded_file($_FILES['pic']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/FP/img/'.$image))
    {
        $target_file = $_SERVER['DOCUMENT_ROOT'].'/FP/img/'.$image;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $picname = basename($_FILES['pic']['name']);
        $photo = time().$picname;

        if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png")
        {
            echo '<script>alert("Please post image having jpg/jpeg/png type");</script>';
        }
        else if($_FILES["pic"]["size"] > 20000000)
        {
            echo '<script>alert("Your Image size is too high");</script>';
        }
        else
        {
            $pic_uploaded = 1;
        }
    }


    if($pic_uploaded == 1)
    {
        $insert_query = mysqli_query($conn, "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_img`, `thread_cat_id`, `thread_user_id`, `timestamp`, `thread_likes`, `thread_dislike`) VALUES ('$thread_title','$thread_desc', '$photo', '$thread_cat_id', '$thread_user_id', current_timestamp(), '0', '0')");
        
        if($insert_query > 0)
        {
            echo '
            <script>
            alert("New post added");
            window.location = "index.php";
            </script>';
        }
    }
    else
    {
        echo '<script>alert("Failed to post");</script>';

    }




}


?>
