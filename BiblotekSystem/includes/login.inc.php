<?php
    if (isset($_POST['UserEmail'])){
        
        session_start();       
        require'db.inc.php';
        
        if(isset($_SESSION['Searched'])){
            $searchq = 'Searched='.$_SESSION['Searched'];
        }else{
            $searchq = "";
        }
        $UserMail = test_input($_POST['UserEmail']);
        $Pwd = test_input($_POST['Pwd']);
        
        if(empty($UserMail)){
            header('Location: ../index.php?loginerror=emptyuseremail&'.$searchq);
            exit();
        }else{
            if(empty($Pwd)){
                header('Location: ../index.php?loginerror=emptypwd&UserEmail='.$UserMail.'&'.$searchq);
                exit();
            }else{
                echo  $UserMail.' '.$Pwd;
                
                $sql = "SELECT * FROM users WHERE Username=? OR Email=?";
                $stmt = mysqli_stmt_init($con);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo 'here';
                    header('Location: ../index.php?loginerror=sqlerror&'.$searchq);
                    exit();
                }else{
                    mysqli_stmt_bind_param($stmt, "ss", $UserMail, $UserMail);
                    mysqli_stmt_execute($stmt);
                    
                    $results = mysqli_stmt_get_result($stmt);
                    if($row = mysqli_fetch_assoc($results)){
                        
                        $pwdCheck = password_verify($Pwd, $row['Pwd']);
                        
                        if($pwdCheck == false){
                            header('Location: ../index.php?loginerror=wrongpwd&UserEmail='.$UserMail.'&'.$searchq);
                            exit();
                        }else if($pwdCheck == true){
                            
                            $_SESSION['UserID'] = $row['UserID'];
                            $_SESSION['Fname'] = $row['Fname'];
                            $_SESSION['Lname'] = $row['Lname'];
                            $_SESSION['Email'] = $row['Email'];
                            $_SESSION['Username'] = $row['Username'];
                            $_SESSION['Type'] = $row['Type'];
                            
                            header('Location: ../index.php?'.$searchq);
                            exit();
                            
                        }else{
                            header('Location: ../index.php?loginerror=wrongpwd&UserEmail='.$UserMail.'&'.$searchq);
                            exit();
                        }
                        
                    }else{
                        header('Location: ../index.php?loginerror=nouser&'.$searchq);
                        exit();
                    }
                }
            }        
        }

    }
    else{
        http_response_code(403);        
        exit();
    }
?>
