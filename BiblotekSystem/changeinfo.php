<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'  || $_SERVER['REQUEST_METHOD'] == 'GET' ){
        function resetSesstionVar(){
                $_SESSION['TempTitle'] = '';
                $_SESSION['TempType'] = '';
                $_SESSION['TempUsername'] = '';
                $_SESSION['TempName'] = '';
                $_SESSION['TempEmail'] = '';
                $_SESSION['TempAcctype'] = '';
            }
        session_start();
        require'includes/db.inc.php';
        
        if(isset($_POST['changeinfo']) && isset($_POST['userType'])){
            $title = str_replace('<br>', '',$_POST['changeinfo']);
            $type = $_POST['userType'];
            
            if($type == 'logged'){
                $username = $_SESSION['Username'];
                $name = $_SESSION['Fname'].' '.$_SESSION['Lname'];
                $email = $_SESSION['Email'];
                $acctype = $_SESSION['Type'];
            }
            else{
                $email = $type;
                $sql = "SELECT Fname,Lname,Username,Type FROM users WHERE Email=?";
                
                $stmt = mysqli_stmt_init($con);
                            
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header('Location: ../profile.php?');
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    
                    $result = mysqli_stmt_get_result($stmt);
                    if($row = mysqli_fetch_assoc($result)){
                        $name = $row['Fname'].' '.$row['Lname'];
                        $username = $row['Username'];
                        $acctype = $row['Type'];
                    }
                }
            }
            
            $_SESSION['TempTitle'] = $title;
            $_SESSION['TempType'] = $type;
            $_SESSION['TempUsername'] = $username;
            $_SESSION['TempName'] = $name;
            $_SESSION['TempEmail'] = $email;
            $_SESSION['TempAcctype'] = $acctype;
            
            
            
        }else{
            $title = $_SESSION['TempTitle'];
            $type = $_SESSION['TempType'];
            $username = $_SESSION['TempUsername'];
            $name = $_SESSION['TempName'];
            $email = $_SESSION['TempEmail'];
            $acctype = $_SESSION['TempAcctype'];
        }
        
        $errormsg = "";
        $currPasserror = "";
        $newPasserror = "";
        $newUsererror = "";
        
        if(isset($_POST['new-pass']) && isset($_POST['curr-pass']) && isset($_POST['userEmail'])){

                $currPass = test_input($_POST['curr-pass']);
                $newPass = test_input($_POST['new-pass']);
                $changedEmail = $_POST['userEmail'];
                if(empty($currPass)){
                    $errormsg = '<p style="color: red;">Lämna inte fält tomma !!! :(</p>';
                    $currPasserror = 'style="border-color: red;"';
                }
                
                if(empty($newPass)){
                    $errormsg = '<p style="color: red;">Lämna inte fält tomma !!! :(</p>';
                    $newPasserror = 'style="border-color: red;"';
                }
                    
                
                if(!preg_match("/^[0-9]{6}$/",$currPass)){
                    $errormsg = '<p style="color: red;">Pin-koden måste vara 6-siffrig !</p>';
                    $currPasserror = 'style="border-color: red;"';
                }
                if(!preg_match("/^[0-9]{6}$/",$newPass)){
                    $errormsg = '<p style="color: red;">Pin-koden måste vara 6-siffrig !</p>';
                    $newPasserror = 'style="border-color: red;"';
                }
                
                $sql = "SELECT * FROM users WHERE Username=? AND Email=?";
                $stmt = mysqli_stmt_init($con);
                    
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    $errormsg = '<p style="color: red;">Sql finding Error</p>';
                }else{
                    mysqli_stmt_bind_param($stmt, "ss", $username, $changedEmail);
                    mysqli_stmt_execute($stmt);
                    
                    $results = mysqli_stmt_get_result($stmt);
                    if($row = mysqli_fetch_assoc($results)){
                        
                        $pwdCheck = password_verify($currPass, $row['Pwd']);
                        
                        if($pwdCheck == false){
                            $errormsg = '<p style="color: red;">Fel Pin-kod</p>';
                        }else if($pwdCheck == true){
                            
                            $sql = "UPDATE users SET Pwd=? WHERE Username=? AND EMAIL=?";
                            $stmt = mysqli_stmt_init($con);
                    
                            if(!mysqli_stmt_prepare($stmt, $sql)){
                                $errormsg = '<p style="color: red;">Sql inserting Error</p>';
                            }else {
                                
                                $hashedPwd = password_hash($newPass, PASSWORD_DEFAULT);
                                mysqli_stmt_bind_param($stmt, "sss", $hashedPwd,$username,$changedEmail);
                                mysqli_stmt_execute($stmt);
                                $donemsg = '<p style="color: green; font-size: 38px; margin-top:200px; text-align:center;">lyckades byta lösenord </p>';
                                resetSesstionVar();
                            }
                        }else{
                            $errormsg = '<p style="color: red;">Fel Pin-kod</p>>';
                        }
                    }
                }
            }
                
            else if (isset($_POST['new-user']) && isset($_POST['userEmail'])){
                
                $newUser = test_input($_POST['new-user']);
                $changedEmail = $_POST['userEmail'];
                
                if(empty($newUser)){
                    $errormsg = '<p style="color: red;">lämna inte fältet tomt !!! :(</p>';
                    $newUsererror = 'style="border-color: red;"';
                }
                
                if(!preg_match("/^[a-öA-Ö0-9\.]*$/", $newUser)){
                    $errormsg = '<p style="color: red;">Bara bokstäver och siffror i användarenamnet !!</p>';
                    $newUsererror = 'style="border-color: red;"';
                }
                
                
                $sql = "SELECT * FROM users WHERE Username=?";
                $stmt = mysqli_stmt_init($con);
                    
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    $errormsg = '<p style="color: red;">Sql finding Error</p>';
                }else{
                    mysqli_stmt_bind_param($stmt, "s", $newUser);
                    mysqli_stmt_execute($stmt);
                    
                    $results = mysqli_stmt_get_result($stmt);
                    if($row = mysqli_fetch_assoc($results)){
                    $errormsg = '<p style="color: red;">Användarenamnet är redan tagen !</p>';
                    }else{
                        
                        $sql = "UPDATE users SET Username=? WHERE Username=? AND EMAIL=?";
                        $stmt = mysqli_stmt_init($con);

                        if(!mysqli_stmt_prepare($stmt, $sql)){
                        $errormsg = '<p style="color: red;">Sql inserting Error</p>';
                        }else {

                        mysqli_stmt_bind_param($stmt, "sss", $newUser,$username,$changedEmail);
                        mysqli_stmt_execute($stmt);
                        $donemsg = '<p style="color: green; font-size: 38px; margin-top:200px; text-align:center;">lyckades byta Användarenamnet<br>Gamla : '.$username.'<br> Nya : '.$newUser.'</p>';
                        resetSesstionVar();

                        }
                    }
                }
            }
    }else{
        header('location: profile.php');
        exit();
    }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <title><?php if(!isset($currPass) && !isset($newPass) || !isset($newUser)){echo $title;}else{ echo 'Done!';} ?></title>
