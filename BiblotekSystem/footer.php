<script>
    function LoginModalDisplay(NumValue) {
        if (NumValue > 0) {
            document.getElementsByClassName("Modal")[0].style.display = "grid";
        } else {
            document.getElementsByClassName("Modal")[0].style.display = "none";
        }
    }

    function SubmitLoginForm() {
        document.getElementsByClassName("LoginForm")[0].submit();
    }

</script>

</body>

</html>
