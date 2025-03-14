<?php

use App\Atlas\config\App;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATLAS | Registros</title>
    <?php require_once App::URL_INC . "total_css.php"; ?>
    <?php require_once App::URL_INC . "tablets_css.php"; ?>

    <link rel="stylesheet" href="./src/libs/jQueryUI/jquery-ui.min.css">
    <link rel="stylesheet" href="./src/libs/jQueryUI/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="./src/libs/jQueryUI/jquery-ui.theme.min.css">

    <link rel="stylesheet" href="<?php echo App::URL_CSS . "registroFamiliares.css"; ?>">

</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <?php require("./src/views/inc/load.php"); ?>
    <div class="app-wrapper conten-main" id="conten-main">
        <?php require_once App::URL_INC . "utils/menu.php"; ?>
        <!-- MODAL RESPONSIVE -->
        <!-- CUERPO DEL SISTEMA -->
        <main class=" app-main p-0 pb-4">
            <!-- NOMBRE DEL MODULO -->
            <div class="imagen-pages mb-3" style="height: 75px;">
                <div class="d-flex aling-items-center " style="position: absolute; ">
                    <span class="ms-4 fw-bold fs-4 mt-3 text-white">Registros Del Personal Y Familiares</span>
                </div>
                <img src="<?php echo App::URL_IMG . "top-header.png"; ?>" alt="" class="w-100 h-100" style="object-fit: cover; object-position:center;">
            </div>
            <!-- SUB MENU DEL MODULO -->
            <?php require_once App::URL_INC . "utils/menu_registro.php" ?>
            <div class="container-fluid px-3">
                <div class="card text-center" id="cardID1" style="background-color: white; box-shadow: 0px 6px 16px 2px rgba(0, 0, 0, 0.05) !important;">
                    <div class="card-header py-3">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item me-3">
                                <a class="d-flex justify-content-center align-items-baseline icon-link reporteTrabajador " id="reporteTrabajador" href="pdf">
                                    <i class="bi bi-file-pdf"></i>Reportes PDF
                                </a>

                            </li>
                            <li class="nav-item me-3">
                                <a class="d-flex justify-content-center align-items-baseline icon-link reporteTrabajador " id="reporteTrabajador" href="excel">
                                    <i class="bi bi-file-earmark-spreadsheet"></i>Reportes EXCEL
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <section class="card contenTable" style="background-color: white; box-shadow: none;">
                            <div class="contenTablet mitable table-responsive">
                                <!-- Boton Switch -->

                                <table id="tableInic" class="mitable table-bordered table table-hover nowrap display">
                                    <thead>
                                        <tr id="tr-identity" class="tr-identity">
                                            <th scope="col" class="bg-primary" style="font-size: 14px;">Empleado</th>
                                            <th scope="col" class="bg-primary" style="font-size: 14px;">Familiar</th>
                                            <th scope="col" class="text-center bg-primary" style="font-size: 14px;">Cédula</th>
                                            <th scope="col" class="text-center bg-primary" style="font-size: 14px;">Sexualidad</th>
                                            <th scope="col" class="text-center bg-primary" style="font-size: 14px;">Carnet</th>
                                            <th scope="col" class="text-center bg-primary" style="font-size: 14px;">Discapacidad</th>
                                            <th scope="col" class="text-center bg-primary" style="font-size: 14px;">Edad</th>
                                            <th scope="col" class="text-center bg-primary" style="font-size: 14px;">Tomo</th>
                                            <th scope="col" class="text-center bg-primary" style="font-size: 14px;">Folio</th>
                                            <th scope="col" class="text-center bg-primary" style="font-size: 14px;">Acciones</th>
                                            <th scope="col" class="text-center bg-primary" style="font-size: 14px;">Documentación</th>
                                        </tr>
                                    </thead>
                                    <tbody class="contenidoTable" style="font-size: 14px;">
                                    </tbody>
                                </table>
                            </div>
                            <div style="background-color:#FE9001;" class="barra_naranja"></div>
                        </section>
                    </div>
                </div>

                <!-- GENERAR REPORTES DE EMPELADOS PDF -->
                <div class="card mt-2" hidden id="datosReporte" style="background-color: white; box-shadow: 0px 6px 16px 2px rgba(0, 0, 0, 0.05) !important;">
                    <div class="card-header" id="cabeza-reporte" style="background-color: #1929bb !important;">
                        Generar reportes PDF
                    </div>
                    <form action="#" class="contact-form  form-validate formulario-descargarpdf formdata " id="formulario-descargarpdf">
                        <div class="card-body" id="contentBodyCard2">

                        </div>
                        <div class="card-footer">
                            <div class="col-sm-12  d-flex justify-content-between " id="buttonBody">
                                <button type="button" id="cerrarReport" class="btn-sm btn btn-secondary btn-hover-gris">
                                    <i class="fa-regular fa-xmark-large fa-sm me-2"></i> Cerrar
                                </button>

                                <button type="submit" id="descargarReporte2" name="submit" class="btn-sm btn btn-danger btn-hover-rojo">
                                    <i class="fa-regular fa-file-pdf fa-sm me-2"></i>Descargar PDF
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- card para editar -->
                <div class="card mt-2" id="editarDatos" hidden style="background-color: white; box-shadow: 0px 6px 16px 2px rgba(0, 0, 0, 0.05) !important;">
                    <div class="card-header text-white p-3" style="background-color: #1929bb !important;">
                        <h5 class=" text-white m-0">Editar Datos de familiar</h5>
                    </div>

                    <form action="#" class="contact-form form-validate formulario-familia" id="formularioActualizar">
                        <div class="card-body p-0" style="font-size: 14px;">
                            <div class="container-fluid px-4">
                                <!-- <form action="#" class="row contact-form form-validate d-flex justify-content-center formulario-familia" novalidate="novalidate" id="forActualizarFamiliar"> -->
                                <div class=" col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 ">
                                    <div class="row col-sm-12 col-md-9 h-100 bg-white w-100 p-2 m-0 content">
                                        <p class="mb-0 mt-2">Datos del Empleado</p>
                                        <hr class="mb-3">
                                        <input type="text" class="form-control cumplido" id="idEmpleadoFamiliar" name="id" placeholder="Primer Nombre" required hidden>
                                        <div class="col-sm-4 mb-2">
                                            <label class="form-label mb-0" for="cedula_trabajador">Cédula</label>
                                            <div class="input-group">
                                                <span class="input-group-text span_cedula_empleado "><i class="icons fa-regular fa-address-card"></i></span>
                                                <input type="text" class="form-control " id="cedula_trabajador_familiar" name="cedulaEmpleado" placeholder="Cédula">
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-4 mb-2">
                                            <div class="form-group">
                                                <label for="nombre">Nombre</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_nombre"><i class="icons fa-regular fa-user"></i></span>
                                                    <input type="text" class="form-control" id="nombreEmpleado" name="nombre" placeholder="Primer Nombre" required readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-4 mb-2">
                                            <div class="form-group">
                                                <label for="apellido">apellido</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_apellido"><i class="icons fa-regular fa-user"></i></span>
                                                    <input type="text" class="form-control" id="apellidoEmpleado" name="apellido" placeholder="Primer Nombre" required readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <p class="mb-0 mt-2">Datos Del Familiar</p>
                                        <hr class="mb-3">
                                        <div class=" d-flex justify-content-center">
                                            <!-- CHECK NO CEDULADO -->
                                            <div class="checkbox-wrapper-12 d-flex me-3">
                                                <div class="cbx ">
                                                    <input id="noCedula" class="cumplidoNormal" type="checkbox" />
                                                    <label for="noCedula"></label>
                                                    <i class="icons fa-solid fa-check fa-xs"></i>
                                                </div>
                                                <p>No Cédulado</p>
                                            </div>

                                            <!-- CHECK DE DISCAPACIDAD -->
                                            <div class="checkbox-wrapper-12 d-flex">
                                                <div class="cbx ">
                                                    <input id="disca" class="cumplidoNormal" type="checkbox" />
                                                    <label for="disca"></label>
                                                    <i class="icons fa-solid fa-check fa-xs"></i>
                                                </div>
                                                <p>Discapacidad</p>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-12 mb-2">
                                            <button type="button" id="cargaPartiNacimiento" class="btn btn-primary btn-xs btn-hover-azul"><i class="fa-solid fa-plus me-2"></i>Partida De Nacimiento</button>
                                            <button type="button" id="cargaDiscapacidad" class="btn btn-primary btn-xs btn-hover-azul"><i class="fa-solid fa-plus me-2"></i>Documento De Discapacidad</button>
                                        </div>

                                        <div class="col-sm-6 col-md-3 mb-3">
                                            <div class="form-group">
                                                <label for="primerNombre">Primer Nombre</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_nombre1"><i class="icons fa-regular fa-user"></i></span>
                                                    <input type="text" class="form-control" id="primerNombreFamiliar" name="primerNombre" placeholder="Primer Nombre" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-3 mb-3">
                                            <div class="form-group">
                                                <label for="segundoNombre">Segundo Nombre</label>
                                                <div class="input-group ">
                                                    <span class="input-group-text span_nombre2"><i class="icons fa-regular fa-user"></i></span>
                                                    <input type="text" class="form-control" id="segundoNombreFamiliar" name="segundoNombre" placeholder="Segundo Nombre" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-3 mb-3">
                                            <div class="form-group">
                                                <label for="primerApellido">Primer Apellido</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_apellido1"><i class="icons fa-regular fa-user"></i></span>
                                                    <input type="text" class="form-control" id="primerApellidoFamiliar" name="primerApellido" placeholder="Primer Apellido" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-3 mb-3" id="contenApellidoDos">
                                            <div class="form-group">
                                                <label for="segundoApellido">Segundo Apellido</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_apellido2"><i class="icons fa-regular fa-user"></i></span>
                                                    <input type="text" class="form-control" id="segundoApellidoFamiliar" name="segundoApellido" placeholder="segundo Apellido" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-3 mb-3" hidden=="true">
                                            <div class="form-group">
                                                <label for="identificador">identificador</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_identificador span_cumplido"><i class="icons fa-regular fa-user"></i></span>
                                                    <input type="text" class="form-control cumplido" id="identificador" name="idfamiliar" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-3 mb-3" id="contenCedula">
                                            <div class="form-group">
                                                <label for="cedula">Cédula</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_cedula_familiar "><i class="icons fa-regular fa-address-card"></i></span>
                                                    <input type="text" class="form-control" id="cedula_familiar" name="cedula" placeholder="Cédula de Identidad" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-3 mb-3 ">
                                            <div class="form-group">
                                                <label for="parentesco">Parentesco</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_parentesco"><i class="icons fa-regular fa-clipboard"></i></span>
                                                    <select class="form-select form-select-md estado-parentesco" id="parentesco" name="parentesco" aria-label="Small select example" aria-placeholder="dasdas" required>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-3 col-xl-4 col-xxl-3 mb-2 ">
                                            <div class="form-group">
                                                <label for="sexo">Sexualidad</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_sexo"><i class="icons fa-regular fa-person-half-dress"></i></span>
                                                    <select class="form-select form-select-md sexo-sexo" id="sexo" name="sexo" aria-label="Small select example" aria-placeholder="dasdas" required>
                                                        <option value="">Selecione el sexo</option>
                                                        <option value="Masculino">Masculino</option>
                                                        <option value="Femenino">Femenino</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-3 mb-3" id="">
                                            <div class="form-group">
                                                <label for="tomo">Tomo</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_tomo"><i class="fa-regular fa-address-card"></i></span>
                                                    <input type="text" class="form-control " id="tomo" name="tomo" placeholder="Tomo De partida De Nacimiento" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-3 mb-3" id="">
                                            <div class="form-group">
                                                <label for="folio">Folio</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_folio"><i class="fa-regular fa-address-card"></i></span>
                                                    <input type="text" class="form-control " id="folio" name="folio" placeholder="Número de folio" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-3 mb-3" id="contenCarnet">
                                            <div class="form-group">
                                                <label for="cedula">Número de Carnet de Discapacidad</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_carnet"><i class="fa-regular fa-address-card"></i></span>
                                                    <input type="text" class="form-control ignore-validation" id="carnet" name="carnet" placeholder="Cédula de Identidad">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6 col-xl-6 col-xxl-3 mb-3" id="contenTipoDiscapacidad">
                                            <div class="form-group">
                                                <label for="tpDiscapacidad">Tipo De Discapacidad</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_tpDiscapacidad"><i class="icons fa-solid fa-wheelchair-move"></i></span>
                                                    <select type="text" class="form-control ignore-validation" id="tpDiscapacidad" name="tpDiscapacidad" placeholder="Tipo de Discapacidad ">
                                                        <option value="">Seleccione una discapacidad</option>
                                                        <option value="Visual">Discapacidad visual</option>
                                                        <option value="Auditiva">Discapacidad auditiva</option>
                                                        <option value="Motriz">Discapacidad motriz</option>
                                                        <option value="Intelectual">Discapacidad intelectual</option>
                                                        <option value="Psicosocial">Discapacidad psicosocial</option>
                                                        <option value="Visceral">Discapacidad visceral</option>
                                                        <option value="Multiples">Discapacidades múltiples</option>
                                                        <option value="Otra">Otra discapacidad</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-3 " id="contenEdad">
                                            <div class="form-group">
                                                <label for="edad">Edad</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_edad"><i class="icons fa-regular fa-user-clock"></i></span>
                                                    <input type="text" class="form-control" id="edad" name="edad" placeholder="Edad Del Familiar" required readonly>
                                                </div>
                                                <p class="parrafo fs-6 fw-light mb-0">La edad del familiar se ingresa automáticamente con la fecha de nacimiento.</p>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6 mb-3" id="contenDoc">
                                            <div class="form-group">
                                                <label for="correo">Partida De Nacimiento</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_docArchivo"><i class="fa-regular fa-file-zipper"></i></span>
                                                    <input type="file" class="form-control ignore-validation" name="docArchivo" id="achivoparti" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6 mb-3" id="contentPartida">
                                            <div class="form-group">
                                                <label for="correo">Partida De Discapacidad</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_docArchivoDis"><i class="fa-regular fa-file-zipper"></i></span>
                                                    <input type="file" class="form-control ignore-validation" name="docArchivoDis" id="achivoDis" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                                </div>
                                            </div>
                                        </div>

                                        <p class="mb-0">Fecha de nacimiento</p>
                                        <hr class="mb-2">

                                        <div class="col-sm-4 col-md-4 mb-2">
                                            <div class="form-group">
                                                <label class="required-field" for="message">Año</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_ano_familiar"><i class="icons fa-regular fa-calendar"></i></i></span>
                                                    <select class="form-select form-select-md" name="ano" id="anoFamiliar" required></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 col-md-4 mb-2">
                                            <div class="form-group">
                                                <label class="required-field" for="message">Mes</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_mes_familiar"><i class="icons fa-regular fa-calendar"></i></i></span>
                                                    <select class="form-select meses2" id="mesesFamiliar" name="meses" aria-label="Default select example" required></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 col-md-4 mb-3">
                                            <div class="form-group ">
                                                <label class="required-field" for="message">Día</label>
                                                <div class="input-group">
                                                    <span class="input-group-text span_dia_familiar"><i class="icons fa-regular fa-calendar"></i></i></span>
                                                    <select class="form-select w-5 dias" id="diaFamiliar" name="dia" aria-label="Default select example" required></select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="col-sm-12 ">
                                            <button type="submit" id="aceptar_familia" name="aceptar2" class="btn btn-success " disabled>
                                                <i class="fa-solid fa-plus me-2"></i>Aceptar
                                            </button>
                                        </div> -->
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="col-sm-12  d-flex justify-content-between ">
                                <button type="submit" id="aceptar_familia" name="submit" class="btn-sm btn btn-success btn-hover-verde" disabled>
                                    <i class="fa-solid fa-thumbs-up fa-sm me-2"></i>Actualizar
                                </button>

                                <button type="button" id="cerrarEdit" class="btn-sm btn btn-secondary btn-hover-gris">
                                    <i class="fa-regular fa-xmark-large fa-sm me-2"></i>Cerrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>



        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>

    <?php require_once App::URL_INC . "/scrips.php"; ?>
    <?php require_once App::URL_INC . "/tablets.php"; ?>

    <script src="./src/libs/select2/select2.min.js"></script>
    <script src="./src/libs/jQueryUI/jquery-ui.min.js"></script>

    <script src="<?php echo App::URL_SCRIPS . "registroTotalFamiliares.js" ?>" type="module"></script>
    <script src="<?php echo App::URL_SCRIPS . "reporteFamiliar.js" ?>" type="module"></script>

</body>

</html>