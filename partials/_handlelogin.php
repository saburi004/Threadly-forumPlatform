<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $username = $_POST['login-username'];
    $pass = $_POST['login-password'];
    
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if($numRows==1){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($pass, $row['user_pass'])){
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['uid'] = $row['user_id'];
            $_SESSION['username'] = $username;
            $_SESSION['profile_pic'] = $row['user_profile_pic'];
            header("Location: /FP/index.php?loginsuccess=true");
            exit();
        }
        else{
            echo '<script>alert("Username and Password not match, Try again");</script>';
            header("Location: /FP/partials/_login.php");

        }
        
    }
    echo '<script>alert("Username not exist, Try again");</script>';
    header("Location: /FP/partials/_login.php");

}
?>