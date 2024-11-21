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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/agregarGrupo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,100,1,-25" />
    <title>Editar grupo</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-sm" style="height: 69px;">
        <div class="container-fluid">
            <div class="name-application" href="#">
                <img src="../imgs/CamposNFCLogo.png" alt="Logo" width="50" class="d-inline-block align-text-top">
                <a class="nav-link active" aria-current="page">I'm Here!</a>
            </div>
            <div class="name-window">
                <a class="nav-link active" aria-current="page">Editar grupo</a>
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
    $nomMat = $codigoGrupo = $horaInicio = $horaFin = "";

    if (isset($_GET['id']) && is_numeric($_GET["id"])) {
        $idGrupo = $_GET['id'];

        $dao = new DAOProfesor();
        $grupo = $dao->obtenerClasePorId($idGrupo, $_SESSION["user"]);
        if ($grupo) {
            $nomMat = $grupo->Nombre;
            $codigoGrupo = $grupo->CodigoGrupo;
            $horaInicio = substr($grupo->HoraInicio,0,5);
            $horaFin = substr($grupo->HoraFin,0,5);
        } else {
            echo '<script>
                            setTimeout(function() {
                                window.location.href = "selectorDeGrupos.php";
                            }, 3000); // 3000 milisegundos = 3 segundos
                          </script>';
            echo '<div class="alert alert-danger" role="alert">Error: No se encontró el grupo. Redireccionando...</div>';
        }
    } else {
        echo '<script>
                            setTimeout(function() {
                                window.location.href = "selectorDeGrupos.php";
                            }, 3000); // 3000 milisegundos = 3 segundos
                          </script>';
        echo '<div class="alert alert-danger" role="alert">Error: No se encontró el grupo. Redireccionando...</div>';
    }

    if (isset($_POST["txtNomMat"]) && isset($_POST["txtGrupo"]) && isset($_POST["txtHoraInicio"]) && isset($_POST["txtHoraFin"])) {
        $idGrupo = $_POST['idGrupo'];
        $nomMat = trim($_POST["txtNomMat"]);
        $codigoGrupo = trim($_POST["txtGrupo"]);
        $horaInicio = trim($_POST["txtHoraInicio"]);
        $horaFin = trim($_POST["txtHoraFin"]);

        if ((strlen($nomMat) != 0 && strlen($nomMat) <= 50) &&
            strlen($codigoGrupo) == 4 &&
            (strlen($horaInicio) != "" && strlen($horaFin) != "") && $horaInicio != $horaFin
        ) {

            $dao = new DAOProfesor();
            $exito = $dao->editarGrupo($idGrupo, $nomMat, $codigoGrupo, $horaInicio, $horaFin);

            if ($exito) {
                echo '<div class="alert alert-success" role="alert">Grupo editado exitosamente. Redireccionando...</div>';
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "selectorDeGrupos.php";
                        }, 3000); // 3000 milisegundos = 3 segundos
                      </script>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error: No se pudo editar el grupo. Redireccionando...</div>';
                echo '<script>
                            setTimeout(function() {
                                window.location.href = "selectorDeGrupos.php";
                            }, 3000); // 3000 milisegundos = 3 segundos
                          </script>';
            }
        } else {
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
    ?>

    <form class="form" method="post" novalidate>
        <div class="centro">
            <div id="Agregar_grupo">
                <span>Grupo</span>
            </div>
            <div class="nom">
                <label for="txtNomMat">Nombre de la materia</label>
                <input type="text" name="txtNomMat" value="<?= isset($nomMat) ? $nomMat : '' ?>" class="form-control" id="txtNomMat" maxlength="50" required>
            </div>
            <div class='alert alert-danger' role='alert' id="msgErrorNomMat" style="margin: 5px;"></div>

            <div class="grup">
                <label for="txtGrupo">Grupo</label>
                <input type="text" name="txtGrupo" value="<?= isset($codigoGrupo) ? $codigoGrupo : '' ?>" class="form-control" id="txtGrupo" maxlength="4" required>
            </div>
            <div class='alert alert-danger' role='alert' id="msgErrorGrupo" style="margin: 5px;"></div>

            <div class="hor">
                <div class="horaInicio">
                    <label for="txtHorario">Hora de inicio</label>
                    <input type="time" name="txtHoraInicio" value="<?= isset($horaInicio) ? $horaInicio : '' ?>" class="form-control" id="txtInicio" required>
                </div>
                <div class="horaFin">
                    <label for="txtHorario">Hora de Fin</label>
                    <input type="time" name="txtHoraFin" value="<?= isset($horaFin) ? $horaFin : '' ?>" class="form-control" id="txtFin" required>
                </div>
            </div>
            <div class='alert alert-danger' role='alert' id="msgErrorHorario" style="margin: 5px;"> </div>
            
            <input type="hidden" name="idGrupo" value="<?= isset($_GET['id']) ? $_GET['id'] : '' ?>">
            <div id="botones">
                <a href="selectorDeGrupos.php" class="btn btn-danger" id="btnCancelar">Cancelar</a>
                <button type="submit" class="btn btn-primary" id="btnAceptar">Aceptar</button>
            </div>
        </div>
    </form>

    <script src="../js/editarGrupo.js"></script>
</body>

</html>