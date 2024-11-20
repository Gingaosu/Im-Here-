

<?php
require_once __DIR__ . '/../../datos/DAOProfesor.php';

$fecha = $_GET['fecha'] ?? null;
$idClase = $_GET['idClase'] ?? null;

$daoProfesor = new DAOProfesor();
$asistencias = $daoProfesor->obtenerAsistencias($idClase, $fecha);

if ($asistencias) {
    // Generar el contenido HTML de la tabla
    $html = '<thead><tr><th>Alumno</th><th>Fecha</th><th>¿Asistió?</th></tr></thead>';
    $html .= '<tbody>';
    foreach ($asistencias as $asistencia) {
        $asistio = $asistencia->Asistencia ? 'Sí' : 'No';
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($asistencia->noControl) . '</td>';
        $html .= '<td>' . htmlspecialchars($asistencia->Fecha) . '</td>';
        $html .= '<td>
                    <button 
                        class="btn btn-toggle-asistencia btn-sm btn-warning" 
                        data-nocontrol="' . htmlspecialchars($asistencia->noControl) . '" 
                        data-clase="' . htmlspecialchars($idClase) . '" 
                        data-asistencia="' . ($asistencia->Asistencia ? 'true' : 'false') . '">
                        ' . $asistio . '
                    </button>
                  </td>';
        $html .= '</tr>';
    }
    $html .= '</tbody>';
    echo $html;
} else {
    echo '<p>No se encontraron asistencias para la fecha seleccionada.</p>';
}
?>

