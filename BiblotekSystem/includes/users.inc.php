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
                
                if($Type != 'Elev' && $Type != 'Admin'){
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
            
            $Fname = test_input($_POST['Fname']);
            $Lname = test_input($_POST['Lname']);
            $Email = strtolower(test_input($_POST['Email']));
            $Type = test_input($_POST['Type']);
            $hiddenEmail = $_POST['hiddenEmail'];
            
            if(empty($Fname) || empty($Lname) || empty($Email) || empty($Type)){
                header('Location: ../profile.php?signupupdatestatus=emptyfields'.'&Fname='.$Fname.'&Lname='.$Lname.'&Email='.$Email.'&Type='.$Type);
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
                if($Type != 'Elev' && $Type != 'Admin'){
                        $Type = ""; 
                        array_push($errors,'invalidType');
                    }

                if(count($errors) > 1 ){
                        $errormsg = 'signupupdatestatus[]='.implode('&signupupdatestatus[]=', $errors);
                        header('Location: ../profile.php?'.$errormsg.'&Fname='.$Fname.'&Lname='.$Lname.'&Email='.$Email.'&Type='.$Type);
                        exit();
                    }else if(count($errors) == 1){
                        $errormsg = $errors[0];
                        header('Location: ../profile.php?signupupdatestatus='.$errormsg.'&Fname='.$Fname.'&Lname='.$Lname.'&Email='.$Email.'&Type='.$Type);
                        exit();
                    }else{
                    echo $Fname.'<br>'.$Lname.'<br>'.$Email.'<br>'.$Type.'<br>'.$hiddenEmail.'<br>';
                    if($Email == $hiddenEmail){
                        $sql = 'SELECT Email FROM users WHERE Email=?';
                        $stmt = mysqli_stmt_init($con);
                        
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                                header('Location: ../profile.php?error=sqlerror');
                                exit();
                            }else{
                            mysqli_stmt_bind_param($stmt, "s", $hiddenEmail);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_store_result($stmt);
                            $resultsRowIndex = mysqli_stmt_num_rows($stmt);
                            
                            if($resultsRowIndex == 1){
                                
                                $sql = "UPDATE users SET Fname=?, Lname=?, Type=? WHERE Email=?";
                                $stmt = mysqli_stmt_init($con);

                                if(!mysqli_stmt_prepare($stmt, $sql)){
                                    header('Location: ../profile.php?error=sqlerror');
                                    exit();
                                }else{                          
                                    mysqli_stmt_bind_param($stmt, 'ssss', $Fname, $Lname, $Type, $hiddenEmail);
                                    mysqli_stmt_execute($stmt);

                                    header('Location: ../profile.php?signupupdatestatus=success');
                                    exit();

                                } 
                                
                            }else{
                                header('Location: ../profile.php?error=accnotfound');
                                exit();
                            }
                        }
                        
                    }else{                        
                        $sql = 'SELECT Email FROM users WHERE Email=?';
                        $stmt = mysqli_stmt_init($con);
                        
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                                header('Location: ../profile.php?error=sqlerror');
                                exit();
                            }else{
                            mysqli_stmt_bind_param($stmt, "s", $hiddenEmail);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_store_result($stmt);
                            $resultsRowIndex = mysqli_stmt_num_rows($stmt);
                            
                            if($resultsRowIndex == 1){
                                
                                $sql = "SELECT Email FROM users WHERE Email=?";
                                $stmt = mysqli_stmt_init($con);

                                if(!mysqli_stmt_prepare($stmt, $sql)){
                                    header('Location: ../profile.php?error=sqlerror');
                                    exit();
                                }else{                          
                                    mysqli_stmt_bind_param($stmt, 's',$Email);
                                    mysqli_stmt_execute($stmt);
                                    mysqli_stmt_store_result($stmt);
                                    $resultsRowIndex = mysqli_stmt_num_rows($stmt);
                                    
                                    if($resultsRowIndex > 0){
                                        
                                        header('Location: ../profile.php?signupupdatestatus=emailtaken');
                                        exit();
                                        
                                    }else{
                                        
                                        $sql = "UPDATE users SET Fname=?, Lname=?, Email=?, Type=? WHERE Email=?";
                                        $stmt = mysqli_stmt_init($con);

                                        if(!mysqli_stmt_prepare($stmt, $sql)){
                                            header('Location: ../profile.php?error=sqlerror');
                                            exit();
                                        }else{                          
                                            mysqli_stmt_bind_param($stmt, 'sssss', $Fname, $Lname, $Email, $Type, $hiddenEmail);
                                            mysqli_stmt_execute($stmt);

                                            header('Location: ../profile.php?signupupdatestatus=success');
                                            exit();

                                        }
                                    }
                                } 
                            }else{
                                header('Location: ../profile.php?error=accnotfound');
                                exit();
                            }
                        }
                    }
                }
            }
                    
                        
            break;
        case 'userDelete':
            echo 'U tried to Delete a user';
            break;
        default: 
            echo $ButtonClicked;
            break;
    }
      mysqli_stmt_close($stmt);
      mysqli_close($con);
}else{
    http_response_code(404);
    exit();
}
