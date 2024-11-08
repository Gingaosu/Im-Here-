document.addEventListener("DOMContentLoaded", () => {

    let msgError = document.getElementById("msgError");

    document.getElementById("btnAceptar").addEventListener("click", e => {

        let txtUsuario = document.getElementById("txtUsuario");

        txtUsuario.setCustomValidity("");
        msgError.style.display = "none";

        if (txtUsuario.value.trim().length != 9){
            txtUsuario.setCustomValidity("Invalido");
        } 
        
        if (!e.target.form.checkValidity()) {
            msgError.style.display = "block";
            msgError.innerText = "Usuario incorrecto (9 caracteres)."
            e.preventDefault();
        } 
    });

    document.getElementById("txtUsuario").addEventListener("keyup", (e) => {
        msgError.style.display = "none";
    });

});
