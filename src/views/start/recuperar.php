<?php

use App\Atlas\config\App; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Inicia sesión en tu cuenta para acceder a todas las funcionalidades de ATLAS, nuestro sistema de gestión de recursos humanos">
    <title>Recuperar Datos | ATLAS</title>
    <link rel="icon" href="./src/assets/img/icons/dasdad-transformed-removebg.png" type="image/x-icon">
    <?php require_once App::URL_INC . "total_css.php"; ?>
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "login.css"; ?>">
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "cssUtils/buttons.css"; ?>">

</head>

<body>
    <?php require("./src/views/inc/load.php"); ?>

    <main class="principal container-fluid ">
        <div class="h-100 d-flex justify-content-center align-items-center">
            <div class="col-sm-12 col-md-4 col-xl-4 user_card">
                <div class="mt-5 mb-3">
                    <div class="d-flex justify-content-center">
                        <div class="brand_logo_container">
                            <div class=" brand_logo d-flex align-items-center justify-content-center ">
                                <img src="./src/assets/img/icons/dasdad-transformed-removebg.png" class="brand_logo_img" alt="Logo">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center flex-column mt-5">
                        <form class="formularioEnviar" style="width: 80%;" method="POST" action="./src/ajax/userAjax.php">
                            <div class="inicioSesion container-fluid d-flex justify-content-center mt-2 ">
                                <h4 class=" text-muted">RECUPERAR DATOS</h4>
                            </div>
                            <div class="" id="alert2"></div>
                            <div class="mb-3 mt-3 contenidoFormulario">
                                <div class="input-group mb-3 " id="contenCedula">
                                    <span class="input-group-text"><i class="user fas fa-user"></i></span>
                                    <input type="number" name="cedula" id="cedula" class="form-control input_user px-3 brflechas" value="" placeholder="Cedula del Empleado">
                                </div>
                                <div class="input-group mb-3 " id="contenSelect" hidden>
                                    <span class="input-group-text" style="height: 40px; width: 40px;"><i class="fa-solid fa-user-pen"></i></span>
                                    <select class="form-select form-select-md " id="datosRecuperar">
                                        <option value="">Seleccione un opción</option>
                                        <option value="rpUser">Recuperar Usuario</option>
                                        <option value="rpPassword">Recuperar Contraseña</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-3 mb-2 login_container">
                                <button type="button" id="button" class="btn btn-primary login_btn btn-hover-azul"><i class="fa-solid fa-check me-2"></i>Aceptar</button>
                                <button hidden type="submit" name="button" class="btn btn-primary login_btn w-auto btn-hover-azul"><i class="fa-solid fa-thumbs-up fa-sm me-2"></i>Iniciar</button>
                            </div>

                        </form>
                        <!-- ALERTAS CON BOOTSTRAP -->
                        <div class="" id="alert"></div>
                    </div>
                    <div class="mt-4">
                        <div class="d-flex justify-content-center links">
                            ¿Quieres Regresar al login?
                        </div>
                        <div class="d-flex justify-content-center links">
                            <a href="Identificarse"><i class="fa-solid fa-arrow-left me-2"></i>Regresar</a>
                        </div>
                    </div>
                </div>
                <div class="barraNaranja">s</div>
            </div>
        </div>
    </main>


    <div id="particles-js"></div>

    <!-- Modal para editar el usuario-->
    <div class="modal fade" id="modalUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" class="formularioVerificar" id="formualrioVerificar">
                    <div class="modal-body modalBodyUsuario">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm btn-hover-gris" data-bs-dismiss="modal"> <i class="fa-regular fa-xmark-large fa-sm me-2"></i>Cerrar</button>
                        <button type="button" class="btn btn-primary btn-sm btn-hover-azul usarPin"><i class="password fa-solid fa-key me-2"></i>Usar PIN</button>
                        <button type="button" class="btn btn-primary btn-sm btn-hover-azul usarPass"><i class="password fa-solid fa-key me-2"></i>Usar Contraseña</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-hover-azul actualizarDatos"><i class="fa-solid fa-thumbs-up fa-sm me-2"></i>Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de preguntas-->
    <div class="modal fade" id="modalUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" class="formularioPreguntas" id="formualrioPreguntas">
                    <div class="modal-body modalbodyPreguntas">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm btn-hover-gris" data-bs-dismiss="modal"> <i class="fa-regular fa-xmark-large fa-sm me-2"></i>Cerrar</button>
                        <button type="button" class="btn btn-primary btn-sm btn-hover-azul actualizarPR"><i class="fa-solid fa-thumbs-up fa-sm me-2"></i>Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <script src="./node_modules/particles.js/particles.js"></script>
    <script src="./node_modules/crypto-js/crypto-js.js"></script>
    <script src="./src/libs/select2/select2.min.js"></script>
    <script src="<?php echo App::URL_SCRIPS . "ajax/particulasLogin.js" ?>"></script>
    <script src="<?php echo App::URL_SCRIPS . "recuperarDatos.js" ?>" type="module"></script>

    <!-- <script src="./src/assets/js/login.js" type="module"></script> -->
</body>

</html>