<?php 
if(isset($_POST['LogoutSubmit'])){
    session_start();
    session_unset();
    session_destroy();
    echo '<script>history.back(-1)</script>';
    exit;
}
else {
    header("Location: ../index.php?tryed loggin out without the button");
    exit;
}