</head>

<body style="display: block; width:100%;">
    <?php 
    if(!isset($currPass) && !isset($newPass) && !isset($newUser) || $errormsg != ""){
        if($title == 'Ändra  Pin-kod'){
            echo '
            <div  id="Container" style="min-height: 400px; grid-template: 1fr 2fr/1fr;">
                <span style="justify-self: center; align-self: center; text-align: center;">
                    <h1>'.$title.'</h1>
                    <p>Användare : '.$username.'</p>
                    <p>Namn : '.$name.'</p>
                    <p>Epostadress : '.$email.'</p>
                    <p>Typ av konto : '.$acctype.'</p>
                </span>

                <form method="post" style="display:grid; grid-template: repeat(3, 1fr)/1fr; margin: 0px auto;">
                    <span style="justify-self: center; align-self: end; text-align: center;">
                        '.$errormsg.'
                        <p>Nuvarande Pin-kod</p>
                        <input name="curr-pass" autofocus type="password" '.$currPasserror.' onfocus="onloadInputs()" class="Inputs pinCode" autocomplete="off" placeholder="XX-XX-XX" onkeypress="return /[0-9]/i.test(event.key)" required maxlength="6">
                        <input type="text" name="userEmail" readonly style="display:none;" value="'.$email.'">
                    </span>
                    <span style="justify-self: center; align-self: end; text-align: center;">
                        <p>Ny Pin-kod</p>
                        <input type="password" name="new-pass" '.$newPasserror.' onfocus="onloadInputs()" class="Inputs pinCode" autocomplete="off" placeholder="XX-XX-XX" onkeypress="return /[0-9]/i.test(event.key)" required maxlength="6">
                        </span>
                    <span style="justify-self: center; align-self: center; text-align: center;">
                        <button class="Buttons" style="margin: 0px auto;">'.$title.'</button>
                    </span>
                </form>
            </div>
            ';
                }
            else{ if($title == 'Ändra  Änvandarenamn'){
                    echo '

                         <div id="Container" style="min-height: 400px; grid-template: 1fr 2fr/1fr;">
                            <span style="justify-self: center; align-self: center; text-align: center;">
                                <h1>'.$title.'</h1>
                                <p>Användare : '.$username.'</p>
                                <p>Namn : '.$name.'</p>
                                <p>Epostadress : '.$email.'</p>
                                <p>Typ av konto : '.$acctype.'</p>
                            </span>
                                    

                            <form method="post" style="display:grid; grid-template: repeat(2, 1fr)/1fr; margin: 0px auto;">
                                <span style="justify-self: center; align-self: center; text-align: center;">
                                    <p>Ny Änvandarenamn</p>
                                    '.$errormsg.'
                                    <input type="text" '.$newUsererror.' autofocus name="new-user" onfocus="onloadInputs()" class="Inputs" onkeypress="return /[a-öA-Ö0-9\.]/i.test(event.key)" autocomplete="off" placeholder="Ny Användarnamn" onfocus="InputColorWhite(event)" required>
                                    <input type="text" name="userEmail" readonly style="display:none;" value="'.$email.'">
                                    </span>
                                <span style="justify-self: center; text-align: center;">
                                    <button class="Buttons" style="margin: 0px auto;">'.$title.'</button>
                                </span>
                            </form>
                        </div>
                    ';
                }
            }
    }
    else{
        echo $donemsg;
    }
?>

    <script>
        function onloadInputs() {
            event.target.addEventListener("keyup", function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    document.getElementsByClassName("Inputs")[0].parentElement.parentElement.submit();
                }
            });

        }

    </script>

</body>

</html>
