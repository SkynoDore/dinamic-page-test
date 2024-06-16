document.addEventListener("DOMContentLoaded", function() {
    const passwordCheck1 = document.getElementById("passwordCheck1");
    const passwordField1 = document.getElementById("passwordfield1");

    const passwordCheck2 = document.getElementById("passwordCheck2");
    const passwordField2 = document.getElementById("passwordfield2");

    const passwordCheck3 = document.getElementById("passwordCheck3");
    const passwordField3 = document.getElementById("passwordfield3");

    function togglePassword(passwordField) {
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    }

    passwordCheck1.addEventListener("click", function(){
        togglePassword(passwordField1);
    });

    passwordCheck2.addEventListener("click", function(){
        togglePassword(passwordField2);
    });

    passwordCheck3.addEventListener("click", function(){
        togglePassword(passwordField3);
    });
});