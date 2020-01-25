<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title> Main </title>
</head>

<body>
    <div id="Container">
        <form>
            <button onclick="DisplayBorrowBlock()">Låna</button>
            <button onclick="DisplayReturnBlock()">Lämna</button>
            <P Id="Borrow">Här Lånar Man</P>
            <P Id="Return">Här lämnar Man</P>
        </form>
        <form>
            <button></button>
        </form>
    </div>
    <script>
        function DisplayBorrowBlock() {
            var BorrowBlock = document.getElementById("Borrow");
            if (BorrowBlock.style.display === "none") {
                BorrowBlock.style.display = "block";
            } else {
                BorrowBlock.style.display = "none";
            }
        }

        function DisplayReturnBlock() {
            var ReturnBlock = document.getElementById("Return");
            if (ReturnBlock.style.display === "none") {
                ReturnBlock.style.display = "block";
            } else {
                ReturnBlock.style.display = "none";
            }
        }

    </script>
</body>

</html>
