<?php
require 'partials/_dbconnect.php';

$pic_uploaded = 0;
if(isset($_REQUEST["submit"]))
{
    $profile_username = $_REQUEST['profile-username'];
    $user_id = $_REQUEST['uid'];


        $profile_username = str_replace("<", "&lt;", $profile_username);
        $profile_username = str_replace(">", "&gt;", $profile_username);
        $profile_username = str_replace("'", "&apos;", $profile_username);


    $image = time().$_FILES["profile-pic-update"]['name'];
    if(move_uploaded_file($_FILES['profile-pic-update']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/FP/img/'.$image))
    {
        $target_file = $_SERVER['DOCUMENT_ROOT'].'/FP/img/'.$image;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $picname = basename($_FILES['profile-pic-update']['name']);
        $photo = time().$picname;

        if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png")
        {
            echo '<script>alert("Please post image having jpg/jpeg/png type");</script>';
        }
        else if($_FILES["profile-pic-update"]["size"] > 20000000)
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
        $update_query = mysqli_query($conn, "UPDATE `users` SET `username` = '$profile_username', `user_profile_pic` = '$photo' WHERE `users`.`user_id` = '$user_id'");
        
        if($update_query > 0)
        {
            echo '
            <script>
            alert("Profile updated");
            window.location = "profile.php";
            </script>';
        }
    }
    else
    {
        echo '<script>alert("Failed to update profile");</script>';

    }




}


?>
