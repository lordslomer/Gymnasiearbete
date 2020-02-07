<?php
    require 'header.php';
    if(!isset($_SESSION['Isloggedin'])){
        
        header('location: index.php?');
        exit();
        
    }
     
?>

<div id="Container" style="grid-template-rows: repeat(8, 1fr);">

    <button class="Buttons" style="grid-column: 1/3; grid-row: 1/2; justify-self: center;
    align-self: center; text-decoration: none;" onclick="history.back(-1)">&laquo; Tillbaka</button>

    <div class="SubSearchBox">
        <form action="index.php" method="get">
            <span>Sök:</span>
            <input class="Inputs" autocomplete="off" name="Searched" type="search" size="40">
            <button type="submit" class="Buttons searchbutton">Go</button>
        </form>
    </div>


    <div class="LoginBox">
        <div style="grid-template-columns: 1fr;">
            <button onclick="LoginModalDisplay(1)" class="Buttons">Logga ut</button>
        </div>
    </div>

    <div class="Modal" style="background-color: rgba(0, 0, 0, 0.4); grid-template-rows: repeat(3,1fr);">
        <span style="grid-area: 2/2/3/3; align-self: start; justify-self: end; margin-right: 13%;
    margin-top: 5%;" class="CloseModalX" onclick="LoginModalDisplay(0)">&times;</span>
        <div class="ModalContent" style="grid-area: 2/2/3/3; grid-template: repeat(2, 1fr) / repeat(2, 1fr); grid-gap:0px; grid-column-gap: 50px; grid-row-gap: 20px; justify-self: center; align-self: center; padding: 20px;">
            <span style="grid-area: 1/1/2/3; justify-self:center; align-self: end;">Är du säker du vill logga ut ?</span>
            <button style="grid-area: 2/2/3/3; justify-self:start; align-self: start;" class="Buttons" onclick="LoginModalDisplay(0)">Avbryt</button>
            <form action="includes/logout.inc.php" method="post" style="grid-area: 2/1/3/2; justify-self:end; align-self: start;"><input type="submit" name="LogoutSubmit" class="Buttons" value="Logga ut"></form>
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

    <!-- Functions of the profile page-->
    <div class="FunctionsBox">
        <button class="Buttons" onclick="DisplayFunctionBoxes(0)" style="grid-area: 1/1/2/2;">Mina Utlån</button>
        <button class="Buttons" onclick="DisplayFunctionBoxes(2)" style="grid-area: 1/3/2/4;">Redigera Arkivet</button>
        <button class="Buttons" onclick="DisplayFunctionBoxes(1)" style="grid-area: 1/2/2/3;">Redigera Utlån</button>
        <button class="Buttons" onclick="DisplayFunctionBoxes(3)" style="grid-area: 1/4/2/5;">Redigera AnvändaKonto</button>

        <div class="FuntionBox">HERE IS Funtion 1</div>

        <div class="FuntionBox">HERE IS Funtion 2</div>

        <div class="FuntionBox">HERE IS Funtion 3</div>

        <div class="FuntionBox" <?php if(isset($_GET['signupaddstatus'])){echo 'style="display:grid;"';}?>>

            <form class="SingupForm" method="post" action="includes/users.inc.php">
                <span style="grid-area: 1/1/2/3;">
                    <p style="font-size: 24px;">Lägg till användare</p>
                    <p style="font-size: 14px; font-weight: none;">Välj användare från tablen för att rediagre eller radera användarens Info.</p>
                </span>
                <?php 
                    
                        if(isset($_GET['signupaddstatus'])){
                            if(is_array($_GET['signupaddstatus'])){
                                for ($i = 0; $i < count($_GET['signupaddstatus']); $i++){
                                    
                                    if($_GET['signupaddstatus'][$i] == 'invalidFname'){
                                        $FnameError = 'Bara bokstäver i Förnamnet';
                                    }
                                    else if($_GET['signupaddstatus'][$i] == 'invalidLname'){
                                        $LnameError = 'Bara bokstäver i Efternamnet';
                                    }
                                    else if($_GET['signupaddstatus'][$i] == 'invalidEmail'){
                                        $EmailEroor = 'Ogiltig Epostadress';
                                    }
                                    else if($_GET['signupaddstatus'][$i] == 'invalidPwd'){
                                        echo '<p class="errors2">Pin-koden måste vara 6-siffrig</p>';
                                    }
                                    else if($_GET['signupaddstatus'][$i] == 'invalidType'){
                                        echo '<p class="errors2">Ogiltig Konto typ</p>';
                                    }
                                }
                            }else{
                                if($_GET['signupaddstatus'] == 'success'){
                                    echo '<p class="errors2" style="color:green;">Användaren har lagts till</p>'; 
                                }else{
                                    switch ($_GET['signupaddstatus']){
                                        case 'emailtaken':
                                            echo '<p class="errors2">Epostadress redan tagen !</p>';
                                            break;
                                        case 'emptyfields':
                                            echo '<p class="errors2">Fyll i allt !</p>';
                                            break;
                                        case 'invalidFname':
                                            echo '<p class="errors2">Bara bokstäver i Förnamnet !</p>';
                                            $FnameError = 'Fel Format';
                                            break;
                                        case 'invalidLname':
                                            echo '<p class="errors2">Bara bokstäver i Efternamnet !</p>';
                                            $LnameError = 'Fel Format';
                                            break;
                                        case 'invalidEmail':
                                            echo '<p class="errors2">Ogiltig Epostadress !</p>';
                                            $EmailEroor = 'Fel Format';
                                            break;
                                        case 'invalidPwd':
                                            echo '<p class="errors2">Pin-koden måste vara 6-siffrig !</p>';
                                            break;
                                        case 'invalidType':
                                            echo '<p class="errors2">Ogiltig Konto typ !</p>';
                                            break;
                                        default:
                                            break;
                                    }
                                }
                            }
                        } 
                    
                    ?>
                <span style="grid-area: 2/1/3/3; justify-self:center; align-self:end;">
                    <p>Förenamn</p>
                    <input class="Inputs" autocomplete="off" name="Fname" type="text" value="<?php
                    if(isset($FnameError)){
                        echo $FnameError.'" style="color:red;';
                    }else if(isset($_GET['Fname'])){echo $_GET['Fname'];}?>" onclick="InputColorWhite(event)" placeholder="Förenamn" onkeypress="return /[a-zA-Z]/i.test(event.key)" required>
                </span>
                <span style="grid-area: 3/1/4/3; justify-self:center; align-self:end;">
                    <p>Efternamn</p>
                    <input class="Inputs" autocomplete="off" name="Lname" type="text" value="<?php
                    if(isset($LnameError)){
                        echo $LnameError.'" style="color:red;';
                    }else if(isset($_GET['Lname'])){echo $_GET['Lname'];}?>" onclick="InputColorWhite(event)" placeholder="Efternamn" onkeypress="return /[a-zA-Z]/i.test(event.key)" required>
                </span>
                <span style="grid-area: 4/1/5/3; justify-self:center; align-self:end;">
                    <p>Epostadress</p>
                    <input class="Inputs" autocomplete="off" name="Email" type="email" value="<?php
                    if(isset($EmailEroor)){
                        echo $EmailEroor.'" style="color:red;';
                    }else if(isset($_GET['Email'])){echo $_GET['Email'];}?>" onclick="InputColorWhite(event)" placeholder="Email@example.com" required>
                </span>
                <span style="grid-area: 5/1/6/3; justify-self:center; align-self:end;">
                    <p>6-siffrig Pin-kod</p>
                    <input class="Inputs pinCode" autocomplete="off" name="Pwd" type="password" maxlength="6" placeholder="XX-XX-XX" onkeypress="return /[0-9]/i.test(event.key)" required>
                </span>
                <?php 
                    
                        if(isset($_GET['signupaddstatus'])){
                            if(is_array($_GET['signupaddstatus'])){
                                for ($i = 0; $i < count($_GET['signupaddstatus']); $i++){
                                    
                                    if($_GET['signupaddstatus'][$i] == 'invalidFname'){
                                        $FnameError = 'Inga mellanrum i Förnamnet';
                                    }
                                    else if($_GET['signupaddstatus'][$i] == 'invalidLname'){
                                        $LnameError = 'Inga mellanrum i Efternamnet';
                                    }
                                    else if($_GET['signupaddstatus'][$i] == 'invalidEmail'){
                                        $EmailEroor = 'Ogiltig Epostadress';
                                    }
                                    else if($_GET['signupaddstatus'][$i] == 'invalidPwd'){
                                        echo '<p class="errors1">Pin-koden måste vara 6-siffrig</p>';
                                    }
                                    else if($_GET['signupaddstatus'][$i] == 'invalidType'){
                                        echo '<p class="errors1">Ogiltig Konto typ</p>';
                                    }
                                }
                            }else{
                                if($_GET['signupaddstatus'] == 'success'){
                                    echo '<p class="errors1" style="color:green;">Användaren har lagts till</p>'; 
                                }else{
                                    switch ($_GET['signupaddstatus']){
                                        case 'emptyfields':
                                            echo '<p class="errors1">Fyll i allt !</p>';
                                            break;
                                        case 'invalidFname':
                                            echo '<p class="errors1">Inga mellanrum i Förnamnet !</p>';
                                            $FnameError = 'Fel Format';
                                            break;
                                        case 'invalidLname':
                                            echo '<p class="errors1">Inga mellanrum i Efternamnet !</p>';
                                            $LnameError = 'Fel Format';
                                            break;
                                        case 'invalidEmail':
                                            echo '<p class="errors1">Ogiltig Epostadress !</p>';
                                            $EmailEroor = 'Fel Format';
                                            break;
                                        case 'invalidPwd':
                                            echo '<p class="errors1">Pin-koden måste vara 6-siffrig !</p>';
                                            break;
                                        case 'invalidType':
                                            echo '<p class="errors1">Ogiltig Konto typ !</p>';
                                            break;
                                        default:
                                            break;
                                    }
                                }
                            }
                        } 
                    
                    ?>
                <span style="grid-area: 6/1/7/3; font-size: 16px; font-weight: none; justify-self:center; align-self:end">
                    <p style="font-size: 22px;">Typ av användare</p>
                    <input autocomplete="off" name="Type" type="radio" <?php if(isset($_GET['Type']) && $_GET['Type'] == 'Admin'){ echo 'checked';} ?> value="Admin">
                    <span>Administratör</span>
                    <input autocomplete="off" pattern="[0-9]" <?php if(isset($_GET['Type'])){
        if($_GET['Type'] != 'Admin'){
    echo 'checked';
        }
    }else{
    echo 'checked';
    } ?> name="Type" type="radio" value="nonAdmin">
                    <span>Elev</span>
                </span>
                <span style="grid-area: 7/1/8/3; justify-self:center; align-self:center">
                    <input type="submit" name="userAdd" class="Buttons" value="Lägg till">
                    <input type="submit" name="userEdit" class="Buttons" value="Rediagre">
                    <input type="submit" name="userDelete" class="Buttons" value="Radera">
                </span>
            </form>

            <table>
                <thead>
                    <tr>
                        <th></th>
                    </tr>
                </thead>
            </table>

        </div>

    </div>

</div>

<script>
    function InputColorWhite(event) {
        event.target.style.color = "black";
    }

    function DisplayFunctionBoxes(NumValue) {
        var FunctionBoxes = document.getElementsByClassName("FuntionBox");
        for (var i = 0; i < FunctionBoxes.length; i++) {
            if (NumValue === i) {
                FunctionBoxes[i].style.display = "grid";
            } else {
                FunctionBoxes[i].style.display = "none";
            }
        }
    }

</script>

<?php
    require 'footer.php';
?>
