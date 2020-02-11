<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
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
            
        }
        
        $errormsg = "";
        
        if(isset($_POST['new-pass']) && isset($_POST['curr-pass']) && isset($_POST['userEmail'])){
                $currPass = test_input($_POST['curr-pass']);
                $newPass = test_input($_POST['new-pass']);
                $changedEmail = $_POST['userEmail'];
                
                
                if(!preg_match("/^[0-9]{6}$/",$currPass)){
                    $errormsg = '<p style="color: red;">Pin-koden måste vara 6-siffrig !</p>';
                }
                
                echo '<script>window.opener.parent.location.replace("profile.php?changedPass=ture&changedEmail='.$changedEmail.'"); window.close();</script>';
                exit();
                
            }else if (isset($_POST['new-user']) && isset($_POST['userEmail'])){
                
                $newUser = test_input($_POST['new-user']);
                echo $newUser;
                
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
    if(!isset($currPass) && !isset($newPass) || !isset($newUser)){
        if($title == 'Ändra  Pin-kod'){
            echo '
            <div id="Container" style="min-height: 400px; grid-template: 1fr 2fr/1fr;">
                <span style="justify-self: center; align-self: center; text-align: center;">
                    <h1>'.$title.'</h1>
                    <p>Användare : '.$username.'</p>
                    <p>Namn : '.$name.'</p>
                    <p>Epostadress : '.$email.'</p>
                    <p>Typ av konto : '.$acctype.'</p>
                </span>

                <form method="post" style="display:grid; grid-template: repeat(3, 1fr)/1fr; margin: 0px auto;">
                    '.$errormsg.'
                    <span style="justify-self: center; align-self: end; text-align: center;">
                        <p>Nuvarande Pin-kod</p>
                        <input name="curr-pass" type="password" class="Inputs pinCode" autocomplete="off" placeholder="XX-XX-XX" onkeypress="return /[0-9]/i.test(event.key)" required maxlength="6">
                        <input type="text" name="userEmail" readonly style="display:none;" value="'.$email.'">
                    </span>
                    <span style="justify-self: center; align-self: end; text-align: center;">
                        <p>Ny Pin-kod</p>
                        <input type="password" name="new-pass" class="Inputs pinCode" autocomplete="off" placeholder="XX-XX-XX" onkeypress="return /[0-9]/i.test(event.key)" required maxlength="6">
                        </span>
                    <span style="justify-self: center; align-self: center; text-align: center;">
                        <button class="Buttons" style="margin: 0px auto;">'.$title.'</button>
                    </span>
                </form>
            </div>
            ';
                }
            else{ 
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
                                '.$errormsg.'
                                <span style="justify-self: center; align-self: center; text-align: center;">
                                    <p>Ny Änvandarenamn</p>
                                    <input type="text" name="new-user" class="Inputs" autocomplete="off" placeholder="Ny Användarnamn" onclick="InputColorWhite(event)" required>
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
    else{
        echo 'YES';
    }
?>




</body>

</html>
