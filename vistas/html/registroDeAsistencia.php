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

$id = isset($_GET['id']) ? $_GET['id'] : 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/registroDeAsistencia.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Registro de asistencia</title>
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
            <div class="name-help">
                <a class="nav-link active" aria-current="page" style="font-size: 16px;">¿No tienes tu tarjeta?</a>
                <form class="d-flex" role="search">
                    <a href="registroManual.php?id=<?php echo $id; ?>" class="btn btn-sm btn-outline-light" type="button"
                        id="btnRegsitroManual">Registro manual</a>
                </form>
            </div>
        </div>
    </nav>

    <div class="superior">
        <a href="verMateria.php?id=<?php echo $id; ?>" class="btn btn-outline-light">Regresar</a>
    </div>
    <div class="form">

        <div class="centro">

            <div class="icon">
                <img src="../imgs/iconoEsperandoTarjeta.png" alt="">
            </div>

            <div class="tarj">
                <label for="txtTarjeta">Esperando tarjeta</label>
            </div>

        </div>
    </div>
</body>

</html>