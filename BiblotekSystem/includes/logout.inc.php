<?php 
if(isset($_GET['logginout'])){
    session_start();
    session_unset();
    session_destroy();
    echo '<script>history.back(-1)</script>';
}
else {
    header("Location: ../index.php?tryed loggin out without the button");
}
