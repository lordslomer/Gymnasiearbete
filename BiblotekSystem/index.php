<?php 
    require'header.php';
?>


<div id="Container">
    <?php
        if(isset($_GET['Searched'])){
            echo ' <button class="Buttons" style="grid-column: 1/3; grid-row: 1/2; justify-self: center;
    align-self: center; text-decoration: none;" onclick="history.back(-1)">&laquo; Tillbaka</button>
            <div class="SubSearchBox">
                    <form action="index.php" method="get">
                        <span>Sök:</span>
                        <input autocomplete="off" name="Searched" type="search" size="40">
                        <button type="submit" class="Buttons searchbutton">Go</button>
                    </form>
                </div>';
            
            $searchq = test_input($_GET['Searched']);
            if(!empty($searchq)){

                $sql = "SELECT * FROM arkiv WHERE Titel LIKE '%$searchq%' OR Author LIKE '%$searchq%' OR TryckBolag  LIKE '%$searchq%' OR TryckYear LIKE '%$searchq%' OR Genre LIKE '%$searchq%' OR Language LIKE '%$searchq%'";
                $result = mysqli_query($con, $sql);
                $resultAmount = mysqli_num_rows($result);

                if($resultAmount > 0){
                    $aResultRow = 1;
                    echo '<script>document.getElementById("Container").style.gridTemplateRows = "repeat('.($resultAmount + 3).', 1fr)";</script><p style="grid-area: 2/2/3/10; align-self: end;"><span>Hittade '.$resultAmount.' resultat för  "'.$searchq.'".</span></p><div class="SearchedResults" style="grid-template-rows: repeat('.$resultAmount.', 1fr);  grid-row: 3/'.($resultAmount + 3).';">';
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<div class="aResult" style="grid-row: '.$aResultRow.' / '.($aResultRow + 1).';"><p style="font-size: 22px; grid-area: 1/1/2/4;"><span>Titel : </span>'.$row['Titel'].'</p><p style="grid-area: 2/1/3/2;"><span>Förfatare : </span>'.$row['Author'].'</p><p style="grid-area: 2/2/3/3;"><span>Genre : </span>'.$row['Genre'].'</p><p style="grid-area: 3/1/4/3;"><span>Språk : </span>'.$row['Language'].'</p><p style="grid-area: 3/2/4/3;"><span>Antal exemplar : </span>'.$row['Quantity'].' st</p><p style="grid-area: 4/1/5/2;"><i>'.$row['TryckBolag'];
                        if(empty($row['TryckBolag']) || empty($row['TryckYear'])){}else{echo ' , ';}
                        echo $row['TryckYear'].'</i></p></div>';
                        $aResultRow++;
                    }
                    echo '</div>';
                }
                else{
                    echo '<script>document.getElementById("Container").style.gridTemplateRows = "repeat(4, 1fr)";</script><div class="SearchedResults" style="grid-row: 3/4;"><h2 style="justify-self: center;
    align-self: center;">There was no search results on "'.$searchq.'".</h2></div>';
                }
            }else{
                echo '<script>document.getElementById("Container").style.gridTemplateRows = "repeat(4, 1fr)";</script><div class="SearchedResults" style="grid-row: 3/4;"><h1 style="justify-self: center;
    align-self: center;">Please Enter Something!!</h1></div>';
             }
            
         }else{ 
            echo '<div class="SearchBox">
                    <h1>Katalog</h1>
                    <form action="index.php" method="get">
                        <span>Sök:</span>
                        <input autocomplete="off" name="Searched" type="search" size="40">
                        <button type="submit" class="Buttons searchbutton">Go</button>
                    </form>
                  </div>';
            }
    
        if(!isset($_SESSION['Isloggedin'])){
        echo '<div class="LoginBox">
        <div>
            <span style="justify-self: center; align-self: center;">Min profil :</span>
            <button class="Buttons" onclick="LoginModalDisplay(1)">Loggga in</button>
        </div>
    </div>
    
    <div class="Modal">
        <span class="CloseModalX" onclick="LoginModalDisplay(0)">&times;</span>
        <div class="ModalContent">
            <h1 style="grid-area: 1/1/2/3; justify-self: center;
    align-self: center;">Logga in</h1>
            <form class="LoginForm" action="includes/login.inc.php" method="post">
                <span style="grid-area: 1/1/2/3; font-size: 16px; justify-self: center; align-self: center;">
                    Du kan använda epostadress eller användarnamn för att logga in</span>
                <input type="text" autocomplete="off" style="grid-area: 2/1/3/3;" placeholder="Användarnamn Eller E-mail....">
                <input type="password" autocomplete="off" style="grid-area: 3/1/4/3;" placeholder="Lösenord....">
            </form>
            <button style="grid-area: 4/1/5/2;" class="Buttons" onclick="LoginModalDisplay(0)">Cancel</button>
            <button style="grid-area: 4/2/5/3;" type="submit" class="Buttons" onclick="SubmitLoginForm()">Logga in</button>
        </div>
    </div>
    
    ';
    }
    else{
        echo '<div class="LoginBox">
        <div>
            <a href="profile.php"><button class="Buttons">Min profil</button></a>
            <a href="includes/logout.inc.php?logginout"><button class="Buttons">Loggga ut</button></a>
        </div>
    </div>';
    }
    ?>




</div>

<script>
    function LoginModalDisplay(NumValue) {
        if (NumValue > 0) {
            document.getElementsByClassName("Modal")[0].style.display = "grid";
        } else {
            document.getElementsByClassName("Modal")[0].style.display = "none";
        }
    }

    function SubmitLoginForm() {
        document.getElementsByClassName("LoginForm")[0].submit();
    }

</script>

<?php
    require'footer.php';
    
?>
