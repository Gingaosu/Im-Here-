document.addEventListener("DOMContentLoaded", () => {

    let msgError = document.getElementById("msgError");
    let phpErrorAlert = document.getElementById("phpErrorAlert");
    //msgError.style.display = "none";

    document.getElementById("loginUsuario").addEventListener("click", e => {

        let txtUsuario = document.getElementById("txtUsuario");
        let txtPassword = document.getElementById("txtPassword");

        txtUsuario.setCustomValidity("");
        txtPassword.setCustomValidity("");

        if ((txtUsuario.value.trim().length != 5 && txtUsuario.value.trim().length != 9)){
            txtUsuario.setCustomValidity("Invalido");
        } 
        
        if (txtPassword.value.trim().length > 20 || txtPassword.value.trim().length == 0) {
            txtPassword.setCustomValidity("Invalido");
        } 
        
        if (!e.target.form.checkValidity()) {
            msgError.style.display = "block";
            msgError.innerText = "Usuario y/o contraseña incorrectos."
            e.preventDefault();
        } 
    });

    document.getElementById("txtPassword").addEventListener("keyup", (e) => {
        msgError.style.display = "none";
        hidePhpErrorAlert();
    });

    document.getElementById("txtUsuario").addEventListener("keyup", (e) => {
        msgError.style.display = "none";
        hidePhpErrorAlert();
    });

    function hidePhpErrorAlert() {
        if (phpErrorAlert) {
            phpErrorAlert.style.display = "none";
        }
    }

});
