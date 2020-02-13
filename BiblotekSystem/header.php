<?php
    session_start();
    if(isset($_SESSION['UserID'])){
        echo 'User id that is logged in = '.$_SESSION['UserID'];
    }

    if(isset($_SESSION['TempName'])){
       $_SESSION['TempTitle'] = '';
        $_SESSION['TempType'] = '';
        $_SESSION['TempUsername'] = '';
        $_SESSION['TempName'] = '';
        $_SESSION['TempEmail'] = '';
        $_SESSION['TempAcctype'] = '';
    }

    require'includes/db.inc.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <title> Main </title>
</head>

<body>
