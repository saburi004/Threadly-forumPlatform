
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/threadlist.css">
    <link rel="stylesheet" href="css/footer.css">
    <title><?php echo $catname;?> Threads</title>
</head>
<body>
    <?php require 'partials/_navbar.php'?>
    <section class="threadlist-container-section">
        <div class="threadlist-container">

        <?php   require 'partials/_dbconnect.php';
                $noresult = true;
                $query = $_GET["search"];
                $sql = "SELECT * FROM `threads` WHERE MATCH (thread_title, thread_desc) against ('$query')";
                $result = mysqli_query($conn, $sql);
                $totalRows = mysqli_num_rows($result);
                if($totalRows > 0){
                    $count = 1;
                    while($row = mysqli_fetch_assoc($result)){
                        $noresult = false;
                        echo '<div class="thread-card">
                        <h3><a href="/FP/thread.php?tid='.$row['thread_id'].'">'.$row['thread_title'].'</a></h3>';

                        $desc_string = $row['thread_desc'];
                        $string_length = strlen($desc_string);
                        $right_trimmed_desc = substr($desc_string, 0, 169);
                        $left_trimmed_desc = substr($desc_string, 169);
                        
                        if($string_length > 169){

                            // Show only starting text by default
                            echo '<p><span id="desc_start_'.$count.'">'.$right_trimmed_desc.'</span><span id="desc_more_'.$count.'" style="display:none;">'.$left_trimmed_desc.'</span><span id="dots_'.$count.'">...</span><button onclick="readMore('.$count.')" class="read-more" id="read-more-btn_'.$count.'">&#40;Read more&#41;</button></p>';
                        }
                        else{
                            echo '<p>'.$row['thread_desc'].'</p>';
                        }
                    }
                       echo '<div class="horizontal-separator"></div>
                    </div>';
                    }
                
                else{
                    echo '<div>
                    <h1>No Threads Yet, Be the first to Start a Conversation</h1>
                </div>';
                }

                if($noresult){
                    echo '<div class="no-threads">
                    <h1>No Threads Yet, Be the first to Start a Conversation</h1>
                    </div>';
                }
            ?>

            
           
        </div>
    </section>
    
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

</body>
</html>