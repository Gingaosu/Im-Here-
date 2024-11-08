<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I'm Here!</title>
    <link rel="stylesheet" href="css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <div id="banner">
        <nav class="navbar navbar-expand-lg navbar-sm" style="height: 69px;">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="imgs/CamposNFCLogo.png" alt="Logo" width="50" class="d-inline-block align-text-top">
                </a>
                <div class="nameL">
                    I'm Here!
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#Conocenos">Conócenos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#Caracteristicas">Características</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#Precios">Precios</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <a href="html/login.php" class="btn btn-sm btn-outline-light">Iniciar Sesión</a>
                    </form>
                </div>
            </div>
        </nav>
        <div id="centro">
            <div class="typewriter">
                <h1 class="line-1 anim-typewriter">I'm Here!</h1>
            </div>
            <div id="h3">
                <h3>Pasar lista nunca fue tan fácil</h3>
            </div>
        </div>
    </div>
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4" id="Conocenos">¿Quiénes somos?</h1>
        <p class="lead" style="margin-left: 25%; margin-right: 25%;">
            Somos un equipo de ingenieros apasionados que, inspirados por la innovación, hemos desarrollado
            una aplicación web revolucionaria. Esta plataforma moderna y eficiente utiliza la tecnología NFC para
            simplificar el proceso de toma de asistencia. Estamos comprometidos en brindar una solución intuitiva y
            avanzada que transforme por completo la forma en que se realiza el pase de lista. Nuestro objetivo es
            eliminar la complejidad y las molestias asociadas con este procedimiento, permitiendo a profesores,
            organizadores de eventos y administradores gestionar la asistencia de manera rápida, precisa y sin
            complicaciones. Con nuestra aplicación, aspiramos a llevar la toma de asistencia al siguiente nivel,
            proporcionando una experiencia fluida y eficaz para todos los usuarios.</p>
    </div>
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4" id="Caracteristicas">Características</h1>
        <p class="lead">Ofreciendo la mejor calidad para nuestros usuarios.</p>
    </div>
    <div class="album py-5 bg-light" style="padding: 0 24px 0 24px !important;">
        <div class="container" style="margin-bottom: 48px;">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" src="imgs/fondo1.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h3>Rápido y sencillo</h3>
                            <p class="card-text">Acerca tu tarjeta al sensor, nosotros hacemos el resto.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" src="imgs/fondo2.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h3>Preciso y confiable</h3>
                            <p class="card-text">Elimina el riesgo de errores humanos o falsificaciones.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" src="imgs/fondo3.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h3>Flexible y adaptable</h3>
                            <p class="card-text">Se puede usar en oficinas, aulas, eventos y más.</p>
                        </div>
                    </div>
                </div>

                <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                    <h1 class="display-4" id="Precios">Precios</h1>
                    <p class="lead">Explora nuestras ofertas y selecciona la que mejor se adapte a tus necesidades.
                    </p>
                </div>

                <div class="container">
                    <div class="card-deck row" style="width: 100%; gap: 10px; justify-content: center;">
                        <div class="col-md-3 card mb-4 box-shadow">
                            <div class="card-header">
                                <h4 class="my-0 font-weight-normal">Gratuita</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">$0 <small class="text-muted">/ mes</small>
                                </h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>No cuenta con tarjetas NFC</li>
                                    <li>No cuenta con sensores NFC</li>
                                    <li>Soporte 24/7</li>
                                    <li>Acceso al centro de ayuda</li>
                                </ul>
                                <button type="button" class="btn btn-lg btn-block btn-outline-primary">Inicia
                                    gratis</button>
                            </div>
                        </div>
                        <div class="col-md-3 card mb-4 box-shadow">
                            <div class="card-header">
                                <h4 class="my-0 font-weight-normal">Pro</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">$500 <small class="text-muted">/
                                        mes</small></h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>Usuarios ilimitados</li>
                                    <li>Hasta 20 sensores NFC</li>
                                    <li>Hasta 2000 tarjetas NFC</li>
                                    <li>Soporte 24/7</li>
                                </ul>
                                <button type="button" class="btn btn-lg btn-block btn-primary">Contáctanos</button>
                            </div>
                        </div>
                        <div class="col-md-3 card mb-4 box-shadow">
                            <div class="card-header">
                                <h4 class="my-0 font-weight-normal">Deluxe</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">$1000 <small class="text-muted">/
                                        mes</small></h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>Usuarios ilimitados</li>
                                    <li>Hasta 50 sensores NFC</li>
                                    <li>Hasta 20000 tarjetas NFC</li>
                                    <li>Soporte 24/7</li>
                                </ul>
                                <button type="button" class="btn btn-lg btn-block btn-primary">Contáctanos</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="container">
        <p class="float-end"><a href="#">Regresar al inicio.</a></p>
        <p class="float-start">© 2023–2024 I'm Here! · <a href="#">Privacidad.</a> ·
            <a href="#">Términos y condiciones.</a>
        </p>
    </footer>
</body>

</html>