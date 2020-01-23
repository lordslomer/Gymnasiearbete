<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width = device-width, initial-scale = 1.0">
        <title> Main </title>
    </head>
    
    <body>
        <button onclick="DisplayBorrowBlock()">Låna</button>
        <button onclick="DisplayReturnBlock()">Lämna</button>
        <P Id="Borrow" >Här Lånar Man</P>
        <P Id="Return">Här lämnar Man</P>
        
        <script>
            function DisplayBorrowBlock() {
                var BorrowBlock= document.getElementById("Borrow");
                if (BorrowBlock.style.display === "none"){
                    BorrowBlock.style.display = "block";
                }
                else{
                    BorrowBlock.style.display = "none";
                }
            }
            
            function DisplayReturnBlock() {
                var ReturnBlock = document.getElementById("Return");
                if(ReturnBlock.style.display === "none"){
                    ReturnBlock.style.display = "block";
                }
                else{
                    ReturnBlock.style.display = "none";
                }
            }
</script>   
    </body>
</html> 