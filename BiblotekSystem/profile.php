<?php
    require 'header.php';
    if(!isset($_SESSION['Isloggedin'])){
        header('location: index.php?Loginfirst.....');
        exit;
    }
?>

<div id="Container" style="grid-template-rows: repeat(4, 1fr);">

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
        <div style="grid-template-columns: 1fr;">
            <button onclick="LoginModalDisplay(1)" class="Buttons">Loggga ut</button>
        </div>
    </div>

    <div class="Modal" style="background-color: rgba(0, 0, 0, 0.4); grid-template-rows: repeat(3,1fr);">
        <span style="grid-area: 2/2/3/3; align-self: start; justify-self: end; margin-right: 13%;
    margin-top: 5%;" class="CloseModalX" onclick="LoginModalDisplay(0)">&times;</span>
        <div class="ModalContent" style="grid-area: 2/2/3/3; grid-template: repeat(2, 1fr) / repeat(2, 1fr); grid-gap:0px; grid-column-gap: 50px; grid-row-gap: 20px; justify-self: center; align-self: center; padding: 20px;">
            <span style="grid-area: 1/1/2/3; justify-self:center; align-self: end;">Är du säker du vill logga ut ?</span>
            <button style="grid-area: 2/2/3/3; justify-self:start; align-self: start;" class="Buttons" onclick="LoginModalDisplay(0)">Avbryt</button>
            <a href="includes/logout.inc.php?logginout" style="grid-area: 2/1/3/2; justify-self:end; align-self: start;"><button type="submit" class="Buttons">Logga ut</button></a>
        </div>
    </div>

    <!-- Info div för den inloggade konto -->
    <div class="SearchedResults" style="grid-row: 2/3; border:none; padding:0px; grid-gap:0px;">
        <div class="aResult" style=" grid-template: repeat(3,1fr)/ 1fr 2fr 2fr; border:none; width: 100%; height:100%; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); ">
            <p style="font-size: 22px; grid-area: 1/1/2/4; justify-self: center; align-self: center;"><span>Namn : </span>Firstname Lastname</p>
            <span style="justify-self: center; align-self: center; grid-area: 2/2/3/3; font-size:22px; border-bottom: 2px solid black;">Användarnamn</span>
            <p style="justify-self: center; align-self: start; grid-area: 3/2/4/3;">Firstnamne.Lastname</p>
            <span style="justify-self: center; align-self: center; grid-area: 2/3/3/4; font-size:22px; border-bottom: 2px solid black;">Epostadress</span>
            <p style="justify-self: center; align-self: start; grid-area: 3/3/4/4;">Firstnamne.Lastname@elev.ntig.se</p>
            <button class="Buttons" style="grid-area: 2/1/4/2; justify-self: center; align-self: center;">Ändra Lösenord</button>
        </div>
    </div>

</div>
<?php
    require 'footer.php';
?>
