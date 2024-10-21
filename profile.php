 <?php
 session_start(); 
  require 'partials/_navbar.php'; ?>
 <?php 
 // Start session if not already started

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $username = $_SESSION['username'];
    
    if (isset($_SESSION['uid'])) {
        $userid = $_SESSION['uid']; // Ensure $userid is set
    } else {
        // If UID is missing, redirect to index
        header("location: index.php");
        exit();
    }
} else {
    // If not logged in, redirect to index
    header("location: index.php");
    exit();
}

// Fetch profile picture and username
$getProfilePicSql = mysqli_query($conn, "SELECT user_profile_pic, username FROM `users` WHERE user_id = '$userid'");
if ($getProfilePicSql && mysqli_num_rows($getProfilePicSql) > 0) {
    $get_profile_pic = mysqli_fetch_assoc($getProfilePicSql);
    $profile_pic_name = $get_profile_pic['user_profile_pic'];
    $updatedUsername = $get_profile_pic['username'];
} else {
    // If no profile picture found, set default values
    $profile_pic_name = 'default_pic.png'; // Default picture path
    $updatedUsername = $username; // Fallback to session username
}

// Fetch threads by user
$sql = "SELECT * FROM `threads` WHERE thread_user_id=$userid";
$result = mysqli_query($conn, $sql);
$threads = []; // To store all threads
while ($row = mysqli_fetch_assoc($result)) {
    $threads[] = $row; // Store each thread in the array
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/profile.css">                   
    <link rel="stylesheet" href="css/home.css">   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>                
    <title>Profile - <?php echo htmlspecialchars($_SESSION['username']); ?></title>
</head>
<body>

<?php
// Dialog for updating profile
echo '<dialog data-modal class="dialog-container">
        <h1 id="post-dialog-heading">Update Your Profile</h1>
        <form class="new-post-form" action="handleprofile.php" method="post" enctype="multipart/form-data">
            <label for="profile-username">Edit Username:</label>
            <input type="text" name="profile-username" id="profile-username" value="'.htmlspecialchars($username).'">
            <label for="profile-pic-update">Select Profile Picture</label>
            <input type="file" name="profile-pic-update" id="profile-pic-update" class="post-image-upload" accept=".jpg, .jpeg, .png">
            <input type="hidden" value="'.htmlspecialchars($userid).'" name="uid" id="uid">
            <button type="submit" name="submit" id="submit">Save</button>
            <button formmethod="dialog" id="cancel-post-btn" onclick="location.href=\'profile.php\'">Cancel</button>
        </form>
    </dialog>';
?>

<section class="profile-section">
    <div class="profile-container">
        <div class="profile-pic-main-container">
            <img src="img/<?php echo htmlspecialchars($profile_pic_name); ?>" alt="Profile Picture">
        </div>
        <div class="user-profile-info-container">
            <h3><?php echo htmlspecialchars($updatedUsername); ?></h3>
            <button data-open-modal>Edit profile</button>
        </div>
    </div>

    <section class="posts">
        <?php
        // Function to format time
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

        // Display threads
        foreach ($threads as $thread) {
            $threadDateTime = formatDateTime($thread['timestamp']);
            $threadId = htmlspecialchars($thread['thread_id']);
            $threadTitle = htmlspecialchars($thread['thread_title']);
            $threadDesc = htmlspecialchars($thread['thread_desc']);
            $threadImg = htmlspecialchars($thread['thread_img']);
            
            // Display each post
            echo '<div class="post-container">
                    <div class="post-info-container">
                        <div class="post-profile-picture">
                            <img src="img/'.htmlspecialchars($profile_pic_name).'" alt="">
                        </div>
                        <div class="post-info">
                            <h4 class="post-username">'.htmlspecialchars($username).'</h4>
                            <p>Posted '.$threadDateTime.'</p>
                        </div>
                    </div>
                    <div class="post-image-container">
                        <img src="img/'.htmlspecialchars($threadImg).'" alt="Post Image">
                    </div>
                    <div class="post-title-container">
                        <h3>'.$threadTitle.'</h3>
                        <p>'.$threadDesc.'</p>
                    </div>
                  </div>';
        }
        ?>
    </section>
</section>

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

</body>
</html>
