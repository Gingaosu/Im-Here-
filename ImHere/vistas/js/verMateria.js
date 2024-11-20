document.addEventListener('DOMContentLoaded', function () {
    var table = $('#tblAlumnos').DataTable({
        language: {
            "decimal": "",
            "emptyTable": "Ninguna materia seleccionada",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        columnDefs: [
            { targets: [2], orderable: false } // Desactiva la ordenación en las columnas 2 y 3
        ]
    });

    document.getElementById("registro_clasico").addEventListener("click", function () {
        if (!idClase) {
            alert("ID de clase no definido. Verifica la configuración.");
            return;
        }
    
        const fechaSeleccionada = document.getElementById("fecha").value;
    
        // Verificar si ya hay asistencias registradas
        fetch("verificarRegistro.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ idClase, fecha: fechaSeleccionada })
        })
            .then(response => response.json())
            .then(data => {
                if (data.registrado) {
                    alert("Las asistencias para esta clase ya han sido registradas como faltas.");
                    return;
                }
    
                // Si no están registradas, proceder con la confirmación
                if (confirm("¿Deseas registrar automáticamente las asistencias como faltas?")) {
                    fetch("registroClasico.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ idClase, fecha: fechaSeleccionada })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert("Asistencias registradas exitosamente.");
                                location.reload(); // Recargar la página para reflejar los cambios
                            } else {
                                alert("Hubo un error al registrar asistencias: " + (data.message || "Error desconocido"));
                            }
                        })
                        .catch(error => console.error("Error:", error));
                }
            })
            .catch(error => console.error("Error al verificar el registro:", error));
    });
    
    
    

    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("btn-toggle-asistencia")) {
            const button = event.target;
            const noControl = button.dataset.nocontrol;
            const idClase = button.dataset.clase;
            const asistencia = button.dataset.asistencia === "true";
    
            fetch("actualizarAsistencia.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ noControl, idClase, asistencia })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        button.textContent = data.nuevoEstado ? "Sí" : "No";
                        button.dataset.asistencia = data.nuevoEstado.toString();
                    } else {
                        alert("Error al actualizar asistencia: " + data.message);
                    }
                })
                .catch(error => console.error("Error:", error));
        }
    });
    
    
    
    
});