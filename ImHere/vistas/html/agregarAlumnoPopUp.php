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
    <link rel="stylesheet" href="../css/agregarAlumnoPopUp.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,100,1,-25" />
    <title>Agregar Alumno</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-sm" style="height: 69px;">
        <div class="container-fluid">
            <div class="name-application" href="#">
                <img src="../imgs/CamposNFCLogo.png" alt="Logo" width="50" class="d-inline-block align-text-top">
                <a class="nav-link active" aria-current="page">I'm Here!</a>
            </div>
            <div class="name-window">
                <a class="nav-link active" aria-current="page">Agregar alumno</a>
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
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];

        $dao = new DAOProfesor();
        $clase = $dao->obtenerClasePorId($id, $_SESSION["user"]);
        if ($clase) {

            $numControl = "";
            if (isset($_POST["txtNumCont"])) {
                $numControl = strtoupper(trim($_POST["txtNumCont"]));

                // Validación del número de control
                if (strlen($numControl) == 9) {

                    $verificarAlumno = $dao->obtenerAlumnoPorClase($numControl, $id);
                    if (!$verificarAlumno) {

                        $agregarAlumno = $dao->agregarAlumno($numControl, $id);
                        if ($agregarAlumno) {
                            echo '<script>
                                setTimeout(function() {
                                    window.location.href = "verMateria.php?id=' . $id . '";
                                }, 3000); // 3000 milisegundos = 3 segundos
                                 </script>';
                            echo '<div class="alert alert-success" role="alert">Alumno agregado exitosamente. Redirigiendo...</div>';
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Error: No se pudo agregar el alumno. Redirigiendo... </div>';
                            echo '<script>
                                setTimeout(function() {
                                    window.location.href = "verMateria.php?id=' . $id . '";
                                }, 3000);
                                </script>';
                        }
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Error: Alumno ya registrado. Redirigiendo... </div>';
                        echo '<script>
                                setTimeout(function() {
                                    window.location.href = "verMateria.php?id=' . $id . '";
                                }, 3000);
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
            } //POST
        } else {
            //ERROR EN CLASE - PROFE
            echo '<div class="alert alert-danger" role="alert">Error: No se encontro la clase. Redirigiendo...</div>';
            echo '<script>
                        setTimeout(function() {
                            window.location.href = "selectorDeGrupos.php";
                        }, 3000);
                      </script>';
        }
    } else {
        //ERROR EN GET ID
        echo '<div class="alert alert-danger" role="alert">Error: No se encontro la clase.</div>';
        echo '<script>
                        setTimeout(function() {
                            window.location.href = "selectorDeGrupos.php";
                        }, 3000);
                      </script>';
    }
    ?>

    <form class="form" method="post" novalidate>
        <div class="centro">
            <div id="Agregar_alumno">
                <span>Alumno</span>
            </div>
            <div class="nom">
                <label for="txtNumCont">Número de control</label>
                <input type="text" class="form-control" id="txtNumCont" name="txtNumCont" value="<?= htmlspecialchars($numControl) ?>" maxlength="9" required>
            </div>
            <div class='alert alert-danger' role='alert' style="margin: 10px;" id="msgErrorAlumno"></div>


            <div id="botones">
                <a href="verMateria.php?id=<?php echo $id; ?>" class="btn btn-danger" id="btnCancelar">Cancelar</a>
                <button type="submit" class="btn btn-success" id="btnAceptar">Aceptar</button>
            </div>
        </div>
    </form>
    <script src="../js/agregarAlumnoPopUp.js"></script>
</body>

</html>