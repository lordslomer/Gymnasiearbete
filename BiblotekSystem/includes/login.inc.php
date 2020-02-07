<?php
    if (isset($_POST['UserEmail'])){
        session_start();
        $_SESSION['Isloggedin'] = 'true';
        echo '<script>history.back(-1)</script>';
        exit();
    }
    else{
        http_response_code(404);        
        exit();
    }
?>
