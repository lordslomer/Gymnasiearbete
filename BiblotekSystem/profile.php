<?php
    require 'header.php';
    if(!isset($_SESSION['UserID'])){
        
        header('location: index.php?');
        exit();
        
    }else if($_SESSION['Type'] != 'Admin'){
        header('location: subprofile.php');
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
            <p style="font-size: 22px; grid-area: 1/1/2/4; justify-self: center; align-self: center;"><span>Namn : </span><?php
                echo $_SESSION['Fname'].' '.$_SESSION['Lname'];?></p>
            <span style="justify-self: center; align-self: center; grid-area: 2/2/3/3; font-size:22px; border-bottom: 2px solid black;">Användarnamn</span>
            <p style="justify-self: center; align-self: start; grid-area: 3/2/4/3;"><?php
                echo $_SESSION['Username'];?></p>
            <span style="justify-self: center; align-self: center; grid-area: 2/3/3/4; font-size:22px; border-bottom: 2px solid black;">Epostadress</span>
            <p style="justify-self: center; align-self: start; grid-area: 3/3/4/4;"><?php
                echo $_SESSION['Email'];?></p>
            <form action="changeinfo.php" method="post" target="hehe" style="grid-area: 2/1/4/2; justify-self: center; align-self: center;"><button class="Buttons" name="passBtn" type="button" onclick="popupsubmitForm('logged')">Ändra <br> Pin-kod</button></form>
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

        <div class="FuntionBox" <?php if(isset($_GET['signupaddstatus']) || isset($_GET['userspage']) || isset($_GET['changedEmail']) || isset($_GET['sortTable']) && $_GET['sortTable'][0] == 0){echo 'style="display:grid;"';}?>>
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
                    }else if(isset($_GET['Fname'])){echo $_GET['Fname'];}?>" onclick="InputColorWhite(event)" placeholder="Förenamn" onkeypress="return /[a-öA-Ö]/i.test(event.key)" required>
                </span>
                <span style="grid-area: 3/1/4/3; justify-self:center; align-self:end;">
                    <p>Efternamn</p>
                    <input class="Inputs" autocomplete="off" name="Lname" type="text" value="<?php
                    if(isset($LnameError)){
                        echo $LnameError.'" style="color:red;';
                    }else if(isset($_GET['Lname'])){echo $_GET['Lname'];}?>" onclick="InputColorWhite(event)" placeholder="Efternamn" onkeypress="return /[a-öA-Ö]/i.test(event.key)" required>
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
                    } ?> name="Type" type="radio" value="none">
                    <span>Elev</span>
                </span>
                <span style="grid-area: 7/1/8/3; justify-self:center; align-self:center">
                    <input type="submit" name="userAdd" class="Buttons scrolltobtns" value="Lägg till">
                    <input style="display:none;" type="submit" name="userEdit" class="Buttons" value="Rediagre">
                    <input style="display:none;" type="submit" name="userDelete" class="Buttons" value="Radera">
                </span>
            </form>

            <div style="display: grid; grid-template-rows: 32px auto; grid-gap: 5px; padding: 5px;">

                <input type="search" class="Inputs tableSearchbox" oninput="SreachFilter(3,0)" placeholder="Sök.." autocomplete="off">
                <?php
                
                $columnFname = 'Förenamn';
                $columnLname = 'Efternamn';
                $columnEmail = 'Epostadress';
                $columnType = 'Typ';
                
                if(isset($_GET['sortTable']) && $_GET['sortTable'][0] == 0){
                    $column = substr($_GET['sortTable'], 1);
                    
                    switch ($column){
                        case $columnFname:
                            $column = ' ORDER BY Fname';
                            $columnFname = $columnFname.' &#8659;';
                            break;
                        case $columnLname:
                            $column = " ORDER BY Lname";
                            $columnLname = $columnLname.' &#8659;';
                            break;
                        case $columnEmail:
                            $column = " ORDER BY Email";
                            $columnEmail = $columnEmail.' &#8659;';
                            break;
                        case $columnType:
                            $column = " ORDER BY Type";
                            $columnType = $columnType.' &#8659;';
                            break;
                        default:
                            $column = " ";
                            break;
                    }
                    
                }
                
                $sql = "SELECT * FROM users WHERE UserID !=".$_SESSION['UserID'];
                $result = mysqli_query($con, $sql);

                
                $resultAmount = mysqli_num_rows($result);
                if($resultAmount > 0){
                echo '<div>
                    <table class="subtables" style="width: 100%;">
                        <thead>
                            <tr>
                                <th onclick="sortTable(0)">'.$columnFname.'</th>
                                <th onclick="sortTable(0)">'.$columnLname.'</th>
                                <th onclick="sortTable(0)">'.$columnEmail.'</th>
                                <th onclick="sortTable(0)">'.$columnType.'</th>
                            </tr>
                        </thead><tbody class="tableBody">';
                            
                        $results_per_page = 1;
                        $number_of_pages = ceil($resultAmount / $results_per_page);
                    
                        if(!isset($_GET['userspage'])){
                            $page = 1;
                        }else{
                            $page = $_GET['userspage'];
                        }
                    
                        $startinglimitNumber = ($page - 1 ) * $results_per_page;
                        if(isset($column)){
                        $sqlp = "SELECT * FROM users WHERE UserID !=".$_SESSION['UserID']." ".$column." LIMIT ".$startinglimitNumber.",".$results_per_page;
                        }else{
                        $sqlp = "SELECT * FROM users WHERE UserID !=".$_SESSION['UserID']." LIMIT ".$startinglimitNumber.",".$results_per_page;
                            
                        }

                        $resultp = mysqli_query($con, $sqlp);
                        $resultAmountonpage = mysqli_num_rows($resultp);
                        while($rows = mysqli_fetch_assoc($resultp)){
                            echo '<tr onclick="GetRowValues(event)">
                                <td>'.$rows['Fname'].'</td>
                                <td>'.$rows['Lname'].'</td>
                                <td>'.$rows['Email'].'</td>
                                <td>'.$rows['Type'].'</td>
                            </tr>';
                        
                            }
                            echo'</tbody>
                    </table><span>Sida '.$page.' av '.$number_of_pages.' , '.($resultAmountonpage + $startinglimitNumber).' av '.$resultAmount.' Användare</span><div style="text-align: center;">';
                        if($number_of_pages > 1){
                            if($number_of_pages <= 5){
                                for($page = 1; $page <=$number_of_pages; $page++){ echo '<a style="margin: 0px 10px;;" href="profile.php?userspage=' .$page.'"><button class="Buttons">'.$page.'</button></a>';
                                    }
                            }else{
                                
                                echo $page;    
                                
                            }
                        }
                            echo '</div>
                </div>';
                    }
                ?>
            </div>

        </div>

    </div>

