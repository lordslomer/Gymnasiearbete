<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title> Main </title>
</head>

<body>
    <div id="Container">
        <div class="StyledDiv" id="ButtonSectionSelection">
            <button onclick="DisplayBorrowSectionOne('1')">Låna</button>
            <button onclick="DisplayReturnSectionOne('1')">Lämna</button>
        </div>
        <div class="StyledDiv UnwantedFormsAtBeginOne" id="BorrowSectionOne">
            <form style="width: 50%; margin-left: 25%;">
                <p>Användarnamn : </p>
                <input placeholder="User...">
                <p>Lösenord : </p>
                <input type="password" Id="PassInput" placeholder="Pass...">
                <button Id="GoToBorrowSectionTwo">Fortsätt</button>
            </form>
            <button class="RewindButtons" onclick="DisplayBorrowSectionOne('0')">Tillbaka</button>
        </div>
        <div class="StyledDiv UnwantedFormsAtBeginOne" id="ReturnSectionOne">
            <form>
                <p>Skanna Boken Här : </p>
                <input placeholder="Bok Koden...">
            </form>
            <button class="RewindButtons" onclick="DisplayReturnSectionOne('0')">Tillbaka</button>
        </div>
    </div>
    <script>
        var IInput = document.getElementById("PassInput");
        IInput.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                console.log("it worked");
                document.getElementById("GoToBorrowSectionTwo").onclick;
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
