<?php
require_once __DIR__ . '/../../datos/DAOProfesor.php';

$fecha = $_GET['fecha'];
$idClase = $_GET['idClase'];

$daoProfesor = new DAOProfesor();
$asistencias = $daoProfesor->obtenerAsistencias($idClase, $fecha);

if ($asistencias) {
    // Generar el contenido HTML de la tabla
    $html = '<thead><tr><th>Alumno</th><th>Fecha</th><th>¿Asistió?</th></tr></thead>';
    $html .= '<tbody>';
    foreach ($asistencias as $asistencia) {
        $html .= '<tr>';
        $html .= '<td>' . $asistencia->noControl . '</td>';
        $html .= '<td>' . $asistencia->Fecha . '</td>';
        $html .= '<td>' . ($asistencia->Asistencia ? 'Sí' : 'No') . '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody>';
    echo $html;
} else {
    echo '<p>No se encontraron asistencias para la fecha seleccionada.</p>';
}
?>

