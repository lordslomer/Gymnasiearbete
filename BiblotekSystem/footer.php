<script>
    function LoginModalDisplay(NumValue) {
        if (NumValue > 0) {
            console.log(document.getElementsByClassName("Modal").length);
            document.getElementsByClassName("Modal")[0].style.display = "grid";
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

</script>

</body>

</html>
