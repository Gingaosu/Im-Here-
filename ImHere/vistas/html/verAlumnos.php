<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/verAlumnos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,100,1,-25" />
    <title>Ver alumnos</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-sm" style="height: 69px;">
        <div class="container-fluid">
            <div class="name-application" href="#">
                <a href="selectorDeGrupos.php">
                    <img src="../imgs/CamposNFCLogo.png" alt="Logo" width="50" class="d-inline-block align-text-top">
                    I'm Here!
                </a>
            </div>
            <div class="name-window">
                <a class="nav-link active" aria-current="page">Materia</a>
            </div>
            <div class="name-teacher">
                <a class="nav-link active" aria-current="page">Nombre Maestro</a>
                <span class="material-symbols-outlined" style="font-size: 40px;">
                    account_circle
                </span>
                <form class="d-flex" role="search">
                    <a href="login.html" class="btn btn-sm btn-outline-light" type="button"
                        id="btnRegsitroManual">Cerrar sesión</a>
                </form>
            </div>
        </div>
    </nav>

    <div class="superior">
        <div class="superior-regresar">
            <a href="verMateria.php" class="btn btn-outline-light">Regresar</a>
        </div>
        <div class="superior-botones">
            <button type="button" class="btn btn-success">Importar alumnos</button>
            <a href="agregarAlumnoPopUp.php" class="btn btn-success">Agregar alumno</a>
        </div>
    </div>

    <div class="form">
        <div class="alumnos">
            <table>
                <thead>
                    <tr>
                        <th>Nombre del alumno</th>
                        <th>Número de control</th>
                        <th>Porcentaje de asistencia</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Eduardo Campos Manriquez</th>
                        <th>S21120182</th>
                        <th>100%</th>
                        <th><a href="editarAlumnoPopUp.php" class="btn btn-secondary">Editar</a></th>
                        <th><a href="eliminarAlumno.php" class="btn btn-danger">Eliminar</a></th>
                    </tr>
                    <tr>
                        <th>Josué Almanza Martínez</th>
                        <th>S21120200</th>
                        <th>50%</th>
                        <th><a href="editarAlumnoPopUp.php" class="btn btn-secondary">Editar</a></th>
                        <th><a href="eliminarAlumno.php" class="btn btn-danger">Eliminar</a></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>