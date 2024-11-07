<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/selectorDeGrupos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,100,1,-25" />
    <title>Selector de grupos</title>
</head>

<body>

    <?php
    require_once("../../datos/DAOProfesor.php");
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

    $dao = new DAOProfesor();
    $grupos = $dao->obtenerGrupos(array($_SESSION['user']));
    ?>


    <nav class="navbar navbar-expand-lg navbar-sm" style="height: 69px;">
        <div class="container-fluid">
            <div class="name-application" href="#">
                <img src="../imgs/CamposNFCLogo.png" alt="Logo" width="50" class="d-inline-block align-text-top">
                <a class="nav-link active" aria-current="page">I'm Here!</a>
            </div>
            <div class="name-window">
                <a class="nav-link active" aria-current="page">Agregar grupo</a>
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

    <div class="superior">
        <a href="agregarGrupo.php" class="btn btn-success">Agregar</a>
    </div>

    <div class="form">
        <?php foreach ($grupos as $grupo) : ?>
            <div class="materia">
                <label for="txtNombre" id="txtNombre"><?= htmlspecialchars($grupo->Nombre) ?></label>
                <label for="txtGrupo" id="txtGrupo"><?= htmlspecialchars($grupo->CodigoGrupo) ?></label>
                <label for="txtHorario" id="txtHorario">
                    <?= date("H:i", strtotime($grupo->HoraInicio)) ?> - <?= date("H:i", strtotime($grupo->HoraFin)) ?></label>
                <div class="btnSMateria">
                    <div class="btnSeccion1">
                        <a href="editarGrupoPopUp.php?id=<?= urlencode($grupo->idClase) ?>" class="btn btn-secondary">Editar</a>
                        <a href="borrarGrupo.php?id=<?= urlencode($grupo->idClase) ?>" class="btn btn-danger">Eliminar</a>
                    </div>
                    <div class="btnSeccion2">
                        <a href="verMateria.php?id=<?= urlencode($grupo->idClase) ?>" class="btn btn-primary">Ver materia</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>