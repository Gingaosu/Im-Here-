<?php
require_once ("../../datos/DAOProfesor.php");
session_start();

// Verificar si se ha recibido una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se han recibido los datos esperados
    if (isset($_POST['noControl']) && isset($_POST['claseId'])) {
        // Recuperar los valores enviados
        $noControl = $_POST['noControl'];
        $claseId = intval($_POST['claseId']);
        $fecha = $_POST['fecha'];

        // Crear una instancia del DAO
        $dao = new DAOProfesor();

        // Actualizar la asistencia
        $resultado = $dao->actualizarAsistencia($noControl, $claseId, $fecha);

        // Verificar si la actualización fue exitosa
        if ($resultado) {
            // Enviar una respuesta JSON de éxito
            echo '<div class="alert alert-success" role="alert">Asistencia registrada exitosamente.</div>';
            echo '<script>
                        setTimeout(function() {
                            var errorMsg = document.querySelector(".alert-success");
                            if (errorMsg) {
                                errorMsg.remove();
                            }
                        }, 3000);
                    </script>';
            //echo json_encode(['status' => 'success', 'message' => 'Asistencia actualizada correctamente']);
        } else {
            // Si hubo un error en la actualización, enviar una respuesta JSON de error
            //http_response_code(500);
            //echo json_encode(['status' => 'error', 'message' => 'Error al actualizar la asistencia']);
            
        }
    } else {
        // Si falta algún dato necesario, enviar una respuesta JSON de error
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Faltan datos necesarios para actualizar la asistencia']);
    }
    // Salir del script después de enviar la respuesta
    exit();
} else {
    // Si la solicitud no es de tipo POST, redireccionar a alguna página de error o mostrar un mensaje de error
    header("HTTP/1.0 405 Method Not Allowed");
    exit("405 Method Not Allowed");
}
?>
