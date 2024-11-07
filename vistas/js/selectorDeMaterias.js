document.addEventListener('DOMContentLoaded', function() {
    var table = $('#tblAsistencia').DataTable({
        language: {
            "decimal": "",
            "emptyTable": "Sin datos",
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
        }
    });

    document.querySelectorAll('.verAsistencia').forEach(button => {
        button.addEventListener('click', function() {
            const clase = parseInt(this.getAttribute('data-idClase'));
            const filteredAsistencias = asistencias.filter(asistencia => asistencia.idClase === clase);
            const tbody = $('#tblAsistencia tbody');

            // Limpiar la tabla antes de agregar nuevos datos
            table.clear().draw();

            if (filteredAsistencias.length > 0) {
                filteredAsistencias.forEach(item => {
                    const asistencia = item.Asistencia ? 'Sí­' : 'No';
                    const fecha = item.Fecha;
                    table.row.add([asistencia, fecha]).draw(); // Agregar fila usando DataTables
                });
            } else {
                tbody.append('<tr><td colspan="3">No hay datos de asistencia disponibles.</td></tr>');
            }
        });
    });
});