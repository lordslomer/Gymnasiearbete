 <?php
                    
                    
                    if(isset($_POST['searchVal'])){
                        require'db.inc.php';
                        session_start();
                        
                        
                    $searchq = htmlspecialchars($_POST['searchVal']); 
                    $searchq = mysqli_real_escape_string($con, $searchq);
                        
                        if(!empty($searchq)){
                    
                            $sql = "SELECT * FROM users WHERE UserID != 3 AND Fname LIKE '%$searchq%' OR UserID != 3 AND Lname LIKE '%$searchq%' OR UserID != 3 AND Email LIKE '%$searchq%' OR UserID != 3 AND Type LIKE '%$searchq%'";
                            
                            $result = mysqli_query($con, $sql);

                            $resultAmount = mysqli_num_rows($result);
                            if($resultAmount > 0){
                            echo '<div>
                                <table class="subtables" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th onclick="sortTable(0,1)">Förenamn</th>
                                            <th onclick="sortTable(1,1)">Efternamn</th>
                                            <th onclick="sortTable(2,1)">Epostadress</th>
                                            <th onclick="sortTable(3,1)">Typ</th>
                                         </tr>
                                    </thead>
                                    <tbody class="tableBody">';

                            $results_per_page = 10;
                            $number_of_pages = ceil($resultAmount / $results_per_page);
                            if(!isset($_POST['userspage']) || $_POST['userspage'] == 0){
                                $page = 1;
                            }else{
                                $page = $_POST['userspage'];
                            }

                            $startinglimitNumber = ($page - 1 ) * $results_per_page;

                            

                            $sqlp = "SELECT * FROM users WHERE UserID != 3 AND Fname LIKE '%$searchq%' OR UserID != 3 AND Lname LIKE '%$searchq%' OR UserID != 3 AND Email LIKE '%$searchq%' OR UserID != 3 AND Type LIKE '%$searchq%' LIMIT ".$startinglimitNumber.",".$results_per_page;

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
                            for($pagee = 1; $pagee <=$number_of_pages; $pagee++){ echo '<input type="button" value="'.$pagee.'" onclick="SreachFilter(3,'.$pagee.')" style="margin: 0px 10px;" class="Buttons">';
                            }}
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
                                <th>Förenamn &#8659;</th>
                                <th>Efternamn</th>
                                <th>Epostadress</th>
                                <th>Typ</th>
                            </tr>
                        </thead>
                        <tbody class="tableBody">';
                            
                        $results_per_page = 10;
                        $number_of_pages = ceil($resultAmount / $results_per_page);
                         
                        if(!isset($_GET['userspage'])){
                            $page = 1;
                        }else{
                            $page = $_GET['userspage'];
                        }
                    
                        $startinglimitNumber = ($page - 1 ) * $results_per_page;
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
                    </table><span>Sida '.$page.' av '.$number_of_pages.' , '.($resultAmountonpage + $startinglimitNumber).' av '.$resultAmount.' Användare</span><div style="text-align: center;">';
                    
                        for($page = 1; $page <=$number_of_pages; $page++){ echo '<a style="margin: 0px 10px;;" href="profile.php?userspage=' .$page.'"><button class="Buttons">'.$page.'</button></a>';
                            }
                            echo '</div>
                </div>';
                    }
                    }}
