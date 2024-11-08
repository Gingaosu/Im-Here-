document.addEventListener('DOMContentLoaded', function() {
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
});