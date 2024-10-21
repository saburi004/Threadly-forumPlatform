
<section class="ask-question">
    <div class="ask-question-container">
        <?php
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
            echo '<div class="question-btn">
            <img src="img/'.$profile_pic_name.'" alt="" srcset="">
            <button data-open-modal>Ask anything you want to know...</button>
        </div>
        <div class="search-action-btns">
            <div class="search-action-btn">
                <img src="img/ask.png" alt="">
                <button data-open-modal>Ask</button>
            </div>
            <div class="vertical-separator"></div>
            <div class="search-action-btn">
                <img src="img/browse.png" alt="">
                <button onclick="location.href=\'categories.php\'">Browse</button>
            </div>
            <div class="vertical-separator"></div>
            <div class="search-action-btn">
                <img src="img/answer.png" alt="">
                <button onclick="location.href=\'recent.php\'">Answer</button>
            </div>
        </div>';

            }
            else{
                echo '<h2 class="ask-question-h2">Log in to start your own conversation</h2>';
            }
        ?>  
        
    </div>
</section>