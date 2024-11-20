<?php
header("Content-Type: application/json");
require_once("../../datos/DAOProfesor.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    $idClase = $input['idClase'] ?? null;
    $fecha = $input['fecha'] ?? null;

    if ($idClase && $fecha) {
        $dao = new DAOProfesor();
        $registrado = $dao->verificarAsistenciaRegistrada($idClase, $fecha);

        echo json_encode(["registrado" => $registrado]);
    } else {
        echo json_encode(["registrado" => false, "message" => "Datos incompletos."]);
    }
} else {
    echo json_encode(["registrado" => false, "message" => "Método no permitido."]);
}
