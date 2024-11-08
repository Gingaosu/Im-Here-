<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/selectorDeMaterias.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,100,1,-25" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">
    <title>Selector de materias</title>
</head>

<body>
    <?php
    require_once ("../../datos/DAOAlumno.php");
    session_start();
    //var_dump($_SESSION["user"]);
    //var_dump($_SESSION["nombre"]);
    
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit();
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        header("Location: login.php");
        exit();
    }

    $dao = new DAOALumno();
    $materias = $dao->obtenerMaterias(array($_SESSION['user']));
    $asistencias = $dao->obtenerAsistencias(array($_SESSION['user']));
    ?>
    <nav class="navbar navbar-expand-lg navbar-sm" style="height: 69px;">
        <div class="container-fluid">
            <div class="name-application" href="#">
                <img src="../imgs/CamposNFCLogo.png" alt="Logo" width="50" class="d-inline-block align-text-top">
                <a class="nav-link active" aria-current="page">I'm Here!</a>
            </div>
            <div class="name-window">
                <a class="nav-link active" aria-current="page">Selector de materias</a>
            </div>
            <div class="name-teacher">
                <?php if (isset($_SESSION["nombre"])): ?>
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

    <div class="form">
        <div class="materias">
            <?php foreach ($materias as $materia) : ?>
            <div class="materia">
                <label id="txtNombre"><?= htmlspecialchars($materia->Nombre) ?></label>
                <label id="txtGrupo"><?= htmlspecialchars($materia->CodigoGrupo) ?></label>
                <label id="txtHorario"><?= date("H:i", strtotime($materia->HoraInicio)) ?> -
                    <?= date("H:i", strtotime($materia->HoraFin)) ?></label>
                <div class="btnMateria">
                    <button type="button" class="btn btn-primary verAsistencia"
                        data-idClase="<?php echo $materia->idClase; ?>">Ver asistencia</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="datos">
        <div class="tabla">
            <table id="tblAsistencia" class="table table-striped">
                <thead>
                    <tr>
                        <th>¿Asistí?</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Generar la variable asistencias con PHP -->
    <script>
    var asistencias = <?php echo json_encode($asistencias); ?>;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
    <script src="../js/selectorDeMaterias.js"></script>
</body>

</html>