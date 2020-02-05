<?php
    require 'header.php';
    if(!isset($_SESSION['Isloggedin'])){
        header('location: index.php?Loginfirst.....');
        exit;
    }
?>

<div id="Container">
    <button class="Buttons" style="grid-column: 1/3; grid-row: 1/2; justify-self: center;
    align-self: center; text-decoration: none;" onclick="history.back(-1)">&laquo; Tillbaka</button>

    <div class="SubSearchBox">

        <form action="index.php" method="get">
            <span>Sök:</span>
            <input autocomplete="off" name="Searched" type="search" size="40">
            <button type="submit" class="Buttons searchbutton">Go</button>
        </form>
    </div>



    <div class="LoginBox">
        <div>
            <button class="Buttons" onclick="location.replace('profile.php')">Min profil</button>
            <a href="includes/logout.inc.php?logginout"><button class="Buttons">Loggga ut</button></a>
        </div>
    </div>
    <div>
        THIS IS UR PROFILE PAGE
    </div>
</div>
<?php
    require 'footer.php';
?>
