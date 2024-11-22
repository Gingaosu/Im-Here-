<?php
session_start();
require_once("../../datos/DAOProfesor.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] === false) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; 
    header("Location: selectorDeMaterias.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// $id = isset($_GET['id']) ? $_GET['id'] : 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/registroManual.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,100,1,-25" />
    <title>Registro manual</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-sm" style="height: 69px;">
        <div class="container-fluid">
            <div class="name-application" href="#">
                <a href="selectorDeGrupos.html">
                    <img src="../imgs/CamposNFCLogo.png" alt="Logo" width="50" class="d-inline-block align-text-top">
                    I'm Here!
                </a>
            </div>
            <div class="name-window">
                <a class="nav-link active" aria-current="page">Registro de asistencia</a>
            </div>
            <div class="name-teacher">
                <?php if (isset($_SESSION["nombre"])) : ?>
                    <a class="nav-link active" aria-current="page"><?php echo $_SESSION["nombre"]; ?></a>
                <?php endif; ?>
                <span class="material-symbols-outlined" style="font-size: 40px;">
                    account_circle
                </span>
                <form class="d-flex" role="search" method="get">
                    <button type="submit" name="logout" class="btn btn-sm btn-outline-light">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <?php
    // Obtener el idClase del GET
    // $idClase = isset($_GET['id']) ? intval($_GET['id']) : null;
    // $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;
    // var_dump($fecha);
    if ((isset($_GET['id']) && is_numeric($_GET['id'])) && $fecha = isset($_GET['fecha'])) {
        $idClase = $_GET['id'];
        $fecha = $_GET['fecha'];

        $dao = new DAOProfesor();
        $clase = $dao->obtenerClasePorId($idClase, $_SESSION["user"]);

        if ($clase) {

            //if ($fecha == date('Y-m-d')) {
                $asistenciaRegistrada = $dao->verificarAsistenciaRegistrada($idClase, $fecha);
            if ($asistenciaRegistrada) {
                //echo 'ya estaba hecho we';
            } else {
                // Registrar la asistencia de los alumnos
                $resultado = $dao->registrarAsistenciaAlumnos($idClase, $fecha);
                if ($resultado) {
                    //echo 'se pudo we';
                } else {
                    //echo 'no se pudo we';
                }
            }
            /*} else 
            {
                //ERROR EN fecha - PROFE
            echo '<div class="alert alert-danger" role="alert">Error: Fecha modificada. Redirigiendo...</div>';
            echo '<script>
                        setTimeout(function() {
                            window.location.href = "verMateria.php?id=' . $idClase . '";
                        }, 3000);
                      </script>';

            }*/
        } else {
            //ERROR EN CLASE - PROFE
            echo '<div class="alert alert-danger" role="alert">Error: No se encontro la clase. Redirigiendo...</div>';
            echo '<script>
                        setTimeout(function() {
                            window.location.href = "selectorDeGrupos.php";
                        }, 3000);
                      </script>';
        }
        //var_dump($idClase);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar si se han recibido los datos esperados
            if (isset($_POST['noControl']) && (isset($_POST['claseId']) && is_numeric($_POST['claseId'])) && isset($_POST['fecha'])) {
                // Recuperar los valores enviados
                $noControl = strtoupper($_POST['noControl']);
                $claseId = intval($_POST['claseId']);
                $fecha = $_POST['fecha'];

                $clase = $dao->obtenerClasePorId($claseId, $_SESSION["user"]);
                if (strlen($noControl) == 9 && $clase /*&& $fecha == date('Y-m-d')*/) {

                    //var_dump($fecha);
                    // Actualizar la asistencia
                    $alumnoEncontrado = $dao->obtenerAlumnoPorClase($noControl, $claseId);
                    if ($alumnoEncontrado) {
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
                            echo '<div class="alert alert-danger" role="alert">Error: No se pudo actualizar la asistencia.</div>';
                            echo '<script>
                            setTimeout(function() {
                                var errorMsg = document.querySelector(".alert-danger");
                                if (errorMsg) {
                                    errorMsg.remove();
                                }
                            }, 3000);
                        </script>';
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Error: Alumno no encontrado.</div>';
                        echo '<script>
                            setTimeout(function() {
                                var errorMsg = document.querySelector(".alert-danger");
                                if (errorMsg) {
                                    errorMsg.remove();
                                }
                            }, 3000);
                        </script>';
                    }
                } else { //VALIDACION POST
                    echo '<div class="alert alert-danger" role="alert">Error: Datos incorrectos.</div>';
                    echo '<script>
                        setTimeout(function() {
                            var errorMsg = document.querySelector(".alert-danger");
                            if (errorMsg) {
                                errorMsg.remove();
                            }
                        }, 3000);
                    </script>';
                }
            } 
        }
    } else {
         //ERROR EN GET
         echo '<div class="alert alert-danger" role="alert">Error: Clase y/o fecha erroneas.</div>';
         echo '<script>
                         setTimeout(function() {
                             window.location.href = "selectorDeGrupos.php";
                         }, 3000);
                       </script>';
    }


    ?>

    <div class="superior">
        <a href="verMateria.php?id=<?php echo $idClase; ?>" class="btn btn-outline-dark">Regresar</a>
    </div>
    <div class="form" novalidate>
        <div class="texto">
            <label for="txtUsuario">Ingrese su número de control</label>
        </div>
        <div class="centro">
            <input type="text" class="form-control" id="txtUsuario" autofocus maxlength="9">
        </div>
        <div class="alert alert-danger" role="alert" style="margin: 10px; display: none;" id="msgError"></div>

        <div class="btnAcept">
            <!-- <button type="text" class="btn btn-outline-light" id="btnAceptar">Aceptar</button> -->
            <button type="button" class="btn btn-success" id="btnAceptar">Aceptar</button>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
    <script>
        $(document).ready(function() {
            // Function to handle the form submission
            function submitForm() {
                var noControl = $('#txtUsuario').val();
                var idClase = "<?php echo $idClase; ?>"
                var fecha = "<?php echo $fecha; ?>";

                var msgError = $("#msgError");
                msgError.hide();
                if (noControl.trim().length !== 9) {
                    msgError.show().text("Usuario incorrecto (9 caracteres).");
                    return;
                }

                // Crear un formulario dinámico y enviarlo mediante POST
                var form = $('<form method="POST"></form>');
                form.append('<input type="hidden" name="noControl" value="' + noControl + '">');
                form.append('<input type="hidden" name="claseId" value="' + idClase + '">');
                form.append('<input type="hidden" name="fecha" value="' + fecha + '">');
                form.appendTo('body').submit();
            }

            // Bind click event to the button
            $('#btnAceptar').click(submitForm);

            // Bind keyup event to the input
            $('#txtUsuario').on('keyup', function(e) {
                $("#msgError").hide();
                if (e.key === 'Enter') {
                    submitForm();
                }
            });
        });
    </script>
    <!-- <script src="../js/registroManual.js"></script> -->
</body>

</html>