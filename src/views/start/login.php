<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Inicia sesión en tu cuenta para acceder a todas las funcionalidades de ATLAS, nuestro sistema de gestión de recursos humanos">
    <title>Inicio de Sesión | ATLAS</title>
    <link rel="icon" href="./src/assets/img/icons/dasdad-transformed-removebg.png" type="image/x-icon">
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/@fortawesome/fontawesome-free/css/fontawesome.min.css">
    <link rel="stylesheet" href="./node_modules/@fortawesome/fontawesome-free/css/regular.min.css">
    <link rel="stylesheet" href="./node_modules/@fortawesome/fontawesome-free/css/solid.min.css">
    <link rel="stylesheet" href="./node_modules/@fortawesome/fontawesome-free/css/brands.min.css">
    <link rel="stylesheet" href="./node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="./src/assets/css/login.css">

</head>

<body>
    <div class="loading justify-content-center align-items-center  flex-column" id="cargando" style="
    position:
    absolute;
    z-index: 10000;
    top: 0;
    background: white;
    height: 100%;
    width: 100%;
    display: none
    ">
        <div class="container1">
            <div class="cargando1">
                <div class="pelotas"></div>
                <div class="pelotas"></div>
                <div class="pelotas"></div>
                <span class="texto-cargando">Cargando...</span>
            </div>
        </div>
    </div>
    <?php use App\Atlas\config\App; ?>
    <main class="principal container-fluid ">
        <div class="h-100 d-flex justify-content-center align-items-center">
            <div class="col-md-4 col-sm-8 user_card">
                <div class="mt-5 mb-3">
                    <div class="d-flex justify-content-center">
                        <div class="brand_logo_container">
                            <div class=" brand_logo d-flex align-items-center justify-content-center ">
                                <img src="./src/assets/img/icons/dasdad-transformed-removebg.png" class="brand_logo_img" alt="Logo">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <form class="formularioEnviar" method="POST" action="<?php echo App::APP_URL; ?>src/ajax/userAjax.php">
                            <div class="inicioSesion container-fluid d-flex justify-content-center mt-2 ">
                                <h4 class=" text-muted">INICIO DE SESION</h4>
                            </div>
                            <input type="text" name="modulo_usuario" id="" value="login" hidden>
                            <div class="mb-3 mt-3">
                                <div class="input-group mb-3 ">
                                    <span class="input-group-text" style="height: 40px; width: 40px;"><i class="user fas fa-user"></i></span>
                                    <input type="text" name="usuario" id="usuario" class="form-control input_user px-3" value="" placeholder="Usuario">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text" id="candado" style="height: 40px; width: 40px;"><i class="password fa-solid fa-lock "></i></span>
                                    <input type="password" name="password" id="password" class="form-control input_pass px-3" value="" placeholder="Contraseña">
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-3 mb-2 login_container">
                                <button type="submit" name="button" class="btn btn-primary login_btn">Iniciar </button>
                            </div>
                        </form>
                    </div>
                    <div class="mt-4">
                        <div class="d-flex justify-content-center links">
                            ¿Olvidaste Los Datos De Tu Cuenta?
                        </div>
                        <div class="d-flex justify-content-center links">
                            <a href="#">Recuperar Datos</a>
                        </div>
                    </div>
                </div>
                <div class="barraNaranja">s</div>
            </div>
        </div>
    </main>

    <div id="particles-js"></div>
    <script src="./node_modules/jquery/dist/jquery.min.js"></script>
    <script src="./node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="./node_modules/particles.js/particles.js"></script>
    <script src="./node_modules/crypto-js/crypto-js.js"></script>
    <script src="./src/assets/js/particulasLogin.js"></script>
    <script src="./src/assets/js/login.js" type="module"></script>
</body>

</html>