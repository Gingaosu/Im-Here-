<?php
header("Content-Type: application/json");
require_once("../../datos/DAOProfesor.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    $noControl = $input['noControl'] ?? null;
    $idClase = $input['idClase'] ?? null;
    $asistencia = isset($input['asistencia']) ? (bool)$input['asistencia'] : null;
    $fecha = date("Y-m-d");


    if ($noControl && $idClase && $asistencia !== null) {
        $dao = new DAOProfesor();
        $nuevoEstado = !$asistencia; // Alternar el estado actual
        $success = $dao->actualizarAsistencia($noControl, $idClase, $fecha);

        if ($success) {
            echo json_encode(["success" => true, "nuevoEstado" => $nuevoEstado]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar la asistencia."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Datos incompletos."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
