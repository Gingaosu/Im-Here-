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
    <link rel="stylesheet" href="../css/borrarGrupo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,100,1,-25" />
    <title>Borrar grupo</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-sm" style="height: 69px;">
        <div class="container-fluid">
            <div class="name-application" href="#">
                <img src="../imgs/CamposNFCLogo.png" alt="Logo" width="50" class="d-inline-block align-text-top">
                <a class="nav-link active" aria-current="page">I'm Here!</a>
            </div>
            <div class="name-window">
                <a class="nav-link active" aria-current="page">Borrar grupo</a>
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

    if ((isset($_GET['id']) && is_numeric($_GET["id"]))) {
        $idGrupo = $_GET['id'];

        $dao = new DAOProfesor();
        $grupo = $dao->obtenerClasePorId($idGrupo, $_SESSION["user"]);
        if ($grupo) {
            $nomMat = $grupo->Nombre;
            $codigoGrupo = $grupo->CodigoGrupo;
            $horaInicio = $grupo->HoraInicio;
            $horaFin = $grupo->HoraFin;
        } else {
            echo '<script>
                            setTimeout(function() {
                                window.location.href = "selectorDeGrupos.php";
                            }, 3000); // 3000 milisegundos = 3 segundos
                          </script>';
            echo '<div class="alert alert-danger" role="alert">Error: No se encontró el grupo. Redireccionando...</div>';
        }

        if (isset($_POST['confirmar']) && $_POST['confirmar'] == "Si") {
            // Intentar eliminar el grupo
            $exito = $dao->eliminarGrupo($idGrupo);

            if ($exito) {
                echo '<div class="alert alert-success" role="alert" id="success-message">El grupo se eliminó con éxito. Redirigiendo...</div>';
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "selectorDeGrupos.php";
                        }, 3000);
                      </script>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error: No se pudo eliminar el grupo.</div>';
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "selectorDeGrupos.php";
                        }, 3000);
                      </script>';
            }
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Error: No se encontró el grupo.</div>';
        echo '<script>
                        setTimeout(function() {
                            window.location.href = "selectorDeGrupos.php";
                        }, 3000);
                      </script>';
    }
    ?>

    <div class="form">
        <div class="centro">
            <div id="eliminar">
                <span>¿Deseas borrar la clase "<?= $nomMat . " " . $codigoGrupo . " " . $horaInicio . " - " . $horaFin ?>" de forma permanente?</span>
            </div>
            <div id="botones">
                <form method="post">
                    <input type="hidden" name="id" value="<?= $idGrupo ?>">
                    <a href="selectorDeGrupos.php" class="btn btn-danger" id="btnCancelar">Cancelar</a>

                    <button type="submit" class="btn btn-primary" id="btnSi" name="confirmar" value="Si">Si</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>