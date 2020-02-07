<?php
    session_start();
    if(isset($_SESSION['Isloggedin'])){
        echo 'Logged in is = '.$_SESSION['Isloggedin'];
    }
else{
        echo 'Logged in is = false';
}

    require'includes/db.inc.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title> Main </title>
</head>

<body>
