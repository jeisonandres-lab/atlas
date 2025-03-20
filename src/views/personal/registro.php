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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <?php require("./src/views/inc/load.php"); ?>
    <div class="app-wrapper conten-main" id="conten-main">
        <?php require_once App::URL_INC . "utils/menu.php"; ?>
        <main class="app-main p-0 pb-4">
            <div class="imagen-pages mb-3" style="height: 75px;">
                <div class="d-flex aling-items-center " style="position: absolute; ">
                    <span class="ms-4 fw-bold fs-4 mt-3 text-white">Registro Del Personal</span>
                </div>
                <img src="<?php echo App::URL_IMG . "top-header.png"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>
            <?php require_once App::URL_INC . "utils/menu_registro.php" ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-8 px-0 form-validate content" style="text-align: center;">
                        <form role="form" action="" method="post" class="f1 pt-5 px-4 formValidar" id="formulario_registro" style="color: #888;">
                            <h3>Registrar Empleado</h3>
                            <div class="f1-steps pasos">
                                <div class="f1-progress">
                                    <div class="f1-progress-line" data-now-value="16.66" data-number-of-steps="3" style="width: 16.66%;"></div>
                                </div>
                                <div class="f1-step active">
                                    <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                                    <p>Paso 1</p>
                                </div>
                                <div class="f1-step">
                                    <div class="f1-step-icon"><i class="fa-regular fa-location-dot"></i></div>
                                    <p>Paso 2</p>
                                </div>
                                <div class="f1-step">
                                    <div class="f1-step-icon"><i class="fa-regular fa-user-graduate"></i></div>
                                    <p>Fin</p>
                                </div>
                            </div>

                            <div class="alert p-0 m-0" id="alert">

                            </div>
                            <!--paso 1 -->
                            <fieldset>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                    <div class="row col-sm-12 col-md-7  h-100  w-100 p-2">
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
                                                    <span class="input-group-text span_civil"><i class="icons fa-regular fa-handshake"></i></span>
                                                    <select class="form-select form-select-md estado-civil" id="civil" name="civil" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 mb-2">
                                            <div class="form-group">
                                                <label for="sexo">Sexo</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_sexo"><i class="icons fa-regular fa-person-half-dress"></i></span>
                                                    <select class="form-select form-select-md sexo-sexo" id="sexo" name="sexo" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6 mb-0">
                                            <div class="form-group">
                                                <label for="edad">Edad</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_edad"><i class="icons fa-regular fa-user-clock"></i></span>
                                                    <input type="text" class="form-control" id="edad" name="edad" placeholder="Edad del personal" required readonly>
                                                </div>
                                                <p class="parrafo fs-6 fw-light mb-0">La edad se autocompleta con la fecha de nacimiento</p>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6 mb-2">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary btn-sm btn-hover-azul">
                                                    <i class="fa-solid fa-plus me-2"></i>
                                                    Asignar Discapacidad
                                                </button>
                                            </div>
                                        </div>

                                        <p class="mb-0 mt-2">Fecha de nacimiento</p>
                                        <hr class="mb-2">

                                        <div class="col-sm-4 mb-2 ">
                                            <div class="form-group">
                                                <label class="required-field" for="ano">Año</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_ano"><i class="icons fa-regular fa-calendars"></i></span>
                                                    <select class="form-select form-select-md" name="ano" id="ano" required></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4  mb-2">
                                            <div class="form-group">
                                                <label class="required-field" for="meses">Mes</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_mes"><i class="icons fa-regular fa-calendars"></i></span>
                                                    <select class="form-select" id="meses" name="meses" aria-label="Default select example" required></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4  mb-2" id="contentDia">
                                            <div class="form-group ">
                                                <label class="required-field" for="dia">Día</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_dia"><i class="icons fa-regular fa-calendars"></i></span>
                                                    <select class="form-select w-5" id="dia" name="dia" aria-label="Default select example" required><option value="">Seleccione un dia</option></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="f1-buttons">
                                    <button type="button" class="btn btn-next">Siguiente</button>
                                </div>
                            </fieldset>
                            <!--fin del paso 1 -->

                            <!---paso 2 -->
                            <fieldset>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                    <div class="row col-sm-12 col-md-7  h-100   w-100 p-2">
                                        <p class="mb-0 mt-2">Ubicación</p>
                                        <hr class="mb-2">

                                        <div class="col-sm-6 mb-2">
                                            <div class="form-group">
                                                <label for="estado">Estado</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_estado"><i class="icons fa-regular fa-location-dot"></i></span>
                                                    <select class="form-select form-select-md estado-estado" id="estado" name="estado" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                        <option value="">Selecione un estado</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 mb-2">
                                            <div class="form-group">
                                                <label for="municipio">Municipio</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_municipio"><i class="icons fa-regular fa-location-dot"></i></span>
                                                    <select class="form-select form-select-md municipio-municipio" id="municipio" name="municipio" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                        <option value="">Seleccione un municipio</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 mb-2">
                                            <div class="form-group">
                                                <label for="parroquia">Parroquia</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_parroquia"><i class="icons fa-regular fa-location-dot"></i></span>
                                                    <select class="form-select form-select-md parroquia-parroquia" id="parroquia" name="parroquia" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                        <option value="">Selecione un parroquia</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 mb-2">
                                            <div class="form-group">
                                                <label for="vivienda">Vivienda</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_vivienda"><i class="icons fa-regular fa-house-building"></i></span>
                                                    <select class="form-select form-select-md vivienda-vivienda" id="vivienda" name="vivienda" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6 mb-2" id="contenCalle">
                                            <div class="form-group">
                                                <label for="calle">Calle</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_calle"><i class="icons fa-regular fa-road"></i></span>
                                                    <input type="text" class="form-control" id="calle" name="calle" placeholder="Nombre de la Calle" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="f1-buttons">
                                            <button type="button" class="btn btn-previous">Atrás</button>
                                            <button type="button" class="btn btn-next">Siguiente</button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <!--fin del paso 2 -->

                            <!--paso fin -->
                            <fieldset>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                    <div class="row col-sm-12 col-md-7  h-100   w-100 p-2">
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

                                        <div class="col-sm-6 col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="fechaing">Fecha Ingreso</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_fechaing"><i class="icons fa-regular fa-user-tie"></i></span>
                                                    <input type="text" class="form-control" id="fechaing3" name="fechaing2" placeholder="Fecha de Ingreso" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 mb-2">
                                            <label class="form-label mb-0" for="telefono">N.Telefono</label>
                                            <div class="input-group">
                                                <span class="input-group-text span_telefono"><i class="icons fa-regular fa-mobile-notch"></i></span>
                                                <div class="col-sm-4">
                                                    <select class="form-select" name="linea" id="linea" style="border-radius: 0px; height: 39px;">
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

                                        <div class="col-sm-6 mb-2">
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

                                        <div class="col-sm-12 mb-2">
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
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="f1-buttons">
                                    <button type="button" class="btn btn-previous">Atrás</button>
                                    <button type="submit" class="btn btn-submit " id="aceptar">Guardar Información</button>
                                </div>
                            </fieldset>
                            <!--fin -->

                        </form>
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

                </div>


            </div>
        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>
    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <script src="./src/libs/select2/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script src="<?php echo App::URL_SCRIPS . "registro.js" ?>" type="module"></script>
    <script src="<?php echo App::URL_SCRIPS . "registroPersonal.js" ?>" type="module"></script>


</body>

</html>