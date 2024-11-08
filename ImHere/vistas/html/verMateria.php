<?php
require_once("../../datos/DAOProfesor.php");
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/verMateria.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,100,1,-25" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">
    <title>Ver materia</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-sm" style="height: 69px;">
        <div class="container-fluid">
            <div class="name-application" href="#">
                <img src="../imgs/CamposNFCLogo.png" alt="Logo" width="50" class="d-inline-block align-text-top">
                <a class="nav-link active" aria-current="page">I'm Here!</a>
            </div>
            <div class="name-window">
                <a class="nav-link active" aria-current="page">Ver materia</a>
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
    $dao = new DAOProfesor();
    if ((isset($_GET['id']) && is_numeric($_GET["id"]))) {
        $idClase = $_GET['id'];
        // Crear una instancia del DAO y obtener los datos de la clase
        $clase = $dao->obtenerClasePorId($idClase, $_SESSION['user']);
        $alumnos = $dao->obtenerAlumnos($idClase, $_SESSION['user']);
        if ($clase) {
            $nombreMateria = htmlspecialchars($clase->Nombre);
            $codigoGrupo = htmlspecialchars($clase->CodigoGrupo);
            $horaInicio = htmlspecialchars(date("H:i", strtotime($clase->HoraInicio)));
            $horaFin = htmlspecialchars(date("H:i", strtotime($clase->HoraFin)));
        } else {
            // Manejar el caso donde la clase no se encuentra
            $nombreMateria = "Clase no encontrada";
            $codigoGrupo = "N/A";
            $horaInicio = "N/A";
            $horaFin = "N/A";

            echo '<div class="alert alert-danger" role="alert">Error: No se encontró la clase. Redirigiendo...</div>';
            echo '<script>
                        setTimeout(function() {
                            window.location.href = "selectorDeGrupos.php";
                        }, 3000);
                      </script>';
        }
    } else {
        $nombreMateria = "Clase no encontrada";
        $codigoGrupo = "N/A";
        $horaInicio = "N/A";
        $horaFin = "N/A";

        echo '<div class="alert alert-danger" role="alert">Error: No se encontró la clase. Redirigiendo...</div>';
        echo '<script>
                        setTimeout(function() {
                            window.location.href = "selectorDeGrupos.php";
                        }, 3000);
                      </script>';
    }

    $fecha = date("Y-m-d");

    ?>

    <div class="superior">
        <a href="selectorDeGrupos.php" class="btn btn-outline-light">Regresar</a>
    </div>
    <div class="form">
        <div class="calendario">
            <div class="encabezado">
                <div class="materia">
                    <label for="" id="txtMateria"><?php echo $nombreMateria; ?></label>
                    <label for="" id="txtGrupo"><?php echo $codigoGrupo; ?> | <?php echo $horaInicio; ?> - <?php echo $horaFin; ?></label>
                    <!-- <label for="" id="txtGrupo"><?php echo $horaInicio; ?> - <?php echo $horaFin; ?></label> -->
                </div>
                <div class="botonesCalendario">
                    <div class="SubBtnCalnd">
                        <!-- <input type="date" id="fecha" onchange="obtenerAsistencias()"> -->
                        <input type="date" id="fecha" onchange="obtenerAsistencias()" value="<?= htmlspecialchars($fecha) ?>">

                        <!-- <a href="registroManual.php?id=<?php echo $idClase; ?>" class="btn btn-primary">Registrar</a> -->
                        <a id="registroLink" href="registroManual.php?id=<?= urlencode($idClase) ?>&fecha=" class="btn btn-primary">Registrar</a>
                        <a href="agregarAlumnoPopUp.php?id=<?= urlencode($idClase) ?>" class="btn btn-success">Agregar alumno</a>
                    </div>
                </div>
            </div>
            <div class="datos">
                <div class="tabla">
                    <table id="tblAlumnos" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre del alumno</th>
                                <th>Número de control</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($alumnos) && is_array($alumnos) && count($alumnos) > 0) : ?>
                                <?php foreach ($alumnos as $alumno) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($alumno->Nombre . ' ' . $alumno->Apellidos); ?></td>
                                        <td><?php echo htmlspecialchars($alumno->noControl); ?></td>
                                        <td><a href="eliminarAlumno.php?id=<?= urlencode($idClase) ?>&noControl=<?= urlencode($alumno->noControl) ?>" class="btn btn-danger">Eliminar</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="1">No hay alumnos registrados en esta clase.</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="resumen">
            <div class="alumnos">
                <table id="tblAsistencias" class="table table-striped">

                </table>
            </div>
            <div class="btnsRes">
                <button type="button" class="btn btn-success" id="btnExportar">Exportar</button>
                <!-- <button type="button" class="btn btn-primary">Guardar</button> -->
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
    <script src="../js/verMateria.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var fechaInput = document.getElementById('fecha');
            var changeEvent = new Event('change');
            fechaInput.dispatchEvent(changeEvent);
        });
        document.getElementById('fecha').addEventListener('change', function() {
            var fechaSeleccionada = this.value;
            var idClase = <?php echo json_encode($idClase); ?>;
            var registroLink = document.getElementById("registroLink");
            registroLink.href = "registroManual.php?id=" + encodeURIComponent(idClase) + "&fecha=" + encodeURIComponent(fechaSeleccionada);
        });

        function obtenerAsistencias() {
            var fechaSeleccionada = document.getElementById("fecha").value;
            //console.log(fechaSeleccionada);
            // console.log(fechaSeleccionada);
            var idClase = <?php echo json_encode($idClase); ?>;
            // Obtener el enlace por su ID
            // var registroLink = document.getElementById("registroLink");
            // Modificar la URL del enlace agregando el valor de la fecha
            /* registroLink.href = "registroManual.php?id=<?= urlencode($idClase) ?>"; */

            // Crear una solicitud AJAX
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Actualizar el contenido de 'resultado' con la respuesta del servidor
                    document.getElementById("tblAsistencias").innerHTML = this.responseText;
                }
            };
            // Hacer una solicitud GET al método PHP con la fecha y el idClase como parámetros
            xhttp.open("GET", "obtenerAsistencias.php?fecha=" + fechaSeleccionada + "&idClase=" + idClase, true);
            xhttp.send();
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script>
        document.getElementById('btnExportar').addEventListener('click', function() {
            const tabla = document.getElementById('tblAsistencias');
            const data = [
                ['Alumno', 'Fecha', 'Asistio']
            ];
            for (let i = 1; i < tabla.rows.length; i++) {
                const fila = [];
                for (let j = 0; j < tabla.rows[i].cells.length; j++) {
                    fila.push(tabla.rows[i].cells[j].textContent);
                }
                data.push(fila);
            }

            const workbook = XLSX.utils.book_new();
            const worksheet = XLSX.utils.aoa_to_sheet(data);
            XLSX.utils.book_append_sheet(workbook, worksheet, 'Datos');
            XLSX.writeFile(workbook, 'export.xlsx', {
                type: 'binary'
            });
        });
    </script>

</body>

</html>