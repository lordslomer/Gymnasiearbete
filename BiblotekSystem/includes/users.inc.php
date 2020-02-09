<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['Type'])){
        $ButtonClicked = array_keys($_POST)[5];
    }
    else {
        $ButtonClicked = array_keys($_POST)[4];
    }
    require'db.inc.php';    
 
    switch ($ButtonClicked) {
        case 'userAdd':
            
            $Fname = test_input($_POST['Fname']);
            $Lname = test_input($_POST['Lname']);
            $Email = strtolower(test_input($_POST['Email']));
            $Pwd = test_input($_POST['Pwd']);
            $Type = test_input($_POST['Type']);
            
            if(empty($Fname) || empty($Lname) || empty($Email) || empty($Pwd) || empty($Type)){
                header('Location: ../profile.php?signupaddstatus=emptyfields'.'&Fname='.$Fname.'&Lname='.$Lname.'&Email='.$Email.'&Type='.$Type);
                exit();
            }else{
                $errors = array();
                
                if(!preg_match("/^[a-öA-Ö]*$/",$Fname)){
                    $Fname = ""; 
                    array_push($errors,'invalidFname');
                }
                
                if(!preg_match("/^[a-öA-Ö]*$/",$Lname)){
                    $Lname = ""; 
                    array_push($errors,'invalidLname');
                }
                
                if(!filter_var($Email, FILTER_VALIDATE_EMAIL)){
                    $Email = ""; 
                    array_push($errors,'invalidEmail');
                }
                
                if(!preg_match("/^[0-9]{6}$/",$Pwd)){
                    $Pwd = ""; 
                    array_push($errors,'invalidPwd');
                }
                
                if($Type != 'none' && $Type != 'Admin'){
                    $Type = ""; 
                    array_push($errors,'invalidType');
                }
                
                if(count($errors) > 1 ){
                    $errormsg = 'signupaddstatus[]='.implode('&signupaddstatus[]=', $errors);
                    header('Location: ../profile.php?'.$errormsg.'&Fname='.$Fname.'&Lname='.$Lname.'&Email='.$Email.'&Type='.$Type);
                    exit();
                }else if(count($errors) == 1){
                    $errormsg = $errors[0];
                    header('Location: ../profile.php?signupaddstatus='.$errormsg.'&Fname='.$Fname.'&Lname='.$Lname.'&Email='.$Email.'&Type='.$Type);
                    exit();
                    
                }else{
                    $Username = $Fname.'.'.$Lname;
                    $Username = strtolower($Username);
                    
                    $sql = "SELECT UserID FROM users WHERE Email=?";
                    
                    $stmt = mysqli_stmt_init($con);
                    
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        header('Location: ../profile.php?error=sqlerror');
                        exit();
                    }
                    else{
                        
                        mysqli_stmt_bind_param($stmt, 's', $Email);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        
                        $resultAmount = mysqli_stmt_num_rows($stmt);
                        
                        if($resultAmount > 0){
                            header('Location: ../profile.php?signupaddstatus=emailtaken&Fname='.$Fname.'&Lname='.$Lname.'&Email='.$Email.'&Type='.$Type);
                            exit();
                        }
                        else{
                            $sql = "SELECT UserID,Username FROM users WHERE Username LIKE '%$Username%' ORDER BY Username";
                            $results = mysqli_query($con, $sql);
                            $resultAmount = mysqli_num_rows($results);
                               echo $resultAmount.'<br>';
                            if($resultAmount > 0){
                                while($rows = mysqli_fetch_array($results, MYSQLI_NUM)){
                                    $lastUsername = $rows[1];
                                }
                                $indexlast = str_replace($Username,"",$lastUsername);
                                if($indexlast == ''){
                                    $indexlast = 0;
                                }
                               $Username = $Username.($indexlast + 1);
                            }
                            
                            mysqli_stmt_close($stmt);
                            $sql = "INSERT INTO users (Fname, Lname, Username, Email, Pwd, Type) VALUES (?,?,?,?,?,?)";
                            $stmt = mysqli_stmt_init($con);
                            
                            if(!mysqli_stmt_prepare($stmt, $sql)){
                                header('Location: ../profile.php?error=sqlerror');
                                exit();
                            }else{
                                
                                $hashedPwd = password_hash($Pwd, PASSWORD_DEFAULT);
                                echo $Fname.' '.$Lname.' '.$Username.' '.$Email.' '.$hashedPwd.' '.$Type;                                
                                mysqli_stmt_bind_param($stmt, 'ssssss', $Fname, $Lname, $Username, $Email, $hashedPwd, $Type);
                                mysqli_stmt_execute($stmt);
                                
                                header('Location: ../profile.php?signupaddstatus=success');
                                exit();
                                
                            }
                        }
                    }
                }
            }

            
            break;
        case 'userEdit':
            echo 'U tried to Edit a user <br>';
            
            $Fname = test_input($_POST['Fname']);
            $Lname = test_input($_POST['Lname']);
            $Email = test_input($_POST['Email']);
            $Pwd = test_input($_POST['Pwd']);
            $Type = test_input($_POST['Type']);
            
            echo $Fname.$Lname.$Email.$Pwd.$Type;
            
            break;
        case 'userDelete';
            echo 'U tried to Delete a user';
            break;
        default: 
            header('Location: ../profile.php?buttonwasnotclicked');
            exit();
            
    }
      mysqli_stmt_close($stmt);
      mysqli_close($con);
}else{
    http_response_code(404);
    exit();
}
