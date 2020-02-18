 <?php
                    
                    
                    if(isset($_POST['searchVal'])){
                        require'db.inc.php';
                        session_start();
                        
                        
                    $searchq = htmlspecialchars($_POST['searchVal']); 
                    $searchq = mysqli_real_escape_string($con, $searchq);
                        
                        if(!empty($searchq)){
                    
                            $sql = "SELECT * FROM users WHERE UserID != ".$_SESSION['UserID']." AND Fname LIKE '%$searchq%' OR UserID != ".$_SESSION['UserID']." AND Lname LIKE '%$searchq%' OR UserID != ".$_SESSION['UserID']." AND Email LIKE '%$searchq%' OR UserID != ".$_SESSION['UserID']." AND Type LIKE '%$searchq%'";
                            
                            $result = mysqli_query($con, $sql);

                            $resultAmount = mysqli_num_rows($result);
                            if($resultAmount > 0){
                            echo '<div>
                                <table class="subtables" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th onclick="sortTable(0)">Förenamn</th>
                                            <th onclick="sortTable(0)">Efternamn</th>
                                            <th onclick="sortTable(0)">Epostadress</th>
                                            <th onclick="sortTable(0)">Typ</th>
                                         </tr>
                                    </thead>
                                    <tbody class="tableBody">';

                            $results_per_page = 10;
                            $number_of_pages = ceil($resultAmount / $results_per_page);
                            if(!isset($_GET['userspage'])){
                            $currpage = 1;
                        }else{
                            $currpage = $_GET['userspage'];
                        }

                            $startinglimitNumber = ($currpage - 1 ) * $results_per_page;

                            

                            $sqlp = "SELECT * FROM users WHERE UserID != ".$_SESSION['UserID']." AND Fname LIKE '%$searchq%' OR UserID != ".$_SESSION['UserID']." AND Lname LIKE '%$searchq%' OR UserID != ".$_SESSION['UserID']." AND Email LIKE '%$searchq%' OR UserID != ".$_SESSION['UserID']." AND Type LIKE '%$searchq%' LIMIT ".$startinglimitNumber.",".$results_per_page;

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
                    </table><span>Sida '.$currpage.' av '.$number_of_pages.' , '.($resultAmountonpage + $startinglimitNumber).' av '.$resultAmount.' Användare</span><div style="text-align: center;">';
                        if($number_of_pages > 1){
                            if($number_of_pages <= 5){
                                for($page = 1; $page <=$number_of_pages; $page++){ 
                                    if($currpage == $page){
                                        $isonCurrentPage = "border: 3px solid black;";
                                    }else{ $isonCurrentPage = ""; }
                                    echo '<a style="margin: 0px 10px;" href="profile.php?" userspage=' .$page.'"><button class="Buttons" style="'.$isonCurrentPage.'">'.$page.'</button></a>';
                                    }
                            }else{
                                $startPage = 1;
                                $endPage = 5;
                                $asfarRight = '<a style="margin: 0px 10px;" href="profile.php?userspage='.$number_of_pages.'"><button class="Buttons"> >> </button></a>';
                                $asfarleft = '<a style="margin: 0px 10px;" href="profile.php?userspage=1" ><button class="Buttons"> << </button></a>';
                                $rightButon = '<a style="margin: 0px 10px;" href="profile.php?userspage=' .($endPage + 1).'"><button class="Buttons"> > </button></a>';
                                $leftButon = '';
                                while($currpage > $endPage){
                                    $startPage += 5;
                                    $endPage += 5;
                                    $rightButon = '<a style="margin: 0px 10px;" href="profile.php?userspage=' .($endPage + 1).'"><button class="Buttons"> > </button></a>';
                                    $leftButon = '<a style="margin: 0px 10px;" href="profile.php?userspage=' .($startPage - 1).'"><button class="Buttons"> < </button></a>';
                                }
                                if($currpage > $number_of_pages - 5){
                                    $startPage = $number_of_pages - 4;
                                    $endPage = $number_of_pages;
                                    $leftButon = '<a style="margin: 0px 10px;" href="profile.php?userspage=' .($startPage - 1).'"><button class="Buttons"> < </button></a>';
                                    $rightButon = '';
                                }
                                echo $asfarleft;
                                echo $leftButon;
                                for($i = $startPage; $i <= $endPage; $i++){ 
                                    if($currpage == $i){
                                        $isonCurrentPage = "border: 3px solid black;";
                                    }else{ $isonCurrentPage = ""; }
                                    echo '<a style="margin: 0px 10px;" href="profile.php?userspage=' .$i.'"><button class="Buttons" style="'.$isonCurrentPage.'">'.$i.'</button></a>';
                                    }
                                echo $rightButon;
                                echo $asfarRight;
                            }
                        }
                            echo '</div>';
                        }
                            else{
                                echo '0';
                            }
                    }else{
                            
                            
                $sql = "SELECT * FROM users WHERE UserID !=".$_SESSION['UserID'];

                $result = mysqli_query($con, $sql);

                
                $resultAmount = mysqli_num_rows($result);
                if($resultAmount > 0){
                echo '<div>
                    <table class="subtables" style="width: 100%;">
                        <thead>
                            <tr>
                                <th onclick="sortTable(0)">Förenamn</th>
                                <th onclick="sortTable(0)">Efternamn</th>
                                <th onclick="sortTable(0)">Epostadress</th>
                                <th onclick="sortTable(0)">Typ</th>
                            </tr>
                        </thead>
                        <tbody class="tableBody">';
                            
                        $results_per_page = 10;
                        $number_of_pages = ceil($resultAmount / $results_per_page);
                         
                        if(!isset($_GET['userspage'])){
                            $currpage = 1;
                        }else{
                            $currpage = $_GET['userspage'];
                        }
                    
                        $startinglimitNumber = ($currpage - 1 ) * $results_per_page;
                        $sqlp = "SELECT * FROM users WHERE UserID !=".$_SESSION['UserID']."  LIMIT ".$startinglimitNumber.",".$results_per_page;
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
                    </table><span>Sida '.$currpage.' av '.$number_of_pages.' , '.($resultAmountonpage + $startinglimitNumber).' av '.$resultAmount.' Användare</span><div style="text-align: center;">';
                        if($number_of_pages > 1){
                            if($number_of_pages <= 5){
                                for($page = 1; $page <=$number_of_pages; $page++){ 
                                    if($currpage == $page){
                                        $isonCurrentPage = "border: 3px solid black;";
                                    }else{ $isonCurrentPage = ""; }
                                    echo '<a style="margin: 0px 10px;" href="profile.php?" userspage=' .$page.'"><button class="Buttons" style="'.$isonCurrentPage.'">'.$page.'</button></a>';
                                    }
                            }else{
                                $startPage = 1;
                                $endPage = 5;
                                $asfarRight = '<a style="margin: 0px 10px;" href="profile.php?userspage='.$number_of_pages.'"><button class="Buttons"> >> </button></a>';
                                $asfarleft = '<a style="margin: 0px 10px;" href="profile.php?userspage=1" ><button class="Buttons"> << </button></a>';
                                $rightButon = '<a style="margin: 0px 10px;" href="profile.php?userspage=' .($endPage + 1).'"><button class="Buttons"> > </button></a>';
                                $leftButon = '';
                                while($currpage > $endPage){
                                    $startPage += 5;
                                    $endPage += 5;
                                    $rightButon = '<a style="margin: 0px 10px;" href="profile.php?userspage=' .($endPage + 1).'"><button class="Buttons"> > </button></a>';
                                    $leftButon = '<a style="margin: 0px 10px;" href="profile.php?userspage=' .($startPage - 1).'"><button class="Buttons"> < </button></a>';
                                }
                                if($currpage > $number_of_pages - 5){
                                    $startPage = $number_of_pages - 4;
                                    $endPage = $number_of_pages;
                                    $leftButon = '<a style="margin: 0px 10px;" href="profile.php?userspage=' .($startPage - 1).'"><button class="Buttons"> < </button></a>';
                                    $rightButon = '';
                                }
                                echo $asfarleft;
                                echo $leftButon;
                                for($i = $startPage; $i <= $endPage; $i++){ 
                                    if($currpage == $i){
                                        $isonCurrentPage = "border: 3px solid black;";
                                    }else{ $isonCurrentPage = ""; }
                                    echo '<a style="margin: 0px 10px;" href="profile.php?userspage=' .$i.'"><button class="Buttons" style="'.$isonCurrentPage.'">'.$i.'</button></a>';
                                    }
                                echo $rightButon;
                                echo $asfarRight;
                            }
                        }
                            echo '</div>
                </div>';
                    }
                    }}
