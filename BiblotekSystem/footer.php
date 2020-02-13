<script>
    function LoginModalDisplay(NumValue) {
        if (NumValue > 0) {
            document.getElementsByClassName("Modal")[0].style.display = "grid";
            document.getElementsByClassName("Modal")[0].getElementsByClassName("Inputs")[0].focus();
        } else {
            document.getElementsByClassName("Modal")[0].style.display = "none";
        }
    }

    function InputColorWhite(event) {
        event.target.style.color = "black";
    }

    function SubmitLoginForm() {
        document.getElementsByClassName("LoginForm")[0].submit();
    }

    function onloadInputs(Value) {
        event.target.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                switch (Value) {
                    case 2:
                        event.target.parentElement.parentElement[event.target.parentElement.parentElement.childElementCount - 1].click();
                        break;
                    case 1:
                        evet.target.parentElement[event.target.parentElement.childElementCount - 1].click();
                        break;
                    case 3:
                        event.target.parentElement.parentElement.children[event.target.parentElement.parentElement.childElementCount - 1].click();
                }
            }
        });

    }

</script>

</body>

</html>
