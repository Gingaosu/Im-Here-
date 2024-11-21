<?php
header("Content-Type: application/json");
require_once("../../datos/DAOProfesor.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    $idClase = $input['idClase'] ?? null;
    $fecha = $input['fecha'] ?? null;

    if ($idClase && $fecha) {
        $dao = new DAOProfesor();
        $success = $dao->registrarAsistenciaAlumnos($idClase, $fecha);

        if ($success) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "No se pudieron registrar las asistencias."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Datos incompletos."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
?>

