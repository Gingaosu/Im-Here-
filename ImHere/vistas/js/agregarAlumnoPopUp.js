document.addEventListener("DOMContentLoaded", (e) => {
    let msgErrorAlumno = document.getElementById("msgErrorAlumno");
    msgErrorAlumno.style.display = "none";

    document.getElementById("btnAceptar").addEventListener("click", (e) => {
        let txtNumCont = document.getElementById("txtNumCont");

        txtNumCont.setCustomValidity("");
        msgErrorAlumno.style.display = "none";

        // Validación del número de control
        if (txtNumCont.value.trim().length !== 9) {
            txtNumCont.setCustomValidity("Invalido");
            msgErrorAlumno.style.display = "block";
            msgErrorAlumno.innerText = "El número de control es obligatorio y debe tener 9 caracteres.";
        }

        // Si el formulario no es válido, prevenir el envío
        if (!e.target.form.checkValidity()) {
            e.preventDefault();
            msgErrorAlumno.style.display = "block";
        }
    });

    // Ocultar el mensaje de error al escribir en el campo
    document.getElementById("txtNumCont").addEventListener("input", (e) => {
        msgErrorAlumno.style.display = "none";
        e.target.setCustomValidity("");
    });
});
