<?php

use App\Atlas\config\App; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Inicia sesión en tu cuenta para acceder a todas las funcionalidades de ATLAS, nuestro sistema de gestión de recursos humanos">
    <title>Inicio de Sesión | ATLAS</title>
    <?php require_once App::URL_INC . "total_css.php"; ?>
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "login.css"; ?>">
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "Utils/botones.css"; ?>">

</head>

<body>
    <?php require_once App::URL_INC . "load.php"; ?>

    <main class="principal container-fluid ">
        <div class="h-100 d-flex justify-content-center align-items-center">
            <div class="col-md-3 col-sm-8 user_card">
                <div class="mt-5 mb-3">
                    <div class="d-flex justify-content-center">
                        <div class="brand_logo_container">
                            <div class=" brand_logo d-flex align-items-center justify-content-center ">
                                <img src="<?php echo App::URL_ICONS . 'logo_atlas.png'; ?>" class="brand_logo_img" alt="Logo">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center flex-column mt-5">
                        <form class="formularioEnviar" method="POST" action="./src/ajax/userAjax.php">
                            <div class="inicioSesion container-fluid d-flex justify-content-center mt-2 ">
                                <h4 class=" text-muted">INICIO DE SESION</h4>
                            </div>
                            <div class="mb-3 mt-3">
                                <div class="input-group mb-3 ">
                                    <span class="input-group-text d-flex"><i class="fas fa-user"></i></span>
                                    <input type="text" name="usuario" id="usuario" class="form-control input_user px-3" value="" placeholder="Usuario" autocomplete="username">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text d-flex candado" id="candado"><i class="password fa-solid fa-lock "></i></span>
                                    <input type="password" name="password" id="password" class="form-control input_pass px-3" value="" placeholder="Contraseña" autocomplete="current-password">
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-3 mb-2 login_container">
                                <button type="submit" name="button" class="btn btn-primary login_btn btn-hover-azul">Iniciar </button>
                            </div>

                        </form>
                        <!-- ALERTAS CON BOOTSTRAP -->
                        <div class="" id="alert"></div>
                    </div>
                    <div class="mt-4">
                        <div class="d-flex justify-content-center links">
                            ¿Olvidaste Los Datos De Tu Cuenta?
                        </div>
                        <div class="d-flex justify-content-center links">
                            <a href="recuperarDatos"><i class="fa-solid fa-arrow-right me-2"></i>Recuperar Datos</a>
                        </div>
                    </div>
                </div>
                <div class="barraNaranja">s</div>
            </div>
        </div>
    </main>

    <div id="particles-js"></div>

    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <script src="<?php echo App::URL_NODE . "particles.js/particles.js"; ?>"></script>
    <script src="<?php echo App::URL_NODE . "crypto-js/crypto-js.js"; ?>"></script>
    <script src="<?php echo App::URL_SCRIPS . "utils/particulasLogin.js" ?>"></script>
    <script src="<?php echo App::URL_SCRIPS . "login.js" ?>" type="module"></script>

</body>

</html>