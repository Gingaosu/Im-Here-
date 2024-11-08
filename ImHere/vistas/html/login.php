<?php
require_once("../../datos/DAOAlumno.php");
require_once("../../datos/DAOProfesor.php");

$user = $password = $errorMsg = "";

if (isset($_POST["txtUser"]) && isset($_POST["txtPassword"])) {
    $user = strtoupper(trim($_POST["txtUser"]));
    $password = trim($_POST["txtPassword"]);

    // Validar los datos
    if ((strlen($user) == 5 || strlen($user) == 9) && (strlen($password) < 20 && strlen($password) != 0)) {

        $dao = new DAOAlumno();
        $alumno = $dao->autenticarAl($user, $password);
        $dao = new DAOProfesor();
        $profesor = $dao->autenticarPf($user, $password);

        if ($alumno) {
            iniciarSesion($user, $alumno->Nombre . " " . $alumno->Apellidos, "selectorDeMaterias.php",false);
        } else if ($profesor) {
            iniciarSesion($user, $profesor->Nombre . " " . $profesor->Apellidos, "selectorDeGrupos.php",true);
        } else {
            $errorMsg = '<div id="phpErrorAlert" class="alert alert-danger" role="alert" style="margin: 10px;">Usuario y/o contraseña incorrectos.</div>';
        }
    } else {
        $errorMsg = "Validacion de inputs.";
    }
}

function iniciarSesion($user, $nombre, $redirect, $tipo)
{
    session_start();
    $_SESSION["user"] = $user;
    $_SESSION["tipo"] = $tipo;
    $_SESSION["nombre"] = $nombre;
    var_dump($_SESSION); // Verifica el contenido de la sesión
    header("Location: $redirect");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,100,1,-25" />
    <title>Login</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-sm" style="height: 69px;">
        <div class="container-fluid">
            <div class="name-application">
                <a href="../index.php">
                    <img src="../imgs/CamposNFCLogo.png" alt="Logo" width="50" class="d-inline-block align-text-top">
                    I'm Here!
                </a>
            </div>
            <div class="name-window">
                <a class="nav-link active" aria-current="page">Login</a>
            </div>
            <div class="name-vacio"></div>
        </div>
    </nav>

    <form class="form" method="post" novalidate>
        <div class="centro">
            <div class="icon">
                <span class="material-symbols-outlined" style="font-size: 150px; color: white;">account_circle</span>
            </div>
            <div class="us">
                <label for="txtUsuario">Usuario</label>
                <input type="text" name="txtUser" value="<?= $user ?>" class="form-control" id="txtUsuario" maxlength="9" required>
            </div>
            <div class="cont">
                <label for="txtPassword">Contraseña</label>
                <input type="password" name="txtPassword" value="<?= $password ?>" class="form-control" id="txtPassword" maxlength="20" required>
            </div>
            
            <div class="alert alert-danger" role="alert" style="margin: 10px; display: none;" id="msgError"></div>
            <?=$errorMsg?>

            <div>
                <button type="submit" id="loginUsuario" class="btn btn-success">Iniciar sesión</button>
            </div>
        </div>
    </form>
    <script src="../js/login.js"></script>
</body>

</html>