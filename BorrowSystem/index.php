<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title> Låna lämna</title>
</head>

<body>
    <div id="Container">
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

                    var newBookScanned = document.createElement("DIV");
                    newBookScanned.setAttribute("style", "text-align: left; padding-left: 10%; margin : 2%;");

                    newBookScanned.innerHTML = IInput.value;
                    document.getElementById("BookScanningForm").appendChild(newBookScanned);

                    IInput.value = "";
                    var digits = Math.floor(Math.random() * 9000000000) + 1000000000;
                    console.log(digits);
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
