<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        session_start();
        $_SESSION['Isloggedin'] = 'true';
        header('location: ../profile.php?');
        exit;
    }
    else{
        header('location: ../index.php?Dont do that.....');
        exit;
    }
?>
