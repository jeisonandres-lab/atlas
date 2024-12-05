<?php

use App\Atlas\config\App;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | ATLAS</title>
    <?php require_once App::URL_INC . "icons.php"; ?>
    <link rel="stylesheet" href="<?php echo App::URL_CSS . "registroPersonal.css"; ?>">
    <link rel="stylesheet" href="./src/libs/select2/select2.min.css">
    <link rel="stylesheet" href="./src/libs/animate/animate.min.css">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <?php require("./src/views/inc/load.php"); ?>
    <div class="app-wrapper conten-main" id="conten-main">
        <?php require_once App::URL_INC . "/menu.php"; ?>
        <!-- MODAL RESPONSIVEk -->
        <div class=" modal" tabindex="-1" id="modalimg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Datos De Trabajador</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="imgen-pron" id="img-modals">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- CUERPO DEL SISTEMA -->
        <main class=" app-main p-0 pb-4">
            <!-- NOMBRE DEL MODULO -->
            <div class="imagen-pages mb-3" style="height: 75px;">
                <div class="d-flex aling-items-center " style="position: absolute; ">
                    <span class="ms-4 fw-bold fs-4 mt-3 text-white">Registro del Personal</span>
                </div>
                <img src="<?php echo App::URL_IMG . "top-header.png"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>
            <!-- SUB MENU DEL MODULO -->
            <div class="card text-center me-3 ms-3 mb-3 contentSubMenu " style="box-shadow: none;">
                <div class="card-header ">
                    <ul class="nav nav-tabs card-header-tabs" id="list_sub_menu">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="true" id="personal" href="./personal">Personal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="true" id="familiares" href="./familiares">Familiares</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " aria-current="true" id="registrosPersonal" href="./registrosPersonal">Registros</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- FORMULARIO DE ENVIOS DE DATOS DEL PERSONAL -->
            <form action="#" class="row animate__animated animate__slideInUp contact-form form-validate d-flex justify-content-center" novalidate="novalidate" id="formulario_registro">
                <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 col-xxl-8">
                    <div class="row col-sm-12 col-md-7  h-100  bg-white content w-100 p-3">
                        <p class="mb-0 mt-2">Datos del Personal</p>
                        <hr class="mb-2">
                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label for="primerNombre">Primer Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text span_nombre"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="primerNombre" name="primerNombre" placeholder="Primer Nombre" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label for="segundoNombre">Segundo Nombre</label>
                                <div class="input-group ">
                                    <span class="input-group-text span_nombre2"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="segundoNombre" name="segundoNombre" placeholder="Segundo Nombre" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label for="primerApellido">Primer Apellido</label>
                                <div class="input-group">
                                    <span class="input-group-text span_apellido"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="primerApellido" name="primerApellido" placeholder="Primer Apellido" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label for="segundoApellido">Segundo Apellido</label>
                                <div class="input-group">
                                    <span class="input-group-text span_apellido2"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="segundoApellido" name="segundoApellido" placeholder="segundo Apellido" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label for="cedula">Cédula</label>
                                <div class="input-group">
                                    <span class="input-group-text span_cedula"><i class="fa-regular fa-address-card"></i></span>
                                    <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cédula de Identidad" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label for="civil">Estado civil</label>
                                <div class="input-group">
                                    <span class="input-group-text span_civil"><i class="fa-regular fa-clipboard"></i></span>
                                    <select class="form-select form-select-md estado-civil" id="civil" name="civil" aria-label="Small select example" aria-placeholder="dasdas" required>
                                        <option value="">Estado civil</option>
                                        <option value="soltero">Soltero</option>
                                        <option value="casado">Casado</option>
                                        <option value="Viudo">Viudo</option>
                                        <option value="Divorciado">Divorciado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-2">
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <div class="input-group">
                                    <span class="input-group-text span_correo"><i class="fa-regular fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo Electronico" required>
                                </div>
                            </div>
                        </div>

                        <p class="mb-0 mt-2">Fecha de nacimiento</p>
                        <hr class="mb-2">

                        <div class="col-sm-4 mb-2 ">
                            <div class="form-group">
                                <label class="required-field" for="message">Año</label>
                                <div class="input-group">
                                    <span class="input-group-text span_ano"><i class="fa-regular fa-calendar"></i></i></span>
                                    <select class="form-select form-select-md" name="ano" id="ano" required></select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4  mb-2">
                            <div class="form-group">
                                <label class="required-field" for="message">Mes</label>
                                <div class="input-group">
                                    <span class="input-group-text span_mes"><i class="fa-regular fa-calendar"></i></i></span>
                                    <select class="form-select" id="meses" name="meses" aria-label="Default select example" required></select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4  mb-2">
                            <div class="form-group ">
                                <label class="required-field" for="message">Día</label>
                                <div class="input-group">
                                    <span class="input-group-text span_dia"><i class="fa-regular fa-calendar"></i></i></span>
                                    <select class="form-select w-5" id="dia" name="dia" aria-label="Default select example" required></select>
                                </div>
                            </div>
                        </div>

                        <p class="mb-0 mt-2">Datos Del Trabajador</p>
                        <hr class="mb-2">

                        <div class="col-sm-12 mb-2">
                            <div class="form-group">
                                <label for="correo">Contrato</label>
                                <div class="input-group">
                                    <span class="input-group-text span_contrato"><i class="fa-regular fa-file-zipper"></i></span>
                                    <input type="file" class="form-control" id="contrato" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-2">
                            <div class="form-group">
                                <label for="correo">Notificación</label>
                                <div class="input-group">
                                    <span class="input-group-text span_notificacion"><i class="fa-regular fa-file-zipper"></i></span>
                                    <input type="file" class="form-control" id="notificacion" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-5 mb-2">
                            <label class="form-label mb-0" for="telefono">N.Telefono</label>
                            <div class="input-group">
                                <span class="input-group-text span_telefono"><i class="fa-regular fa-user"></i></span>
                                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono" required>
                            </div>
                        </div>

                        <div class="col-sm-7 mb-2">
                            <div class="form-group">
                                <label for="estatus">Estatus</label>
                                <div class="input-group">
                                    <span class="input-group-text span_estatus"><i class="fa-regular fa-clipboard"></i></span>
                                    <select class="form-select form-select-md estado-estatus" id="estatus" name="estatus" aria-label="Small select example" aria-placeholder="dasdas" required>
                                        <option value="">Selecione un estatus</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-5 mb-2">
                            <div class="form-group">
                                <label for="cargo">Cargo</label>
                                <div class="input-group">
                                    <span class="input-group-text span_cargo"><i class="fa-regular fa-clipboard"></i></span>
                                    <select class="form-select form-select-md estado-cargo" id="cargo" name="cargo" aria-label="Small select example" aria-placeholder="dasdas" required>
                                        <option value="">Selecione un cargo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-7 mb-2">
                            <div class="form-group">
                                <label for="departamento">Departamento</label>
                                <div class="input-group">
                                    <span class="input-group-text span_departamento"><i class="fa-regular fa-clipboard"></i></span>
                                    <select class="form-select form-select-md estado-departamento" id="departamento" name="departamento" aria-label="Small select example" aria-placeholder="dasdas" required>
                                        <option value="">Selecione un departamento</option>d
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-2">
                            <div class="form-group">
                                <label for="dependencia">Estado dependencia</label>
                                <div class="input-group">
                                    <span class="input-group-text span_dependencia"><i class="fa-regular fa-clipboard"></i></span>
                                    <select class="form-select form-select-md estado-dependencia" id="dependencia" name="dependencia" aria-label="Small select example" aria-placeholder="dasdas" required>
                                        <option value="">Selecione la dependencia</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-3 ">
                            <button type="submit" id="aceptar" name="submit" class="btn btn-primary" disabled>
                                <i class="fa-solid fa-plus me-2"></i>
                                Aceptar
                            </button>
                            <button type="button" id="limpiar" name="submit" class="btn btn-warning" style="color: white;">
                                <i class="fa-solid fa-rotate-right me-2"></i>Limpiar
                            </button>
                            <button type="button" id="mostrar" name="mostrar" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalimg">
                                <i class="fa-solid fa-magnifying-glass me-2"></i></i>Mostrar
                            </button>
                        </div>

                        <div class="alert alert-danger mt-2" role="alert" id="alerta" style="display: none;">
                            Esta persona ya fue registrada
                        </div>

                    </div>
                    <div style="background-color:#FE9001;" class="barra_naranja w-100"></div>
                </div>
                <div class="containerImg col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-4">
                    <div class="h-50">
                        <div class="content bg-white d-flex justify-content-center align-items-center h-100 w-100 col-sm-12 col-md-5  col-lg-4 col-xl-8 col-xxl-8 " id="img-contener">

                        </div>
                    </div>
                    <div style="background-color:#FE9001;" class="barra_naranja w-100"></div>
                </div>
            </form>
        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>
    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <script src="./src/libs/select2/select2.min.js"></script>
    <script src="<?php echo App::URL_SCRIPS . "registroPersonal.js" ?>" type="module"></script>
</body>

</html>