<?php 
    require'header.php';
?>


<div id="Container">
    <?php
    
        function strtolower_utf8($inputString) {
            $outputString = utf8_decode($inputString);
            $outputString = strtolower($outputString);
            $outputString = utf8_encode($outputString);
            return $outputString;
        }
    
        if(isset($_GET['Searched'])){
            $_SESSION['Searched'] = $_GET['Searched'];
            echo ' <button class="Buttons" style="grid-column: 1/3; grid-row: 1/2; justify-self: center;
    align-self: center; text-decoration: none;" onclick="history.back(-1)">&laquo; Tillbaka</button>
            <div class="SubSearchBox">
                    <form action="index.php" method="get">
                        <span>Sök:</span>
                        <input class="Inputs" onfocus="onloadInputs(1)" autocomplete="off" name="Searched" type="search" size="40">
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
                    while($row = mysqli_fetch_array($result)){
                        echo '<div class="aResult" style="grid-row: '.$aResultRow.' / '.($aResultRow + 1).';"><p style="font-size: 22px; grid-area: 1/1/2/4;"><span>Titel : </span>'.str_replace(strtolower_utf8( $searchq), '<span style="color:red;">'.$searchq.'</span>', strtolower_utf8( $row['Titel'])).'</p><p style="grid-area: 2/1/3/2;"><span>Förfatare : </span>'.str_replace(strtolower_utf8( $searchq), '<span style="color:red;">'.$searchq.'</span>', strtolower_utf8( $row['Author'])).'</p><p style="grid-area: 2/2/3/3;"><span>Genre : </span>'.str_replace(strtolower_utf8( $searchq), '<span style="color:red;">'.$searchq.'</span>', strtolower_utf8( $row['Genre'])).'</p><p style="grid-area: 3/1/4/3;"><span>Språk : </span>'.str_replace(strtolower_utf8( $searchq), '<span style="color:red;">'.$searchq.'</span>', strtolower_utf8( $row['Language'])).'</p><p style="grid-area: 3/2/4/3;"><span>Antal exemplar : </span>'.$row['Quantity'].' st</p><p style="grid-area: 4/1/5/2;"><i>'.str_replace(strtolower_utf8($searchq),'<span style="color:red;">'.$searchq.'</span>',strtolower_utf8($row['TryckBolag']));
                        if(empty($row['TryckBolag']) || empty($row['TryckYear'])){}else{echo ' , ';}
                        echo str_replace(strtolower_utf8( $searchq), '<span style="color:red;">'.$searchq.'</span>', strtolower_utf8( $row['TryckYear'])).'</i></p></div>';
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
                        <input class="Inputs" onfocus="onloadInputs(1)" autocomplete="off" name="Searched" type="search" size="40">
                        <button type="submit" class="Buttons searchbutton">Go</button>
                    </form>
                  </div>';
            }
    $Emailerror = '"';
    $errormsg = '">Du kan använda epostadress eller användarnamn för att logga in.';
    
        if(!isset($_SESSION['UserID'])){
            if(isset($_GET['loginerror'])){ 
                $showbox = 'style="display:grid;"';
                
                if(isset($_GET['UserEmail'])){
                    $Emailerror = '" value="'.$_GET['UserEmail'].'"';
                }else{ $Emailerror = '"';}
                
                
                switch($_GET['loginerror']){
                        
                    case 'emptyuseremail':
                        $errormsg = ' color: red;">Fyll i Användarefältet !';
                        $Emailerror = ' color:red;" value="Fyll i...."';
                        break;
                        
                    case 'emptypwd':
                        $errormsg = 'color: red;"> Fyll i Pin-koden !';
                        break;
                    case 'wrongpwd':
                        $errormsg = 'color: red;">Fel Pin-kod !';
                        break;
                    case 'nouser':
                        $errormsg = 'color: red;">Anvädarenamnet eller Epostadressen finns inte !';
                         break;
                    default:
                        $errormsg = '">Du kan använda epostadress eller användarnamn för att logga in.';
                        break;
                }
            }else{$showbox = "";}
            
        echo '<div class="LoginBox">
        <div>
            <span style="justify-self: center; align-self: center;">Min profil :</span>
            <button class="Buttons" onclick="LoginModalDisplay(1)">Logga in</button>
        </div>
    </div>
    
    <div class="Modal" '.$showbox.' >
        <span class="CloseModalX" onclick="LoginModalDisplay(0)">&times;</span>
        <div class="ModalContent">
            <h1 style="grid-area: 1/1/2/3; justify-self: center;
    align-self: center;">Logga in</h1>
            <form class="LoginForm" action="includes/login.inc.php" method="post">
                <span style="text-align:center; grid-area: 1/1/2/3; font-size: 16px; justify-self: center; align-self: center;'.$errormsg.'</span>
                <input class="Inputs" onfocus="onloadInputs(3)" type="text" name="UserEmail" autocomplete="off" style="grid-area: 2/1/3/3;'.$Emailerror.' placeholder="Användarnamn Eller Epostadress" onclick="InputColorWhite(event)" required>
                <input class="Inputs pinCode" onfocus="onloadInputs(3)" name="Pwd" maxlength="6" type="password" autocomplete="off" style="grid-area: 3/1/4/3;" placeholder="Pin-Kod : XX-XX-XX" onkeypress="return /[0-9]/i.test(event.key)" required>
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
            <button onclick="LoginModalDisplay(1)" class="Buttons">Logga ut</button>
        </div>
    </div>
    
    <div class="Modal" style="background-color: rgba(0, 0, 0, 0.4); grid-template-rows: repeat(3,1fr);">
        <span  style="grid-area: 2/2/3/3; align-self: start; justify-self: end; margin-right: 13%;
    margin-top: 5%;" class="CloseModalX" onclick="LoginModalDisplay(0)">&times;</span>
        <div class="ModalContent" style="grid-area: 2/2/3/3; grid-template: repeat(2, 1fr) / repeat(2, 1fr); grid-gap:0px; grid-column-gap: 50px; grid-row-gap: 20px; justify-self: center; align-self: center; padding: 20px;">
            <span style="grid-area: 1/1/2/3; justify-self:center; align-self: end;">Är du säker du vill logga ut ?</span>
            <button style="grid-area: 2/2/3/3; justify-self:start; align-self: start;" class="Buttons" onclick="LoginModalDisplay(0)">Avbryt</button>
            <form action="includes/logout.inc.php" method="post" style="grid-area: 2/1/3/2; justify-self:end; align-self: start;"><input type="submit" name="LogoutSubmit" class="Buttons" value="Logga ut"></form>
        </div>
    </div>
    
    ';
    }
    ?>




</div>

<?php
    require'footer.php';
    
?>