</div>

<script>
    function popupsubmitForm(Type) {
        if (Type == "logged") {
            cureentPage = window.document;
            localStorage.setItem("Firstpage", cureentPage);
            titleInpue = document.createElement("INPUT");
            event.target.parentElement.appendChild(titleInpue);
            titleInpue.setAttribute('type', 'text');
            titleInpue.setAttribute('name', 'changeinfo');
            titleInpue.setAttribute('value', event.target.innerHTML);

            typeInput = document.createElement("INPUT");
            event.target.parentElement.appendChild(typeInput);
            typeInput.setAttribute('type', 'text');
            typeInput.setAttribute('name', 'userType');
            typeInput.setAttribute('value', Type);

            window.open('changeinfo.php', 'hehe', 'width=600,height=480,top=210,left=500');
            event.target.parentElement.submit();
            titleInpue.remove();
            typeInput.remove();

        } else {
            newForm = document.createElement("FORM");
            newForm.setAttribute('action', 'changeinfo.php');
            newForm.setAttribute('method', 'post');
            newForm.setAttribute('target', 'hehe');
            document.body.appendChild(newForm);

            titleInpue = document.createElement("INPUT");
            newForm.appendChild(titleInpue);
            titleInpue.setAttribute('type', 'text');
            titleInpue.setAttribute('name', 'changeinfo');
            titleInpue.setAttribute('value', event.target.innerHTML);

            typeInput = document.createElement("INPUT");
            newForm.appendChild(typeInput);
            typeInput.setAttribute('type', 'text');
            typeInput.setAttribute('name', 'userType');
            typeInput.setAttribute('value', Type);

            window.open('changeinfo.php', 'hehe', 'width=600,height=480,top=210,left=500');
            newForm.submit();
            newForm.remove();
        }
    }

    var OldValues = [];
    var HeaderTitel = '';

    function sortTable(TableNumber) {
        var columnTitle = event.target.innerHTML;
        var getRidof = '<?php if(isset($_GET['sortTable'])){ echo 'sortTable='.$_GET['sortTable']; }else{ echo 'DoNotRunStringReplaceCodeOnGetRidofPlzzzz';} ?>';
        var oldUrl = decodeURIComponent(window.location.href).replace(decodeURIComponent(window.location.search), "");
        console.log(window.location.href);
        var str = decodeURIComponent(window.location.search);
        var checkif = str.includes("?");
        if (checkif) {
            str = str.replace("?", "");
            if (str.length > 0) {

                var checkifValueexists = str.includes(getRidof);
                while (checkifValueexists) {
                    str = str.replace(getRidof, "");
                    checkifValueexists = str.includes(getRidof);
                }
                var stringstart = str.substring(0, 1);
                var checkifand = stringstart.includes("&");
                while (checkifand) {
                    str = str.replace(stringstart, "");
                    stringstart = str.substring(0, 1);
                    checkifand = stringstart.includes("&");
                }
                var newUrl = oldUrl + "?sortTable=" + TableNumber + columnTitle + '&' + str;
            } else {
                var newUrl = oldUrl + "?sortTable=" + TableNumber + columnTitle;
            }
        } else {
            if (oldUrl.includes("?")) {
                var newUrl = oldUrl + "sortTable=" + TableNumber + columnTitle;
            } else {
                var newUrl = oldUrl + "?sortTable=" + TableNumber + columnTitle;
            }
        }
        console.log(newUrl);
        window.location.replace(newUrl);
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

    document.getElementsByClassName('scrolltobtns')[0].addEventListener("load", AutoScroll());

    function AutoScroll() {
        var isTrue = <?php if(isset($_GET['signupaddstatus']) || isset($_GET['userspage']) || isset($_GET['changedEmail']) || isset($_GET['sortTable']) && $_GET['sortTable'][0] == 0){echo '"true";';} else{echo '"false";';}?>
        if (isTrue == 'true') {
            document.getElementsByClassName('scrolltobtns')[0].scrollIntoView();
        }
    }



    function GetRowValues(event) {
        var foucesedRow = document.getElementById("foucesedTr");
        if (typeof(foucesedRow) != 'undefined' && foucesedRow != null && foucesedRow.tagName == 'TR') {
            foucesedRow.removeAttribute('id');
            foucesedRow.children[0].setAttribute('style', '');
            foucesedRow.children[3].setAttribute('style', '');
        }
        event.target.parentElement.setAttribute('id', 'foucesedTr');
        event.target.parentElement.children[0].setAttribute('style', 'border-left: 3px solid black;');
        event.target.parentElement.children[3].setAttribute('style', 'border-right: 3px solid black;');

        var errorelemnt1 = document.getElementsByClassName('errors2')[0];
        var errorelemnt2 = document.getElementsByClassName('errors1')[0];
        if (typeof(errorelemnt1) != 'undefined' && errorelemnt1 != null) {
            errorelemnt1.remove();
            errorelemnt2.remove();
        }
        document.getElementsByName("Fname")[0].value = event.target.parentElement.children[0].innerHTML;
        document.getElementsByName("Lname")[0].value = event.target.parentElement.children[1].innerHTML;
        document.getElementsByName("Email")[0].value = event.target.parentElement.children[2].innerHTML;
        var TypeValue = event.target.parentElement.children[3].innerHTML;
        if (TypeValue == 'Admin') {
            document.getElementsByName("Type")[0].checked = true;
        } else {
            document.getElementsByName("Type")[1].checked = true;
        }

        document.getElementsByClassName('SingupForm')[0].children[4].style.display = 'none';
        document.getElementsByClassName('SingupForm')[0].children[4].children[1].required = false;
        document.getElementsByClassName('SingupForm')[0].children[5].style.gridArea = '5/1/6/3';
        document.getElementsByClassName('SingupForm')[0].children[6].style.gridArea = '6/1/7/3';

        if (document.getElementsByClassName('SingupForm')[0].children[6].children.length < 4) {

            document.getElementsByClassName('SingupForm')[0].children[6].children[0].style.display = "none";
            document.getElementsByClassName('SingupForm')[0].children[6].children[1].style.display = "inline";
            document.getElementsByClassName('SingupForm')[0].children[6].children[2].style.display = "inline";
            var newBtn = document.createElement("SPAN");
            newBtn.innerHTML = "« lägg till";
            newBtn.setAttribute('class', 'Buttons');
            newBtn.setAttribute('onclick', 'ReverseRowValues()');
            document.getElementsByClassName('SingupForm')[0].children[6].insertBefore(newBtn, document.getElementsByClassName('SingupForm')[0].children[6].children[0]);
        }

        if (document.getElementsByClassName('SingupForm')[0].children[4].style.display = 'none') {
            if (document.getElementsByClassName('SingupForm')[0].children.length > 7) {
                document.getElementsByClassName('SingupForm')[0].children[7].remove();
                document.getElementsByClassName('SingupForm')[0].children[7].remove();
            }
            var passBtn = document.createElement("BUTTON");
            passBtn.innerHTML = "Ändra <br> Pin-kod";
            passBtn.setAttribute('class', 'Buttons scrolltobtns');
            passBtn.setAttribute('type', 'button');
            passBtn.setAttribute('onclick', 'popupsubmitForm("' + document.getElementsByName("Email")[0].value + '")');
            document.getElementsByClassName('SingupForm')[0].appendChild(passBtn);
            passBtn.style.fontSize = '16px';
            passBtn.style.alignSelf = 'center';

            var usernameBtn = document.createElement("BUTTON");
            usernameBtn.innerHTML = "Ändra <br> Änvandarenamn";
            usernameBtn.setAttribute('class', 'Buttons scrolltobtns');
            usernameBtn.setAttribute('type', 'button');
            usernameBtn.setAttribute('onclick', 'popupsubmitForm("' + document.getElementsByName("Email")[0].value + '")');
            document.getElementsByClassName('SingupForm')[0].appendChild(usernameBtn);
            usernameBtn.style.fontSize = '16px';
            usernameBtn.style.alignSelf = 'center';

            document.getElementsByClassName('SingupForm')[0].style.gridColumnGap = "10px";
        }
    }

    function ReverseRowValues() {
        var foucesedRow = document.getElementById("foucesedTr");
        foucesedRow.removeAttribute('id');
        foucesedRow.children[0].setAttribute('style', '');
        foucesedRow.children[3].setAttribute('style', '');
        document.getElementsByName("Fname")[0].value = '';
        document.getElementsByName("Lname")[0].value = '';
        document.getElementsByName("Email")[0].value = '';
        document.getElementsByName("Type")[1].checked = true;
        document.getElementsByClassName('SingupForm')[0].children[4].setAttribute('style', 'grid-area: 5/1/6/3;justify-self:center;align-self:end;');
        document.getElementsByClassName('SingupForm')[0].children[4].children[1].required = true;
        document.getElementsByClassName('SingupForm')[0].children[5].style.gridArea = '6/1/7/3';
        document.getElementsByClassName('SingupForm')[0].children[6].style.gridArea = '7/1/8/3';
        document.getElementsByClassName('SingupForm')[0].children[6].children[1].style.display = "inline";
        document.getElementsByClassName('SingupForm')[0].children[6].children[2].style.display = "none";
        document.getElementsByClassName('SingupForm')[0].children[6].children[3].style.display = "none";


        document.getElementsByClassName('SingupForm')[0].children[6].children[0].remove();
        document.getElementsByClassName('SingupForm')[0].children[7].remove();
        document.getElementsByClassName('SingupForm')[0].children[7].remove();
    }

    function SreachFilter(BoxNumber, PageNumber) {
        var searchTxt = document.getElementsByClassName("tableSearchbox")[0];
        if (PageNumber == 0) {
            PageNumber = 1;
        }
        $.post("includes/searchtables.inc.php", {
            searchVal: searchTxt.value,
            userspage: PageNumber
        }, function(output) {
            for (var i = 1; 1 < document.getElementsByClassName('FuntionBox')[BoxNumber].children[1].childElementCount; i++) {
                document.getElementsByClassName('FuntionBox')[BoxNumber].children[1].children[i].remove();
            }
            if (output != 0) {

                var newBox = document.createElement("DIV");
                newBox.innerHTML = output;
                document.getElementsByClassName('FuntionBox')[3].children[1].appendChild(newBox);
                newBox.scrollIntoView();
            }
        });

    }

</script>

<?php
    require 'footer.php';
?>
