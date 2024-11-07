document.addEventListener("DOMContentLoaded", (e) => {
    let msgErrorNomMat = document.getElementById("msgErrorNomMat");
    let msgErrorGrupo = document.getElementById("msgErrorGrupo");
    let msgErrorHorario = document.getElementById("msgErrorHorario");

    msgErrorNomMat.style.display = "none";
    msgErrorGrupo.style.display = "none";
    msgErrorHorario.style.display = "none";

    document.getElementById("btnAceptar").addEventListener("click", (e) => {
        let txtNombreMateria = document.getElementById("txtNomMat");
        let txtGrupo = document.getElementById("txtGrupo");
        let txtInicio = document.getElementById("txtInicio");
        let txtFin = document.getElementById("txtFin");

        txtNombreMateria.setCustomValidity("");
        txtGrupo.setCustomValidity("");
        txtInicio.setCustomValidity("");
        txtFin.setCustomValidity("");
        msgErrorNomMat.style.display = "none";
        msgErrorGrupo.style.display = "none";
        msgErrorHorario.style.display = "none";

        if (txtNombreMateria.value.trim().length == 0 || txtNombreMateria.value.trim().length > 50) {
            txtNombreMateria.setCustomValidity("Invalido");
            msgErrorNomMat.style.display = "block";
            msgErrorNomMat.innerText = "El nombre de la materia es obligatorio (Maximo 50 caracteres)";
        }
        if (txtGrupo.value.trim().length != 4) {
            txtGrupo.setCustomValidity("Invalido");
            msgErrorGrupo.style.display = "block";
            msgErrorGrupo.innerText = "El nombre del grupo es obligatorio (4 caracteres)";
        } 
        
        if (txtInicio.value == txtFin.value) {
            txtInicio.setCustomValidity("Invalido");
            txtFin.setCustomValidity("Invalido");
            msgErrorHorario.style.display = "block";
            msgErrorHorario.innerText = "Las horas de inicio y fin no pueden ser iguales.";
        }
        
        if (txtFin.value == "" || txtInicio.value == "") {
            console.log(txtInicio.value +" || "+ txtFin.value);
            txtInicio.setCustomValidity("Invalido");
            txtFin.setCustomValidity("Invalido");
            msgErrorHorario.style.display = "block";
            msgErrorHorario.innerText = "El horario es obligatorio";
        }

        if (!e.target.form.checkValidity()) {
            e.preventDefault();
        } 
    });

    document.getElementById("txtNomMat").addEventListener("keyup", (e) => {
        msgErrorNomMat.style.display = "none";
    });

    document.getElementById("txtGrupo").addEventListener("keyup", (e) => {
        msgErrorGrupo.style.display = "none";
    });

    document.getElementById("txtInicio").addEventListener("keyup", (e) => {
        msgErrorHorario.style.display = "none";
    });

    document.getElementById("txtFin").addEventListener("keyup", (e) => {
        msgErrorHorario.style.display = "none";
    });
});
