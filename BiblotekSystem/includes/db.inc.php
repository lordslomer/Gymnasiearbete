<?php
    $con = mysqli_connect("localhost","root","XSolAicN2A9baETG","systemdb");

    // Check connection
    if(!$con){
        die("Connection failed: " . mysqli_connect_error());
    }

    function test_input($data) {
        $con = mysqli_connect("localhost","root","XSolAicN2A9baETG","systemdb");
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = mysqli_real_escape_string($con, $data);
        return $data;
}

?>
