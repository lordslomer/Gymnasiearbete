<?php 
if(isset($_POST['LogoutSubmit'])){
    session_start();
    session_unset();
    session_destroy();
    echo '<script>history.back(-1)</script>';
    exit();
}
else {
    http_response_code(404);
    exit();
}
