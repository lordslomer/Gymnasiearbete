<?php
    if (isset($_POST['UserEmail'])){
        session_start();
        $_SESSION['Isloggedin'] = 'true';
        echo '<script>history.back(-1)</script>';
        exit;
    }
    else{
        header('location: ../index.php?tryed to login without typing password');
        exit;
    }
?>
