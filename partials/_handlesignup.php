<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    require '_dbconnect.php';
    $username = $_POST['signup-username'];
    $pass = $_POST['signup-password'];
    $cpass = $_POST['confirm-signup-password'];


//check if username already exist or not
    $existsql = "SELECT * from `users` where username = '$username'";
    $result = mysqli_query($conn, $existsql);
    $numRows = mysqli_num_rows($result);
    if($numRows>0){
        echo '<script>alert("Username already exist");</script>';
    }
    else{
        if($pass == $cpass){
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`username`, `user_pass`, `timestamp`) VALUES ('$username', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if($result){
               
                header("Location: /FP/index.php?signupsuccess=true");
                exit();
            }
        }
        else{
            echo '<script>alert("Passwords do not match");</script>';
            header("Location: /FP/partials/_signup.php");
        }
    }
    header("Location: /FP/index.php?signupsuccess=false");


}

?>