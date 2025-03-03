<?php

use App\Atlas\config\App;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | ATLAS</title>
    <?php require_once App::URL_INC . "total_css.php"; ?>

    <link rel="stylesheet" href="<?php echo App::URL_CSS . "registroPersonal.css"; ?>">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <?php require("./src/views/inc/load.php"); ?>
    <div class="app-wrapper conten-main" id="conten-main">
        <?php require_once App::URL_INC . "utils/menu.php"; ?>
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
        <main class="app-main p-0 pb-4">
            <!-- NOMBRE DEL MODULO -->
            <div class="imagen-pages mb-3" style="height: 75px;">
                <div class="d-flex aling-items-center " style="position: absolute; ">
                    <span class="ms-4 fw-bold fs-4 mt-3 text-white">Registro Del Personal</span>
                </div>
                <img src="<?php echo App::URL_IMG . "top-header.png"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>
            <!-- SUB MENU DEL MODULO -->
            <?php require_once App::URL_INC . "utils/menu_registro.php" ?>
            <!-- FORMULARIO DE ENVIOS DE DATOS DEL PERSONAL -->
            <form action="#" class="row contact-form form-validate d-flex " novalidate="novalidate" id="formulario_registro">
                <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 col-xxl-8">
                    <div class="row col-sm-12 col-md-7  h-100  bg-white content w-100 p-2">
                        <p class="mb-0 mt-2">Datos del Personal</p>
                        <hr class="mb-2">
                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label for="primerNombre">Primer Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text span_nombre"><i class="icons fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="primerNombre" name="primerNombre" placeholder="Primer Nombre" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label for="segundoNombre">Segundo Nombre</label>
                                <div class="input-group ">
                                    <span class="input-group-text span_nombre2"><i class="icons fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="segundoNombre" name="segundoNombre" placeholder="Segundo Nombre" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label for="primerApellido">Primer Apellido</label>
                                <div class="input-group">
                                    <span class="input-group-text span_apellido"><i class="icons fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="primerApellido" name="primerApellido" placeholder="Primer Apellido" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label for="segundoApellido">Segundo Apellido</label>
                                <div class="input-group">
                                    <span class="input-group-text span_apellido2"><i class="icons fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="segundoApellido" name="segundoApellido" placeholder="segundo Apellido" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label for="cedula">Cédula</label>
                                <div class="input-group">
                                    <span class="input-group-text span_cedula"><i class="icons fa-regular fa-address-card"></i></span>
                                    <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cédula de Identidad" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 mb-2">
                            <div class="form-group">
                                <label for="civil">Estado civil</label>
                                <div class="input-group">
                                    <span class="input-group-text span_civil"><i class="icons fa-regular fa-clipboard"></i></span>
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

                        <div class="col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="sexo">Sexo</label>
                                <div class="input-group">
                                    <span class="input-group-text span_sexo"><i class="icons fa-regular fa-clipboard"></i></span>
                                    <select class="form-select form-select-md sexo-sexo" id="sexo" name="sexo" aria-label="Small select example" aria-placeholder="dasdas"  required>
                                        <option value="">Selecione el sexo</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-sm-12 mb-2">
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <div class="input-group">
                                    <span class="input-group-text span_correo"><i class="icons fa-regular fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo Electronico" required>
                                </div>
                            </div>
                        </div> -->

                        <p class="mb-0 mt-2">Fecha de nacimiento</p>
                        <hr class="mb-2">

                        <div class="col-sm-4 mb-2 ">
                            <div class="form-group">
                                <label class="required-field" for="ano">Año</label>
                                <div class="input-group">
                                    <span class="input-group-text span_ano"><i class="icons fa-regular fa-calendar"></i></i></span>
                                    <select class="form-select form-select-md" name="ano" id="ano" required></select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4  mb-2">
                            <div class="form-group">
                                <label class="required-field" for="meses">Mes</label>
                                <div class="input-group">
                                    <span class="input-group-text span_mes"><i class="icons fa-regular fa-calendar"></i></i></span>
                                    <select class="form-select" id="meses" name="meses" aria-label="Default select example" required></select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4  mb-2" id="contentDia" >
                            <div class="form-group ">
                                <label class="required-field" for="dia">Día</label>
                                <div class="input-group">
                                    <span class="input-group-text span_dia"><i class="icons fa-regular fa-calendar"></i></i></span>
                                    <select class="form-select w-5" id="dia" name="dia" aria-label="Default select example" required></select>
                                </div>
                            </div>
                        </div>

                        <p class="mb-0 mt-2">Ubicación</p>
                        <hr class="mb-2">

                        <div class="col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <div class="input-group">
                                    <span class="input-group-text span_estado"><i class="icons fa-regular fa-clipboard"></i></span>
                                    <select class="form-select form-select-md estado-estado" id="estado" name="estado" aria-label="Small select example" aria-placeholder="dasdas"  required>
                                        <option value="">Selecione un estado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="municipio">Municipio</label>
                                <div class="input-group">
                                    <span class="input-group-text span_municipio"><i class="icons fa-regular fa-clipboard"></i></span>
                                    <select class="form-select form-select-md municipio-municipio" id="municipio" name="municipio" aria-label="Small select example" aria-placeholder="dasdas"  required>
                                        <option value="">Seleccione un municipio</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="parroquia">Parroquia</label>
                                <div class="input-group">
                                    <span class="input-group-text span_parroquia"><i class="icons fa-regular fa-clipboard"></i></span>
                                    <select class="form-select form-select-md parroquia-parroquia" id="parroquia" name="parroquia" aria-label="Small select example" aria-placeholder="dasdas"  required>
                                        <option value="">Selecione un parroquia</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="vivienda">Vivienda</label>
                                <div class="input-group">
                                    <span class="input-group-text span_vivienda"><i class="icons fa-regular fa-clipboard"></i></span>
                                    <select class="form-select form-select-md vivienda-vivienda" id="vivienda" name="vivienda" aria-label="Small select example" aria-placeholder="dasdas"  required>
                                        <option value="">Selecione un vivienda</option>
                                        <option value="Casa">Casa</option>
                                        <option value="Departamento">Departamento</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 mb-2" id="contenCalle">
                            <div class="form-group">
                                <label for="calle">Calle</label>
                                <div class="input-group">
                                    <span class="input-group-text span_calle"><i class="icons fa-regular fa-user"></i></span>
                                    <input type="text" class="form-control" id="calle" name="calle" placeholder="Nombre de la Calle" required>
                                </div>
                            </div>
                        </div>


                        <p class="mb-0 mt-2">Datos Del Trabajador</p>
                        <hr class="mb-2">

                        <div class="col-sm-12 mb-2">
                            <div class="form-group">
                                <label for="contrato">Contrato</label>
                                <div class="input-group">
                                    <span class="input-group-text span_contrato"><i class="icons fa-regular fa-file-zipper"></i></span>
                                    <input type="file" class="form-control" name="contratoArchivo" id="contrato" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-2">
                            <div class="form-group">
                                <label for="notificacion">Notificación</label>
                                <div class="input-group">
                                    <span class="input-group-text span_notificacion"><i class="icons fa-regular fa-file-zipper"></i></span>
                                    <input type="file" name="notacionAchivo" class="form-control" id="notificacion" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-2">
                            <label class="form-label mb-0" for="telefono">N.Telefono</label>
                            <div class="input-group">
                                <span class="input-group-text span_telefono"><i class="icons fa-regular fa-mobile-notch"></i></span>
                                <div class="col-sm-4">
                                    <select class="form-select" name="linea" id="linea" style="border-radius: 0px;">
                                        <option value="0412">0412</option>
                                        <option value="0416">0416</option>
                                        <option value="0424">0424</option>
                                        <option value="0426">0426</option>
                                    </select>
                                </div>

                                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono" required>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-2">
                            <div class="form-group">
                                <label for="estatus">Estatus</label>
                                <div class="input-group">
                                    <span class="input-group-text span_estatus"><i class="icons fa-regular fa-clipboard"></i></span>
                                    <select class="form-select form-select-md estado-estatus" id="estatus" name="estatus" aria-label="Small select example" aria-placeholder="dasdas" style="border-radius: 5px" required>
                                        <option value="">Selecione un estatus</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-5 mb-2">
                            <div class="form-group">
                                <label for="cargo">Cargo</label>
                                <div class="input-group">
                                    <span class="input-group-text span_cargo"><i class="icons fa-duotone fa-regular fa-arrows-down-to-people"></i></span>
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
                                    <span class="input-group-text span_departamento"><i class="icons fa-regular fa-building-user"></i></span>
                                    <select class="form-select form-select-md estado-departamento" id="departamento" name="departamento" aria-label="Small select example" aria-placeholder="dasdas" required>
                                        <option value="">Selecione un departamento</option>d
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-2">
                            <div class="form-group">
                                <label for="dependencia">Dependencia</label>
                                <div class="input-group">
                                    <span class="input-group-text span_dependencia"><i class="icons fa-regular fa-building-memo"></i></span>
                                    <select class="form-select form-select-md estado-dependencia " id="dependencia" name="dependencia" aria-label="Small select example" aria-placeholder="dasdas" required>
                                        <option value="">Selecione la dependencia</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-2">
                            <div class="form-group">
                                <label for="academico">Nivel Academico</label>
                                <div class="input-group">
                                    <span class="input-group-text span_academico"><i class="icons fa-regular fa-user-graduate"></i></span>
                                    <select class="form-select form-select-md" id="academico" name="nivelAcademico">
                                        <option value="">Nivel Academico</option>
                                        <option value="bachiller">Bachiller</option>
                                        <option value="tecnico">Técnico</option>
                                        <option value="tecnologo">Tecnólogo</option>
                                        <option value="pregrado">Pregrado</option>
                                        <option value="ingeniero">Ingeniero</option>
                                        <option value="especialista">Especialista</option>
                                        <option value="maestria">Maestría</option>
                                        <option value="doctorado">Doctorado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-3 ">
                            <button type="submit" id="aceptar" name="submit" class="btn btn-success" disabled>
                                <i class="fa-solid fa-plus me-2"></i>
                                Aceptar
                            </button>
                            <button type="button" id="limpiar" name="submit" class="btn btn-warning" style="color: white;">
                                <i class="fa-solid fa-rotate-right me-2"></i>Limpiar
                            </button>
                            <button type="button" id="mostrar" name="mostrar" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#modalimg">
                                <i class="fa-solid fa-magnifying-glass me-2"></i></i>Mostrar
                            </button>
                        </div>

                        <div class="alert alert-danger mt-2" role="alert" id="alerta" style="display: none;">
                            Esta persona ya fue registrada
                        </div>

                    </div>
                    <div style="background-color:#FE9001;" class="barra_naranja w-100"></div>
                </div>
                <div class="container col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-4">
                    <div class="w-100 bg-white containerImg col-12 mb-3" style="height: 400px;">
                        <div class="content d-flex justify-content-center align-items-center h-100 w-100" id="img-contener">
                            <!-- Contenido aquí -->
                        </div>
                        <div style="background-color:#FE9001;" class="barra_naranja w-100" id="barra"></div>
                    </div>
                </div>

                <!-- para activar el modal colocar al boton esto: data-bs-toggle="modal" data-bs-target="#estadosInfor" -->
                <!-- Modal para editar-->
                <div class="modal  fade modal-lg" id="estadosInfor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-between bg-primary" style=" color: #fff;">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Datos</h1>
                                <i type="button" data-bs-dismiss="modal" aria-label="Close" class="close fa-solid fa-xmark"></i>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid px-4">
                                    <div class="container-fluid card p-2" style="background-color: #f5f5f5; box-shadow: none;">
                                        <section class="card p-2" style="background-color: white; box-shadow: none;">

                                        </section>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                    <i class="fa-solid fa-arrow-right me-2"></i>Cerrar
                                </button>
                            </div>
                            <div style="background-color:#FE9001;" class="barra_naranja"></div>
                        </div>
                    </div>
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