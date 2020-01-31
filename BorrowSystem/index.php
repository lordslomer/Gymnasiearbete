<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title> Låna lämna</title>
</head>

<body>
    <div id="Container">
        <?php 
                            include_once "db/connect.php";
                            
                            $sql = "SELECT BookID FROM arkiv";
                            $result = mysqli_query($con, $sql);
                            $resultAmount = mysqli_num_rows($result);
                        
                            if($resultAmount > 0){
                                echo '<table id="BookIDtable" style="display:none;">';
                                while($rows = mysqli_fetch_assoc($result)){
                                    
                                    echo "<tr><td>".$rows['BookID']."</td></tr>";
                                }  
                                echo"</table>";
                            }
                            
        ?>
        <div class="StyledDiv" id="ButtonSectionSelection">
            <button onclick="DisplayBorrowSectionOne('1')">Låna</button>
            <button onclick="DisplayReturnSectionOne('1')">Lämna</button>
        </div>
        <div class="StyledDiv UnwantedFormsAtBeginOne" id="BorrowSectionOne">
            <form style="width: 50%; margin-left: 25%;">
                <p>Kontonummer : </p>
                <input autocomplete="off" placeholder="User...">
                <p>Lösenord : </p>
                <input autocomplete="off" type="password" Id="PassInput" placeholder="Pass...">
                <button Id="GoToBorrowSectionTwo">Fortsätt</button>
            </form>
            <button class="RewindButtons" onclick="DisplayBorrowSectionOne('0')">Tillbaka</button>
        </div>
        <div class="StyledDiv UnwantedFormsAtBeginOne" id="ReturnSectionOne">
            <div id="BookScanningForm">
                <p>Skanna Boken Här : </p>
                <input type="number" id="ReturnBookCode" autocomplete="off" placeholder="Bok Koden...">
            </div>
            <button class="RewindButtons" onclick="DisplayReturnSectionOne('0')">Tillbaka</button>
        </div>
        <script>
            var IInput = document.getElementById("ReturnBookCode");
            IInput.addEventListener("keyup", function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();;
                    if (IInput.value === "") {

                    } else {

                        //make a new div, place it inside the Bookscanningform and style it. 
                        var newBookScanned = document.createElement("DIV");
                        newBookScanned.setAttribute("style", "text-align: left; padding-left: 10%; margin : 2%;");
                        document.getElementById("BookScanningForm").appendChild(newBookScanned);

                        //Get the search results from the BookIdTable.
                        var BookIdTable = document.getElementById("BookIDtable");
                        if (typeof(BookIdTable) != "undefind" && BookIdTable != null) {

                            var ResultFoundTex = "No Book was found with that id";
                            for (var i = 0; i < <?php echo $resultAmount?>; i++) {
                                if (IInput.value === BookIdTable.getElementsByTagName("tr")[i].getElementsByTagName("td")[0].innerHTML) {
                                    ResultFoundTex = "A Book with this ID was found : " + BookIdTable.getElementsByTagName("tr")[i].getElementsByTagName("td")[0].innerHTML;
                                } else {
                                    newBookScanned.setAttribute("id", "NoBookIDFound");
                                    newBookScanned.innerHTML = ResultFoundTex;
                                }
                            }
                        } else {
                            alert("Table not found!");
                        }

                        //Give the div a Value, then clear the input field. 

                        IInput.value = "";


                        var digits = Math.floor(Math.random() * 9000000000) + 1000000000;
                    }
                }
            });

            function DisplayBorrowSectionOne(NumValue) {
                var BorrowSection = document.getElementById("BorrowSectionOne");
                var x = document.getElementById("ButtonSectionSelection");
                if (NumValue == 1) {
                    BorrowSection.style.display = "block";
                    x.style.display = "none";
                } else {
                    BorrowSection.style.display = "none";
                    x.style.display = "block";
                }
            }

            function DisplayReturnSectionOne(NumValue) {
                var ReturnSection = document.getElementById("ReturnSectionOne");
                var x = document.getElementById("ButtonSectionSelection");
                if (NumValue == 1) {
                    ReturnSection.style.display = "block";
                    x.style.display = "none";
                } else {
                    ReturnSection.style.display = "none";
                    x.style.display = "block";
                }
            }

        </script>
</body>

</html>
