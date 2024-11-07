<?php
session_start();
require_once("../../datos/DAOProfesor.php");

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
    <link rel="stylesheet" href="../css/eliminarAlumno.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,100,1,-25" />
    <title></title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-sm" style="height: 69px;">
        <div class="container-fluid">
            <div class="name-application" href="#">
                <img src="../imgs/CamposNFCLogo.png" alt="Logo" width="50" class="d-inline-block align-text-top">
                <a class="nav-link active" aria-current="page">I'm Here!</a>
            </div>
            <div class="name-window">
                <a class="nav-link active" aria-current="page">Eliminar alumno</a>
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
    if ((isset($_GET['id']) && is_numeric($_GET['id'])) && isset($_GET['noControl'])) {
        $idGrupo = $_GET['id'];
        $noControl = $_GET['noControl'];

        $dao = new DAOProfesor();
        $clase = $dao->obtenerClasePorId($idGrupo, $_SESSION["user"]);
        if ($clase) {

            $alumno = $dao->obtenerAlumnoPorClase($noControl, $idGrupo);
            if ($alumno)
            {
                if (isset($_POST['confirmar']) && $_POST['confirmar'] == "Si") {
                    $exito = $dao->eliminarAlumno($noControl, $idGrupo);
    
                    if ($exito) {
                        echo '<div class="alert alert-success" role="alert" id="success-message">El alumno se eliminó con éxito. Redirigiendo...</div>';
                        echo '<script>
                                setTimeout(function() {
                                    window.location.href = "verMateria.php?id=' . $idGrupo . '";
                                }, 3000);
                              </script>';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Error: No se pudo eliminar el alumno. Redirigiendo... </div>';
                            echo '<script>
                                    setTimeout(function() {
                                        window.location.href = "verMateria.php?id=' . $idGrupo . '";
                                    }, 3000);
                                    </script>';
                    }
                }   
                
            } else 
            {
                $alumno = new Alumno(); $alumno->noControl = $alumno->Nombre = $alumno->Apellidos = "N/A";
                echo '<div class="alert alert-danger" role="alert">Error: No se encontro el alumno.</div>';
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "selectorDeGrupos.php";
                        }, 3000);
                      </script>';   
            }

            
        } else {
            $clase = new Grupo(); $clase->Nombre = "No encontrada";
            $alumno = new Alumno(); $alumno->noControl = $alumno->Nombre = $alumno->Apellidos = "N/A";
            echo '<div class="alert alert-danger" role="alert">Error: No se encontro la clase.</div>';
            echo '<script>
                        setTimeout(function() {
                            window.location.href = "selectorDeGrupos.php";
                        }, 3000);
                      </script>';
        }
    } else {
        $clase = new Grupo(); $clase->Nombre = "No encontrada";
        $alumno = new Alumno(); $alumno->noControl = $alumno->Nombre = $alumno->Apellidos = "N/A";
        echo '<div class="alert alert-danger" role="alert">Error: No se encontro la clase y/o alumno.</div>';
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
                <span>¿Deseas eliminar al alumno "<?= $alumno->noControl . " | " . $alumno->Nombre . " " . $alumno->Apellidos?>" de la clase "<?= $clase->Nombre?>" de forma permanente?</span>
            </div>
            <div id="botones">
                <form method="post">
                    <input type="hidden" name="noControl" value="<?= $noControl ?>">
                    <a href="verMateria.php?id=<?= $idGrupo ?>" class="btn btn-danger" id="btnCancelar">Cancelar</a>
                    <button type="submit" class="btn btn-success" id="btnSi" name="confirmar" value="Si">Aceptar</button>
                </form>
            </div>
        </div>
</body>

</html>