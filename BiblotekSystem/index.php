<?php 
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
}
    require'db/db.inc.php';

    require'header.php';
?>



<div id="Container">
    <?php
        if(isset($_POST['SearchInput'])){
            echo '<a href="index.php" style="grid-column: 1/3; grid-row: 1/2; justify-self: center;
    align-self: center; text-decoration: none;"><button class="Buttons">&laquo; Tillbaka</button></a>
            <div class="SubSearchBox">
                    <form action="index.php" method="post">
                        <span>Sök:</span>
                        <input autocomplete="off" name="SearchInput" type="text" size="40">
                        <button type="submit" class="Buttons searchbutton">Go</button>
                    </form>
                </div>';
            
            $searchq = test_input($_POST['SearchInput']);
            if(!empty($searchq)){

                $sql = "SELECT * FROM arkiv WHERE Titel LIKE '%$searchq%' OR Author LIKE '%$searchq%' OR TryckBolag  LIKE '%$searchq%' OR TryckYear LIKE '%$searchq%' OR Genre LIKE '%$searchq%' OR Language LIKE '%$searchq%'";
                $result = mysqli_query($con, $sql);
                $resultAmount = mysqli_num_rows($result);

                if($resultAmount > 0){
                    $aResultRow = 1;
                    echo '<script>document.getElementById("Container").style.gridTemplateRows = "repeat('.($resultAmount + 3).', 1fr)";</script><p style="grid-area: 2/2/3/10; align-self: end;"><span>Hittade '.$resultAmount.' resultat för ordet "'.$searchq.'".</span></p><div class="SearchedResults" style="grid-template-rows: repeat('.$resultAmount.', 1fr);  grid-row: 3/'.($resultAmount + 3).';">';
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
                    <form action="index.php" method="post">
                        <span>Sök:</span>
                        <input autocomplete="off" name="SearchInput" type="text" size="40">
                        <button type="submit" class="Buttons searchbutton">Go</button>
                    </form>
                  </div>';
            }
    ?>

    <div class="LoginBox">
        <div>
            <span>Min profil :</span>
            <button class="Buttons">Loggga in</button>
        </div>
    </div>
</div>


<?php
    require'footer.php';
    
?>
